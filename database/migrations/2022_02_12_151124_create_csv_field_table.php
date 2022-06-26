<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCSVFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_field', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('csv_category')->nullable();
            $table->string('field_name', 100)->nullable();
            $table->string('field_disp_name', 100)->nullable();
            $table->tinyInteger('is_required')->default(0);
            $table->string('output_type', 20)->nullable();
            $table->string('param', 50)->nullable();

            $table->integer('serial')->nullable();
            $table->tinyInteger('meta_deleted')->default(0);
            $table->integer('meta_createuser')->nullable();
            $table->integer('meta_updateuser')->nullable();
            $table->string('meta_createdt', 20)->nullable();
            $table->string('meta_updatedt', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_field');
    }
}
