<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CLASS_NAME extends Migration
{
  /**
   * Table's name.
   *
   * @var string $tableName
   */
  private $tableName = "TABLE_NAME";

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

      // ID
      $table->uuid('id');
      $table->primary('id');

      //$table->string('name', 60);

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
