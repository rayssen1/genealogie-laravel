<form action="{{ route('family.add') }}" method="POST">
    @csrf
    <input type="text" name="first_name" placeholder="Prénom" required>
    <input type="text" name="last_name" placeholder="Nom" required>
    <input type="text" name="relationship_type" placeholder="Lien de parenté" required>
    <input type="hidden" name="person_id" value="{{ $person->id }}">
    <button type="submit">Ajouter</button>
</form>
