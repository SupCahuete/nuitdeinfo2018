<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateResourcesConsumptionTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('resources_consumptions', function (Blueprint $table) {
        $table->uuid('id');
        $table->uuid('resource_id');
        $table->integer('daily_resource_consumption');
        $table->timestamps();

        $table->primary('id');
        $table->foreign('resource_id')
          ->references('id')
          ->on('resources')
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
      Schema::dropIfExists('resources_consumptions', function (Blueprint $table) {
        $table->dropForeign('resource_id_foreign');
      });
    }
  }
