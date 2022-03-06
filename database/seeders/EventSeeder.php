<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::select('select * from users where email = ? limit 1 ', ['user@example.com']);
        DB::table('events')->insert([
            'name' => 'Open Mic',
            'date' => '2022-03-05',
            'time' => '12:00:00',
            'location' => 'Yogyakarta, Indonesia',
            'created_by' => $user[0]->id
        ]);
    }
}
