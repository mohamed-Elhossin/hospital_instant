<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->date('birthday');
            $table->string('specialist');
            $table->string('status');
            $table->string('mobile');
            $table->text('address');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('type');
            $table->text('remember_token')->nullable();
            $table->text('device_token')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'first_name' => 'fadel',
            'last_name' => 'labanie',
            'gender' => 'male',
            'birthday' => now(),
            'specialist' => 'test',
            'status' => 'done',
            'mobile' => '011315200',
            'address' => 'egypt',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'test',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
