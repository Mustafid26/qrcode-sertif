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
        <div class="w-full max-w-7xl p-4 bg-white rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Participants List</h1>
            <!-- Search Form -->
            <form action="{{ route('participants.index') }}" method="GET" class="mb-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <input type="text" name="search" placeholder="Search participants..." class="px-4 py-2 border rounded-md w-full sm:w-1/3" value="{{ request('search') }}">
                <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Search</button>
            </form>            
            
            <a href="{{ route('certificates.index') }}" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Back</a>
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end mb-3 items-center space-y-2 sm:space-y-0 sm:space-x-2">
                <form action="{{ route('participants.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                    @csrf
                    <div>
                        <div class="mx-auto max-w-xs">
                            <input id="file" type="file" name="file" accept=".xlsx, .csv" required class="mt-2 block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-black file:py-2 file:px-4 file:text-sm file:font-semibold file:text-white  focus:outline-none disabled:pointer-events-none disabled:opacity-60">
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Import</button>
                </form>
                <a href="{{ route('participants.create') }}" class="ml-auto px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Create</a>
                <a href="{{ route('participants.downloadAllQr') }}" class="ml-2 px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Download All QR</a>
            </div>

            <!-- No Data Message -->
            @if ($participants->isEmpty())
                <div class="text-center py-4">
                    <p class="text-red-500 font-bold">No participants found.</p>
                </div>
            @else
                <!-- Participants Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border shadow-md rounded">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="py-3 px-4 text-left">No</th>
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Position</th>
                                <th class="py-3 px-4 text-left">Certificate Number</th>
                                <th class="py-3 px-4 text-left">QR Code</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $participant)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4">{{ $participant->name }}</td>
                                    <td class="py-3 px-4">{{ $participant->email }}</td>
                                    <td class="py-3 px-4">{{ $participant->position }}</td>
                                    <td class="py-3 px-4">{{ $participant->certificate_number ?? 'No Certificate Assigned' }}</td>
                                    <td class="py-3 px-4">
                                        @if ($participant->qr_code_path && file_exists(public_path($participant->qr_code_path)))
                                            <img src="{{ asset($participant->qr_code_path) }}" alt="QR Code" width="100">
                                        @else
                                            <span class="text-gray-400">No QR Code</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('participants.edit', $participant->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <form action="{{ route('participants.destroy', $participant->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $participants->links() }}
                </div>
            @endif

            <!-- Footer -->
            <div class="text-center text-sm text-gray-700 py-5">
                Made with ❤ <a href="https://hmtiudinus.org" target="_blank" class="font-semibold">Bidang IPTEK</a> by <a href="https://www.creative-tim.com?ref=tailwindcomponents" class="font-semibold" target="_blank">HMTI Software Team</a>.
            </div>
        </div>
    </div>
@endsection
