<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_terminal', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('mac_address', 200);
            $table->string('name', 50)->nullable();
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
        Schema::dropIfExists('scan_terminal');
    }
}
