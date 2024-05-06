<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCulToMeasurmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   
        Schema::table('measurements', function (Blueprint $table) {
            $table->string('tempreture')->after('sugar_analysis')->nullable();
            $table->string('heart_rate')->after('tempreture')->nullable();
            $table->string('respiratory_rate')->after('heart_rate')->nullable();
            $table->string('fluid_balance')->after('respiratory_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurements', function (Blueprint $table) {
            $table->dropColumn('tempreture');
            $table->dropColumn('heart_rate');
            
            $table->dropColumn('respiratory_rate');
            $table->dropColumn('fluid_balance');
        });
    }
}
