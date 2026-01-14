<?php

namespace Database\Seeders;

use Database\Factories\SocialAssistanceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialAssistanceFactory::new()->count(10)->create();
    }
}
