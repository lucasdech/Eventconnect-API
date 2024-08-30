<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Message;
use App\Models\EventUser;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        Event::factory(10)->create();
        Message::factory(10)->create();
        EventUser::factory(30)->create();
    }
}
