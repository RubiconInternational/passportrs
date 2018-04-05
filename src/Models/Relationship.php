<?php

namespace Laravel\Passport\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Relationship extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table        = 'application_token_relationships';
    protected $connection   = 'sqlsrv';
    public $timestamps      = false;

  /**
   * Fillable fields for a Profile
   *
   * @var array
   */
  protected $fillable = [
    'token_key',
    'api_client_id',
    'api_application_id'
  ];

}