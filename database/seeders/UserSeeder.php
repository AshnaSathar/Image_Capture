<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Article, User};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
        ->count(10) // Create 10 users
        // ->has(Article::factory()->forUser()->count(5)) // Each user has 5 articles
        ->create();
    }
}
