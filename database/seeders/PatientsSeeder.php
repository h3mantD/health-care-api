<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\PatientConsultation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereUsername('p1')->first();
        $doc = User::whereUsername('admin')->first();

        $patient = Patient::updateorCreate(
            ['user_id' => $user->id],
            [
                'demographics' => ['age' => 25, 'height' => "5.6'", 'weight' => 60],
            ]
        );

        $consultation = Consultation::updateOrCreate(
            ['doctor_id' => $doc->id],
            [
                'symptons' => 'asdf,asdf,asdf,asdf',
                'diagnosis' => 'asdf,asdf,asdf,asdf',
                'suggested_treatment' => 'asdf,asdf,asdf,',
                'tests' => null,
            ]
        );

        PatientConsultation::updateOrCreate(
            ['patient_id' => $patient->id, 'consultation_id' => $consultation->id],
            ['patient_id' => $patient->id, 'consultation_id' => $consultation->id]
        );
    }
}
