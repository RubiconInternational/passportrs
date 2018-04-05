<?php

namespace Laravel\Passport\Http\Controllers;

use App\Http\Controllers\Base\PagesController;
use App\Models\User;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Models\Relationship;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenResult;

class PersonalAccessTokenController
{
    /**
     * The token repository implementation.
     *
     * @var \Laravel\Passport\TokenRepository
     */
    protected $tokenRepository;

    /**
     * The validation factory implementation.
     *
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validation;

    /**
     * Create a controller instance.
     *
     * @param  \Laravel\Passport\TokenRepository  $tokenRepository
     * @param  \Illuminate\Contracts\Validation\Factory  $validation
     * @return void
     */
    public function __construct(TokenRepository $tokenRepository, ValidationFactory $validation)
    {
        $this->validation = $validation;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Get all of the personal access tokens for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forUser(Request $request)
    {
        $tokens = $this->tokenRepository->forUser($request->user()->getKey());

        return $tokens->load('client')->filter(function ($token) {
            return $token->client->personal_access_client && ! $token->revoked;
        })->values();
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'name' => 'required|unique:oauth_access_tokens|max:255',
            'scopes' => 'required|array|in:'.implode(',', Passport::scopeIds()),
            'api_token_type'        => '',
            'api_client_id'         => '',
            'api_application_id'    => '',
        ])->validate();

        // Send a request for a new token
        $newToken = $request->user()->createToken(
            $request->name, $request->scopes ?: []
        );

        // Get the new token primary key for building the relationship
        $tokenPrimaryKey = DB::table('oauth_access_tokens')->where('name', $request->name)->value('primary_key');

        // Create the token Relationship
        Relationship::create([
            'token_key'             => $tokenPrimaryKey,
            'api_token_type'        => $request->api_token_type,
            'api_client_id'         => $request->api_client_id,
            'api_application_id'    => $request->api_application_id,
        ]);

        $currentUser   = \Auth::user();
        PagesController::logActivity(null, 'API Token CREATED (Token primary_key: ' . $tokenPrimaryKey . ' created by UserId: ' . $currentUser->id . ')');

        //Return the new token
        return $newToken;
    }

    /**
     * Delete the given token.
     *
     * @param  Request  $request
     * @param  string  $tokenId
     * @return Response
     */
    public function destroy(Request $request, $tokenId)
    {
        $token = $this->tokenRepository->findForUser(
            $tokenId, $request->user()->getKey()
        );

        if (is_null($token)) {
            return new Response('', 404);
        }

        $currentUser   = \Auth::user();
        PagesController::logActivity(null, 'API Token REVOKED (Token primary_key: ' . $token->primary_key . ' created by UserId: ' . $currentUser->id . ')');

        $token->revoke();
    }
}
