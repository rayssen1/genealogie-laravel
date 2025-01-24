@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Propositions pour {{ $person->first_name }} {{ $person->last_name }}</h1>

    <h3>Créer une nouvelle proposition</h3>
    <form action="{{ route('proposals.store', $person->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="changes" class="form-label">Modifications (JSON)</label>
            <textarea name="changes" id="changes" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>

    <hr>

    <h3>Propositions existantes</h3>
    @foreach ($proposals as $proposal)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Proposé par :</strong> {{ $proposal->proposedBy->name }}</p>
                <p><strong>Modifications :</strong> {{ json_encode($proposal->changes, JSON_PRETTY_PRINT) }}</p>
                <p><strong>Statut :</strong> {{ ucfirst($proposal->status) }}</p>

                @if ($proposal->status === 'pending')
                    <form action="{{ route('proposals.review', [$proposal->id, 'accepted']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success">Accepter</button>
                    </form>
                    <form action="{{ route('proposals.review', [$proposal->id, 'rejected']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger">Rejeter</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
