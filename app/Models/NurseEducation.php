<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseEducation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
