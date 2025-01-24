<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['inviter_id', 'invitee_email', 'person_id', 'status'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }
}
