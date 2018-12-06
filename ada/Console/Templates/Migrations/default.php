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
   * Array of foreignKey's name.
   *
   * @var array $foreignKeys
   */
  private $foreignKeys = [
    //FOREIGN_KEYS
  ];

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table)
    {
      // ID
      $table->increments('id');

      // For create foreignKey, see $foreignKeys
      foreach ($this->foreignKeys as $key => $on) {
        $table->integer($key)->unsigned();
        $table->foreign($key)
              ->references('id')
              ->on($on)
              ->onDelete('restrict')
              ->onUpdate('restrict');
      }


      /*-------------------------------------------
                        Colunms
      -------------------------------------------*/

      //$table->string('name', 60);

      /*-------------------------------------------
      -------------------------------------------*/


      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    foreach ($this->foreignKeys as $key => $value) {
      Schema::table($this->tableName, function(Blueprint $table) use ($key) {
        $table->dropForeign($this->tableName."_{$key}_foreign");
      });
    }

    Schema::dropIfExists($this->tableName);
  }
}
