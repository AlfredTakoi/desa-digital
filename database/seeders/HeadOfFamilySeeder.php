<?php

namespace Database\Seeders;

use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()  
    {
        UserFactory::new()->count(15)->create()->each(function ($user) {
            HeadOfFamilyFactory::new()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
