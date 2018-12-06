<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateScienceSurveyTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('science_survey', function (Blueprint $table) {
        $table->uuid('id');
        $table->uuid('science_bot_id');
        $table->string('survey');
        $table->dateTime('next_survey');
        $table->timestamps();

        $table->primary('id');
        $table->foreign('science_bot_id')
          ->references('id')
          ->on('machines')
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
      Schema::dropIfExists('science_survey', function (Blueprint $table) {
        $table->dropForeign('science_bot_id_foreign');
      });
    }
  }
