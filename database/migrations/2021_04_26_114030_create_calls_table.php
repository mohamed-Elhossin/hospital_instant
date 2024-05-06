<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('patient_name');
            $table->string('age');
            $table->string('phone')->nullable();
            $table->string('description')->nullable();
            $table->string('logout')->default('pending');
            $table->string('status')->default('pending');
            $table->string('case_status')->default('process');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
                
               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
