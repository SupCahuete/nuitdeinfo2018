<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateMachineSurveysTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('machine_surveys', function (Blueprint $table) {
        $table->uuid('id');
        $table->uuid('machine_id');
        $table->text('survey');
        $table->dateTime('next_survey');
        $table->timestamps();

        $table->primary('id');
        $table->foreign('machine_id')
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
      Schema::dropIfExists('machine_surveys', function (Blueprint $table) {
        $table->dropForeign('machine_id_foreign');
      });
    }
  }
