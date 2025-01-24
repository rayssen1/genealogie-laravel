<form action="{{ route('invitations.send') }}" method="POST">
    @csrf
    <input type="email" name="invitee_email" placeholder="Email de l'invité" required>
    <input type="hidden" name="person_id" value="{{ $person->id }}">
    <button type="submit">Envoyer l'invitation</button>
</form>
