<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class PatientConsultation extends Model
{
    protected $collection = 'patient_consultation';

    // protected $collection = 'user_role'

    protected $fillable = ['patient_id', 'consultation_id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
