<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    // Afficher la liste des personnes avec le nom de l'utilisateur qui les a créées
    public function index()
    {
        $people = Person::with('creator')->get(); // Assurez-vous qu'il y a une relation 'creator' dans le modèle Person
        return view('people.index', compact('people'));
    }

    // Afficher une personne spécifique avec la liste de ses enfants / parents
    public function show($id)
    {
        $person = Person::with('parent', 'children')->findOrFail($id); // Assurez-vous qu'il y a des relations 'parent' et 'children' dans le modèle Person
        return view('people.show', compact('person'));
    }

    // Afficher le formulaire de création d'une nouvelle personne
    public function create()
    {
        return view('people.create');
    }

    // Valider les données de "create" et insérer une nouvelle personne
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|date_format:Y-m-d',
            'parent_id' => 'nullable|exists:people,id',  // Parent ID doit exister si fourni
        ]);

        // Formatage des données
        $firstName = ucfirst(strtolower($validatedData['first_name']));  // Première lettre en majuscule, le reste en minuscule
        $middleNames = $validatedData['middle_names'] ? ucfirst(strtolower($validatedData['middle_names'])) : null;  // Si renseigné, formatage
        $lastName = strtoupper($validatedData['last_name']);  // Tout en majuscule
        $birthName = strtoupper($validatedData['birth_name'] ?? $lastName);  // Si non renseigné, copie last_name
        $dateOfBirth = $validatedData['date_of_birth'] ?? null;  // Si non renseigné, NULL

        // Enregistrement des données dans la base de données
        $person = new Person();
        $person->first_name = $firstName;
        $person->middle_names = $middleNames;
        $person->last_name = $lastName;
        $person->birth_name = $birthName;
        $person->date_of_birth = $dateOfBirth;
        $person->created_by = Auth::id();  // ID de l'utilisateur authentifié
        $person->name = $request->input('name');
        $person->parent_id = $request->input('parent_id');
        $person->save();

        return redirect()->route('people.index')->with('success', 'Personne ajoutée avec succès!');
    }
}
