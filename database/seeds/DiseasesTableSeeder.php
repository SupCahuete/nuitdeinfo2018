<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Disease;

class DiseasesTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "diseases";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    $diseases = collect([
      [ 'name' => 'Gastro-entérite' ],
      [ 'name' => 'Intoxication' ],
      [ 'name' => 'Insolation' ],
    ]);

    DB::table($this->tableName)->delete();

    foreach ($diseases as $d) {
      DB::table($this->tableName)->insert([
        /*-------------------------------------------
                          Colunms
        -------------------------------------------*/
        'id' => Disease::uuid4(),
        'name' => $d['name'],

        'created_at' => $date,
        'updated_at' => $date,

        /*-------------------------------------------
        -------------------------------------------*/
      ]);
    }

  }
}