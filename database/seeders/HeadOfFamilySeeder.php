<?php

namespace Database\Seeders;

use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Database\Factories\FamilyMemberFactory;

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
            $headOfFamily = HeadOfFamilyFactory::new()->create(['user_id' => $user->id]);

            FamilyMemberFactory::new()->count(5)->create([
                'head_of_family_id' => $headOfFamily->id,
                'user_id' => UserFactory::new()->create()->id,
            ]);
        });
    }
}
