<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateResourcesTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('resources', function (Blueprint $table) {
        $table->uuid('id');
        $table->uuid('resources_type_id');
        $table->integer('resource_importance');
        $table->string('name');
        $table->string('quantity');
        $table->string('resource_unit');
        $table->dateTime('last_shipment');
        $table->dateTime('next_shipment');
        $table->timestamps();

        $table->primary('id');

        $table->foreign('resources_type_id')
              ->references('id')
              ->on('resources_types')
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
      Schema::dropIfExists('resources', function (Blueprint $table) {
        $table->dropForeign('resources_type_id_foreign');
      });
    }
  }
