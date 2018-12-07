<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Symptom;

class SymptomsTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "symptoms";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    $symptoms = collect([
      [ 'name' => 'Diarrhée' ],
      [ 'name' => 'Toux' ],
      [ 'name' => 'Fièvre' ],
      [ 'name' => 'Vomissement' ],
      [ 'name' => 'Saignement' ],
      [ 'name' => 'Maux de tête' ],
      [ 'name' => 'Hallucination' ],
      [ 'name' => 'Tension élevée' ],
      [ 'name' => 'Tension faible' ],
    ]);

    DB::table($this->tableName)->delete();

    foreach ($symptoms as $s) {
      DB::table($this->tableName)->insert([
        /*-------------------------------------------
                          Colunms
        -------------------------------------------*/
        'id' => Symptom::uuid4(),
        'name' => $s['name'],

        'created_at' => $date,
        'updated_at' => $date,

        /*-------------------------------------------
        -------------------------------------------*/
      ]);
    }

  }
}