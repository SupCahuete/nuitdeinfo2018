<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Machine;

class MachinesTableSeeder extends Seeder
{
  /**
   * Arrays of table's name
   *
   * @var string $tablesName
   */
  private $tableName = "machines";


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $date = Carbon::now();

    DB::table($this->tableName)->delete();

    DB::table($this->tableName)->insert([
      /*-------------------------------------------
                        Colunms
      -------------------------------------------*/

      'id' => Machine::uuid4(),
      'name' => 'CH2019',
      'energy' => '87',
      'type' => 'Rover',
      'job' => 'Sécurité',
      'state' => 'FOLLOW',

      'created_at' => $date,
      'updated_at' => $date,

      /*-------------------------------------------
      -------------------------------------------*/
    ]);

    DB::table($this->tableName)->insert([
      /*-------------------------------------------
                        Colunms
      -------------------------------------------*/

      'id' => Machine::uuid4(),
      'name' => 'QrX16',
      'energy' => '92',
      'type' => 'Rover',
      'job' => 'Transport',
      'state' => 'GO',

      'created_at' => $date,
      'updated_at' => $date,

      /*-------------------------------------------
      -------------------------------------------*/
    ]);

  }
}