@extends('layouts.app')

@section('content')
    <h1>Créer une nouvelle personne</h1>

    <form action="{{ route('people.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="parent_id">Parent (optionnel) :</label>
            <select name="parent_id" id="parent_id">
                <option value="">Aucun</option>
                @foreach(App\Models\Person::all() as $person)
                    <option value="{{ $person->id }}">{{ $person->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
        <input type="hidden" name="created_by" value="{{ Auth::id() }}">
            <select name="created_by" id="created_by" required>
                @foreach(App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Ajouter la personne</button>
    </form>
@endsection

