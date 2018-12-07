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
        $table->string('name');
        $table->string('energy');
        $table->string('type');
        $table->string('job');
        $table->string('state');
        $table->dateTime('last_check')->nullable();
        $table->dateTime('next_check')->nullable();
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
      Schema::dropIfExists('machines', function (Blueprint $table) {
      });
    }
  }
