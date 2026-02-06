<?php

namespace Database\Seeders;

use Database\Factories\DevelopmentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DevelopmentFactory::new()->count(10)->create();
    }
}
