<?php

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

    }
    private function systemSeed()
    {
        DB::table('system')->insert([
            'id'=>1,
            'name' => 'queueAccount',
            'value' => 99887766,
        ]);
    }
}
