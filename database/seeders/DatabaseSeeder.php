<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Company::factory(20)->create();
        BankAccount::factory(200)->create();
        Project::factory(60)->create();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' =>  Hash::make('password')
        ]);
        User::factory()->create([
            'name' => 'aanish',
            'email' => 'aanish@example.com',
            'password' =>  Hash::make('password')
        ]);

        for ($i=0; $i < 1000 ; $i++) {
            DB::table('employee_project')->insert([
                'project_id' => fake()->numberBetween(1,60),
                'employee_id' => fake()->numberBetween(1,200)
            ]);
        }
    }
}
