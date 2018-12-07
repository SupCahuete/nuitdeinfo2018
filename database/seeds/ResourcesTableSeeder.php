<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Resource;

class ResourcesTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "resources";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    $resourcesTypes = \App\Models\ResourcesType::all()->keyBy('name');

    DB::table($this->tableName)->delete();

    $type = "Énergies";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 2,
      'name' => 'Éléctricité',
      'quantity' => '200',
      'resource_unit' => 'A/h',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Boissons";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 0,
      'name' => 'Eau',
      'quantity' => 90,
      'resource_unit' => 'litre',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Boissons";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 10,
      'name' => 'Thé',
      'quantity' => 500,
      'resource_unit' => 'gramme',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Boissons";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 10,
      'name' => 'Café',
      'quantity' => 500,
      'resource_unit' => 'gramme',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Nouritures";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 0,
      'name' => 'Ration 24h',
      'quantity' => 23,
      'resource_unit' => 'portion',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Nouritures";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 10,
      'name' => 'Gourmandise',
      'quantity' => 1000,
      'resource_unit' => 'gramme',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Pièces de rechange";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 5,
      'name' => 'Capteur',
      'quantity' => 20,
      'resource_unit' => 'pièces',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Pièces de rechange";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 5,
      'name' => 'Sonde',
      'quantity' => 50,
      'resource_unit' => 'pièces',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Pièces de rechange";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 5,
      'name' => 'Outillage',
      'quantity' => 300,
      'resource_unit' => 'pièces',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Pièces de rechange";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 5,
      'name' => 'Pièces moteur',
      'quantity' => 50,
      'resource_unit' => 'pièces',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Médicaments";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 3,
      'name' => 'Anti-douleur',
      'quantity' => 30,
      'resource_unit' => 'pilule',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Médicaments";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 3,
      'name' => 'Antihistaminique',
      'quantity' => 20,
      'resource_unit' => 'pilule',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Médicaments";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 3,
      'name' => 'Anti-inflammatoire',
      'quantity' => 20,
      'resource_unit' => 'pilule',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Médicaments";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 7,
      'name' => 'Anti-moustique',
      'quantity' => 200,
      'resource_unit' => 'mL',
      'created_at' => $date, 'updated_at' => $date,
    ]);

    $type = "Médicaments";
    DB::table($this->tableName)->insert([
      'id' => Resource::uuid4(),
      'resources_type_id' => $resourcesTypes[$type]->id,
      'resource_importance' => 10,
      'name' => 'Anti-maladie',
      'quantity' => 500,
      'resource_unit' => 'mL',
      'created_at' => $date, 'updated_at' => $date,
    ]);

  }
}