<?php

use App\Mail\SendOtpMail;
use App\Models\PatientConsultation;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;

$user = User::find('640dd86c9088ff678f0f9995');
$consultations = $user->doctor->consultation->pluck('id')->toArray();

PatientConsultation::with('patient.user')
    ->whereIn('consultation_id', $consultations)
    ->get();

// Mail::to('pubg983983@gmail.com')->send(new SendOtpMail(otp: 123456));
