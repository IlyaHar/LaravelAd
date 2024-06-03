<?php

namespace Database\Seeders;

use App\Models\Advertisement;
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
        $users = User::factory(10)->create();

        $users->each(function (User $user) {
           Advertisement::factory(rand(0, 3))->create(['author_id' => $user->id]);
        });
    }
}
