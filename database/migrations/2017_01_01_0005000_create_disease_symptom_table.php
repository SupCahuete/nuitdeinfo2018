<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateDiseaseSymptomTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('diseases_symptoms', function (Blueprint $table) {
        $table->uuid('id');
        $table->uuid('disease_id');
        $table->uuid('symptom_id');
        $table->timestamps();

        $table->primary('id');
        $table->foreign('disease_id')
          ->references('id')
          ->on('diseases')
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
      Schema::dropIfExists('diseases_symptoms', function (Blueprint $table) {
        $table->dropForeign('disease_id_foreign');
        $table->dropForeign('symptom_id_foreign');
      });
    }
  }
