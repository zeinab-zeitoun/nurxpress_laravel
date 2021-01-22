<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function education()
    {
        return $this->hasMany(NurseEducation::class);
    }

    public function experience()
    {
        return $this->hasMany(NurseExperience::class);
    }
}
