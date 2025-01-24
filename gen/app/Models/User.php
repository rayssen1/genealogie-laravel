<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * Relation : Un utilisateur peut créer plusieurs personnes.
     */
    public function createdPeople()
    {
        return $this->hasMany(Person::class, 'created_by');
    }
}
