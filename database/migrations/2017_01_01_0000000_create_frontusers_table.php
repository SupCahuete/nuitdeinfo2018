<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontusersTable extends Migration
{
  /**
   * Table's name.
   *
   * @var string $tableName
   */
  private $tableName = "frontusers";

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      /*-------------------------------------------
                        Colunms
      -------------------------------------------*/

      $table->uuid('id');
      $table->primary('id');

      $table->string('email');
      $table->string('password');
      $table->string('api_token', 60);

      $table->string('name');

      $table->rememberToken();
      $table->timestamps();

      /*-------------------------------------------
      -------------------------------------------*/
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists($this->tableName);
  }
}
