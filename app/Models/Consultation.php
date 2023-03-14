<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Consultation extends Model
{
    protected $collection = 'consultations';

    protected $fillable = ['doctor_id', 'symptons', 'diagnosis', 'suggested_treatment', 'tests'];

    protected $with = ['doctor'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
