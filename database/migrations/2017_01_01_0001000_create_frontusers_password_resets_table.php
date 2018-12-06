<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontusersPasswordResetsTable extends Migration
{
  /**
   * Table's name.
   *
   * @var string $tableName
   */
  private $tableName = "frontusers_password_resets";

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

      $table->string('email')->index();
      $table->string('token')->index();


      $table->timestamp('created_at')->nullable();

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
