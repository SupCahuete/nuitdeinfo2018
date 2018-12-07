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
        $table->integer('quantity');
        $table->string('resource_unit');
        $table->timestamp('last_shipment')->nullable();
        $table->timestamp('next_shipment')->nullable();
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
