<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use \App\Models\Guest;

class FrontusersTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tablesName = "frontusers";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    DB::table($this->tablesName)->delete();

    for ($i=1; $i<=1; $i++) {
      DB::table($this->tablesName)->insert([
        /*-------------------------------------------
                          Colunms
        -------------------------------------------*/

        'id' => Guest::uuid4(),

        'email' => "eric$i@test.com",
        'password' => bcrypt("eric$i"),
        'api_token' => Guest::getNewApiToken(),

        'name' => "Eric$i",

        /*-------------------------------------------
        -------------------------------------------*/

        'created_at' => $date,
        'updated_at' => $date,
      ]);
    }



  }
}
