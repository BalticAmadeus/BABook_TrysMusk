<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => "Alus",
        ]);

        DB::table('users')->insert([
            'name' => 'Vardenis',
            'email' => 'vardenis@mail.com',
            'password' => 'password',
            'remember_token' => 'belekas',
        ]);

        DB::table('events')->insert([
            'groupId' => 1,
            'userId' => 1,
            'title' => 'Einam alaus',
            'date' => '2017-11-12 19:00:00',
            'comment' => 'Komentaras',
            'location' => 'Lokacija'
        ]);
    }
}
