<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'photo',
        'biography',
        'hobbies',
        'gender',
        'interests',
        'birthdate',
        'location'
    ];

    // Converte o campo hobbies para um array quando acessado
    protected $casts = [
        'hobbies' => 'json',
        'interests' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // Método para adicionar um hobby ao perfil
    public function addHobby($hobby)
    {
        $currentHobbies = $this->hobbies ?? [];
        $currentHobbies[] = $hobby;
        $this->update(['hobbies' => $currentHobbies]);
    }

    public function removeHobby($hobby)
    {
        $currentHobbies = $this->hobbies ?? [];
        $this->update(['hobbies' => array_values(array_diff($currentHobbies, [$hobby]))]);
    }

    // Método para adicionar um interesse ao perfil
    public function addInterest($interest)
    {
        $currentInterests = $this->interests ?? [];
        $currentInterests[] = $interest;
        $this->update(['interests' => $currentInterests]);
    }

    public function removeInterest($interest)
    {
        $currentInterests = $this->interests ?? [];
        $this->update(['interests' => array_values(array_diff($currentInterests, [$interest]))]);
    }

}
