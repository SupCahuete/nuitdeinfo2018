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
    $this->call(FrontusersTableSeeder::class);
    /*TAG_CALL_SEEDER*/
  }
}
