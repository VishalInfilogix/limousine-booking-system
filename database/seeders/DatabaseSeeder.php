<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ServiceTypesSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(UpdateDeletedAtInUsersTableSeeder::class);
        
    }
}
