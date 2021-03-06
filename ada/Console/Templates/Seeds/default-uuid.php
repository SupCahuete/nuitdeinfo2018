<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\TAG_MODEL_NAME;

class TAG_CLASS_NAME extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "TAG_TABLE_NAME";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    /*
     * Uncomment if needed.
     * Clean table's data.
     */
    //DB::table($this->tableName)->delete();

    for ($i=1; $i<=1; $i++) {
      DB::table($this->tableName)->insert([
        /*-------------------------------------------
                          Colunms
        -------------------------------------------*/

        /*TAG_COLUMN*/

        'created_at' => $date,
        'updated_at' => $date,

        /*-------------------------------------------
        -------------------------------------------*/
      ]);
    }

  }
}