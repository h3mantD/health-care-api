<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $collection = 'roles';
}
