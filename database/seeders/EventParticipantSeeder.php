<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeadOfFamily;
use App\Models\Event;
use App\Models\EventParticipant;


class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = Event::all();
        $headOfFamilies = HeadOfFamily::all();

        foreach($events as $event)
        {
            foreach($headOfFamilies as $headOfFamily)
            {
                EventParticipant::factory()->create([
                    'event_id' => $event->id,
                    'head_of_family_id' => $headOfFamily->id,
                ]);
            }
        }
    }
}
