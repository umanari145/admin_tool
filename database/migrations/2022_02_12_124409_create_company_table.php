<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_code', 50)->default('');
            $table->string('company_name', 200)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('email', 200)->nullable();
            $table->string('telno', 15)->nullable();
            $table->string('faxno', 15)->nullable();
            $table->string('zipcode', 7)->nullable();
            $table->string('pref', 2)->nullable();
            $table->string('address1', 200)->nullable();
            $table->string('address2', 200)->nullable();
            $table->string('plan_type', 10)->nullable();
            $table->date('register_ymd')->nullable();
            $table->date('unsubscribe_ymd')->nullable();
            $table->string('invitor_name', 50)->nullable();

            $table->string('status', 10)->nullable();
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
        Schema::dropIfExists('company');
    }
}
