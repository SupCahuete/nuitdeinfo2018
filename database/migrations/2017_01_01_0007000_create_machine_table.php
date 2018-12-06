<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateMachineTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('machines', function (Blueprint $table) {
        $table->uuid('id');
        $table->string('machine_name');
        $table->string('machine_energy');
        $table->string('machine_type');
        $table->string('machine_job');
        $table->string('machine_state');
        $table->dateTime('last_check');
        $table->dateTime('next_check');
        $table->timestamps();

        $table->primary('id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('files', function (Blueprint $table) {
      });
    }
  }
