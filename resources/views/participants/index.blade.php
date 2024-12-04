@extends('layouts')

@section('content')
    @if (session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 5000);
        </script>
    @endif

    <div class="flex min-h-screen items-center justify-center w-full">
        <div class="overflow-x-auto">
            <h1 class="font-bold mb-2">Participants List</h1>
            <div class="flex justify-between mb-3 items-center">
                <a href="{{ route('certificates.index') }}" class="px-4 bg-gray-500 text-white py-2 rounded-md hover:bg-gray-700">Back</a>
                <a href="{{ route('participants.create') }}" class="ml-auto px-4 bg-black text-white py-2 rounded-md hover:bg-blue-700">Create</a>
            </div>
            @if ($participants->isEmpty())  
                <div class="text-center py-4">
                    <p class="text-error font-bold">Belum ada data</p>
                </div>
            @else
                <table class="min-w-full bg-white border shadow-md rounded">
                    <thead>
                        <tr class="bg-blue-gray-100 text-gray-700">
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">Position</th>
                            <th class="py-3 px-4 text-left">Certificate Number</th>
                            <th class="py-3 px-4 text-left">QR Code</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-blue-gray-900">
                        @foreach($participants as $participant)
                            <tr class="border-b border-blue-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4">{{ $participant->name }}</td>
                                <td class="py-3 px-4">{{ $participant->email }}</td>
                                <td class="py-3 px-4">{{ $participant->position }}</td>
                                <td class="py-3 px-4">
                                    {{ $participant->certificate_number ?? 'No Certificate Assigned' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if ($participant->certificate && $participant->qr_code_path)
                                    <img src="{{ asset($participant->qr_code_path) }}" alt="QR Code" width="100">
                                @else
                                    No QR Code
                                @endif
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('participants.edit', $participant->id) }}" class="font-medium text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('participants.destroy', $participant->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="w-full pt-5 px-4 mb-8 mx-auto mt-4">
                <div class="text-sm text-gray-700 py-1 text-center">
                    Made with ❤ <a class="text-gray-700 font-semibold" href="https://hmtiudinus.org" target="_blank">Bidang IPTEK</a> by <a href="https://www.creative-tim.com?ref=tailwindcomponents" class="text-gray-700 font-semibold" target="_blank">HMTI Software Team</a>.
                </div>
            </div>
        </div>
    </div>
@endsection