<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(ResourcesTypeTableSeeder::class);
		$this->call(SymptomsTableSeeder::class);
		$this->call(DiseasesTableSeeder::class);
		$this->call(DiseasesSymptomsTableSeeder::class);
		$this->call(ResourcesTableSeeder::class);
		$this->call(MachinesTableSeeder::class);
		/*TAG_CALL_SEEDER*/
  }
}
