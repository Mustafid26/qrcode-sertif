<!-- resources/views/participants/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Participant</title>
</head>
<body>
    <h1>Edit Participant</h1>
    <form action="{{ route('participants.update', $participant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $participant->name) }}" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $participant->email) }}" required>
        </div>
        <div>
            <label for="position">Position</label>
            <select id="position" name="position" required>
                <option value="Peserta" {{ old('position', $participant->position) == 'Peserta' ? 'selected' : '' }}>Peserta</option>
                <option value="Panitia" {{ old('position', $participant->position) == 'Panitia' ? 'selected' : '' }}>Panitia</option>
                <option value="Pembicara" {{ old('position', $participant->position) == 'Pembicara' ? 'selected' : '' }}>Pembicara</option>
                <option value="Moderator" {{ old('position', $participant->position) == 'Moderator' ? 'selected' : '' }}>Moderator</option>
            </select>
        </div>
        <div>
            <button type="submit">Update Participant</button>
        </div>
    </form>
</body>
</html>
