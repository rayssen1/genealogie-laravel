<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = ['person_id', 'related_person_id', 'relationship_type'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function relatedPerson()
    {
        return $this->belongsTo(Person::class, 'related_person_id');
    }
}

