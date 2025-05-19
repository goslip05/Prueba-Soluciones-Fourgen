<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'email',
        'birthday',
        'phone',
    ];

    public function petsOfPerson()
    {
        return $this->hasMany(Pet::class, 'person_id');
    }
    
}
