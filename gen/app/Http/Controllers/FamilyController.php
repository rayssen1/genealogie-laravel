<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Relationship;

class FamilyController extends Controller
{
    public function addFamilyMember(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship_type' => 'required|string|max:255',
            'person_id' => 'required|exists:people,id',
        ]);

        $newPerson = Person::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        Relationship::create([
            'person_id' => $request->person_id,
            'related_person_id' => $newPerson->id,
            'relationship_type' => $request->relationship_type,
        ]);

        return redirect()->route('people.index')->with('success', 'Membre de la famille ajouté.');
    }
}
