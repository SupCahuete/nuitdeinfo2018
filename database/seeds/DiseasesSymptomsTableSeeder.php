<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\DiseasesSymptom;

class DiseasesSymptomsTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "diseases_symptoms";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    $diseases = [
      'Gastro-entérite' => ['Diarrhée', 'Fièvre', 'Vomissement'],
      'Intoxication' => ['Diarrhée', 'Fièvre', 'Vomissement', 'Hallucination', 'Tension faible'],
      'Insolation' => ['Fièvre', 'Vomissement', 'Hallucination', 'Maux de tête'],
    ];

    $diseasesModel = \App\Models\Disease::all()->keyBy('name')->toArray();
    $symptomsModel = \App\Models\Symptom::all()->keyBy('name')->toArray();

    DB::table($this->tableName)->delete();

    foreach ($diseases as $disease => $symptoms) {

      foreach ($symptoms as $symptom) {
        DB::table($this->tableName)->insert([
          /*-------------------------------------------
                            Colunms
          -------------------------------------------*/

          'id' => DiseasesSymptom::uuid4(),
          'disease_id' => $diseasesModel[$disease]['id'],
          'symptom_id' => $symptomsModel[$symptom]['id'],

          'created_at' => $date,
          'updated_at' => $date,

          /*-------------------------------------------
          -------------------------------------------*/
        ]);
      }

    }

  }
}