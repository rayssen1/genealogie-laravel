@extends('layouts.app')

@section('content')
    <h1>Liste des Personnes</h1>
    <a href="{{ route('people.create') }}">Créer une nouvelle personne</a>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <ul>
        @foreach($people as $person)
            <li>
                {{ $person->name }} (Créé par: {{ $person->creator->name }})
                <a href="{{ route('people.show', $person->id) }}">Voir</a>
            </li>
        @endforeach
    </ul>
@endsection
