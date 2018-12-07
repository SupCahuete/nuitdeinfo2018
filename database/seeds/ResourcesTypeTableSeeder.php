<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\ResourcesType;

class ResourcesTypeTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "resources_types";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    $resources = collect([
      [ 'name' => 'Énergies' ],
      [ 'name' => 'Boissons' ],
      [ 'name' => 'Nouritures' ],
      [ 'name' => 'Pièces de rechange' ],
      [ 'name' => 'Médicaments' ],
    ]);

    DB::table($this->tableName)->delete();

    foreach ($resources as $r) {
      DB::table($this->tableName)->insert([
        /*-------------------------------------------
                          Colunms
        -------------------------------------------*/
        'id' => ResourcesType::uuid4(),
        'name' => $r['name'],

        'created_at' => $date,
        'updated_at' => $date,

        /*-------------------------------------------
        -------------------------------------------*/
      ]);
    }

  }
}