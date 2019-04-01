<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Admin::create([
            'name' => 'Admin',
            'email' => 'admin@task.build',
            'password' => bcrypt('123123'),
        ]);
    }
}
