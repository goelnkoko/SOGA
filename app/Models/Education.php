<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'institution',
        'course',
        'startDate',
        'endDate',
        'profile_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
