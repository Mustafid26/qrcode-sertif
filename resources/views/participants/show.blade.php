<!-- resources/views/participants/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Participant</title>
</head>
<body>
    <h1>Participant Details</h1>
    <div>
        <label>Name: </label>
        <span>{{ $participant->name }}</span>
    </div>
    <div>
        <label>Email: </label>
        <span>{{ $participant->email }}</span>
    </div>
    <div>
        <label>Position: </label>
        <span>{{ $participant->position }}</span>
    </div>
    <div>
        <label>Certificate Number: </label>
        <span>
            @if($participant->certificate)
                {{ $participant->certificate->certificate_number }}
            @else
                No Certificate Assigned
            @endif
        </span>
    </div>
    <div>
        <label>QR Code: </label>
        <span>
            @if($participant->certificate && $participant->certificate->qr_code_path)
                <img src="{{ asset('storage/' . $participant->certificate->qr_code_path) }}" alt="QR Code" width="100">
            @else
                No QR Code
            @endif
        </span>
    </div>
    <div>
        <a href="{{ route('participants.index') }}">Back to Participants List</a>
    </div>
</body>
</html>
