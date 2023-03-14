<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Doctor extends Model
{
    protected $collection = 'doctors';

    protected $fillable = ['user_id', 'hospital_name', 'address'];

    public function consultation()
    {
        return $this->hasMany(Consultation::class, 'doctor_id', 'user_id');
    }

    public function getPatients()
    {
    }
}
