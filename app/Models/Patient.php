<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Patient extends Model
{
    protected $collection = 'patients';

    protected $fillable = ['user_id', 'demographics', 'consultation_id'];

    public function getPatientConsultationAttribute()
    {
        return PatientConsultation::with('consultation')
            ->wherePatientId($this->id)
            ->get();
    }

    public function getConsultationsWithAuthenticatedDoc()
    {
        return PatientConsultation::with('consultation')
            ->whereHas('consultation', function ($query) {
                return $query->where('doctor_id', '=', auth()->user()->id);
            })
            ->wherePatientId($this->id)
            ->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
