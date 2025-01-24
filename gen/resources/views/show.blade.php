@extends('layouts.app')

@section('content')
    <h1>Détails de la personne : {{ $person->name }}</h1>

    <h3>Informations :</h3>
    <p><strong>Nom :</strong> {{ $person->name }}</p>
    <p><strong>Créé par :</strong> {{ $person->creator->name }}</p>

    <h3>Relations :</h3>
    <p><strong>Parent :</strong> 
        @if($person->parent)
            {{ $person->parent->name }}
        @else
            Aucun parent
        @endif
    </p>

    <p><strong>Enfants :</strong>
        @if($person->children->isEmpty())
            Aucun enfant
        @else
            <ul>
                @foreach($person->children as $child)
                    <li>{{ $child->name }}</li>
                @endforeach
            </ul>
        @endif
    </p>

    <a href="{{ route('people.index') }}">Retour à la liste</a>
@endsection
