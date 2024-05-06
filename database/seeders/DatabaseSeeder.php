<?php

namespace Database\Seeders;

use App\Models\Call;
use App\Models\Task;
use App\Models\Report;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    
         \App\Models\User::factory(15)->create();
         \App\Models\Call::factory(10)->create();
         \App\Models\Task::factory(10)->create();
         \App\Models\Report::factory(10)->create();
    }
}
