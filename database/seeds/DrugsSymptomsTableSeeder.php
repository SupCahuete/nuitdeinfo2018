<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\DrugsSymptom;

class DrugsSymptomsTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "drugs_symptoms";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    $symptoms = [
      'Diarrhée' => ['Anti-maladie'],
      'Toux' => ['Anti-maladie'],
      'Fièvre' => ['Anti-maladie', 'Anti-douleur'],
      'Vomissement'  => ['Antihistaminique', 'Anti-moustique'],
      'Saignement'  => ['Anti-douleur', 'Anti-inflammatoire'],
      'Maux de tête'  => ['Anti-douleur'],
      'Hallucination'  => ['Anti-moustique'],
      'Tension élevée'  => ['Anti-inflammatoire'],
      'Tension faible'  => ['Antihistaminique'],
    ];

    $symptomsModel = \App\Models\Symptom::all()->keyBy('name')->toArray();
    $resourcesModel = \App\Models\Resource::where(
      'resources_type_id',
      \App\Models\ResourcesType::where('name', 'Médicaments')->first()->id
      )->get()->keyBy('name')->toArray();

    DB::table($this->tableName)->delete();

    foreach ($symptoms as $symptom => $resources) {

      foreach ($resources as $resource) {
        DB::table($this->tableName)->insert([
          /*-------------------------------------------
                            Colunms
          -------------------------------------------*/

          'id' => DrugsSymptom::uuid4(),
          'symptom_id' => $symptomsModel[$symptom]['id'],
          'resource_id' => $resourcesModel[$resource]['id'],

          'created_at' => $date,
          'updated_at' => $date,

          /*-------------------------------------------
          -------------------------------------------*/
        ]);
      }

    }

  }
}