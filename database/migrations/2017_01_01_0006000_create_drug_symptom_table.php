<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateDrugSymptomTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('drugs_symptoms', function (Blueprint $table) {
        $table->uuid('id');
        $table->uuid('resource_id');
        $table->uuid('symptom_id');
        $table->timestamps();

        $table->primary('id');

        $table->foreign('resource_id')
          ->references('id')
          ->on('resources')
          ->onUpdate('cascade')
          ->onDelete('cascade');

        $table->foreign('symptom_id')
          ->references('id')
          ->on('symptoms')
          ->onUpdate('cascade')
          ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('drugs_symptoms', function (Blueprint $table) {
        $table->dropForeign('resource_id_foreign');
        $table->dropForeign('symptom_id_foreign');
      });
    }
  }
