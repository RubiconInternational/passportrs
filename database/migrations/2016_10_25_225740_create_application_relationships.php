  <?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateApplicationRelationships extends Migration
  {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
          Schema::create('application_token_relationships', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('token_key')->unsigned();
              $table->foreign('token_key')->references('primary_key')->on('oauth_access_tokens')->onDelete('cascade');
              $table->string('api_client_id')->nullable();
              $table->string('api_application_id')->nullable();
          });
      }

      /**
       * Reverse the migrations.
       *
       * @return void
       */
      public function down()
      {
          Schema::dropIfExists('application_token_relationships');
      }
  }