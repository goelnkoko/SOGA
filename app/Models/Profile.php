<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function addHobby($hobby)
    {
        $currentHobbies = $this->hobbies;

        // Se currentHobbies não é um array, converta para array vazio
        if (!is_array($currentHobbies)) {
            $currentHobbies = json_decode($currentHobbies, true) ?: [];
        }

        // Adiciona o novo hobby se ele ainda não estiver presente no array
        if (!in_array($hobby, $currentHobbies)) {
            $currentHobbies[] = $hobby;
        }

        $this->update(['hobbies' => json_encode($currentHobbies)]);
    }

    public function addInterest($interest)
    {
        $currentInterests = $this->interests;

        if (!is_array($currentInterests)) {
            $currentInterests = json_decode($currentInterests, true) ?: [];
        }

        if (!in_array($interest, $currentInterests)) {
            $currentInterests[] = $interest;
        }

        $this->update(['interests' => json_encode($currentInterests)]);
    }

    public function removeHobby($hobby)
    {
        $currentHobbies = $this->hobbies;
        if (!is_array($currentHobbies)) {
            $currentHobbies = json_decode($currentHobbies, true) ?: [];
        }
        $updatedHobbies = array_values(array_diff($currentHobbies, [$hobby]));
        $this->update(['hobbies' => json_encode($updatedHobbies)]);
    }

    public function removeInterest($interest)
    {
        $currentInterests = $this->interests;
        if (!is_array($currentInterests)) {
            $currentInterests = json_decode($currentInterests, true) ?: [];
        }
        $updatedInterests = array_values(array_diff($currentInterests, [$interest]));
        $this->update(['interests' => json_encode($updatedInterests)]);
    }
}
