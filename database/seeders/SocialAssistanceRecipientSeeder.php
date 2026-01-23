<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SocialAssistanceRecipient;
use App\Models\SocialAssistance;
use App\Models\HeadOfFamily;

class SocialAssistanceRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socialAssistances = SocialAssistance::all();
        $headOfFamilies = HeadOfFamily::all();

        foreach($socialAssistances as $socialAssistance)
        {
            foreach($headOfFamilies as $headOfFamily)
            {
                SocialAssistanceRecipient::factory()->create([
                    'head_of_family_id' => $headOfFamily->id,
                    'social_assistance_id' => $socialAssistance->id,
                    'status' => 'pending',
                ]);
            }
        }
    }
}
