<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateDiseaseTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('diseases', function (Blueprint $table) {
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
      Schema::dropIfExists('diseases', function (Blueprint $table) {
      });
    }
  }
