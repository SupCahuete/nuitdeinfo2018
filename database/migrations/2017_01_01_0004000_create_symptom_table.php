<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateSymptomTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('symptoms', function (Blueprint $table) {
        $table->uuid('id');
        $table->string('name');
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
      Schema::dropIfExists('symptoms', function (Blueprint $table) {
      });
    }
  }
