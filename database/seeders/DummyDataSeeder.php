<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\PrescribedSpecialization;
use App\Models\Registration;
use App\Models\School;
use App\Models\Specialization;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatabaseSeeder::class);
        //

        $sch = School::create([
            'address' => 'Ke Kamenci 151, 530 03 Pardubice',
            'ico' => '62061178',
            'izo' => '044 434 324',
            'name' => 'DELTA - Střední škola informatiky a ekonomie, s.r.o.',
            'email' => 'info@delta-skola.cz',
            'web' => 'www.delta-skola.cz',
            'phone' => '+420 466 611 106',
            'description'=> 'School <b>bozi</b>.School <b>bozi</b>.School <b>bozi</b>.School <b>bozi</b>.School <b>bozi</b>.School <b>bozi</b>.School <b>bozi</b>.',
            'district_id' => '45',
        ]);

        File::create([
            'school_id' => $sch->id,
            'type' => 'logo',
            'name' => 'delta-logo.png'
        ]);

        Specialization::create([
            'name' => 'Informační technologie',
            'description' => '<b>Bozi</b> obor',
            'prescribed_specialization_id' => PrescribedSpecialization::where('code', '18-20-m/01')->first()->id,
            'school_id' => $sch->id
        ]);

        Registration::create([
            'school_id' => $sch->id,
            'exhibition_id' => 1, // Praha Schola Progenis
            'morning_event' => "http://abc.xyz",
            'evening_event' => 'http://def.xyz',
            'is_disabled' => false
        ]);
        Registration::create([
            'school_id' => $sch->id,
            'exhibition_id' => 2, // Praha Schola Progenis
            'morning_event' => "http://abc.xyz",
            'evening_event' => 'http://def.xyz',
            'is_disabled' => false
        ]);
    }
}
