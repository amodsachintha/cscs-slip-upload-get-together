<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('full_name');
            $table->string('it_number');
            $table->string('grad_year');
            $table->enum('grad_month', ['march', 'august']);
            $table->string('personal_email');
            $table->string('work_email')->nullable();
            $table->string('phone');
            $table->boolean('is_plus_one')->default(false);
            $table->double('total_amount')->default(3000.00);
            $table->string('pay_slip_filename')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('people');
    }
}
