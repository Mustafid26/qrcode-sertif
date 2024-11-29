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

    <!-- component -->
    <div class="flex min-h-screen items-center justify-center w-full">
        <div class="overflow-x-auto">
            <div class="flex justify-between mb-3 items-center">
                <h1 class="font-bold">Certificate List</h1>
                <a href="{{ route('certificates.create') }}"
                    class="ml-auto px-4  bg-primary py-2 text-white rounded-md">Create </a>
            </div>
            @if ($certificates->isEmpty())
                <div class="text-center py-4">
                    <p class="text-error font-bold">Belum ada data</p>
                </div>
            @else
                <table class="min-w-full bg-white border shadow-md rounded">
                    <thead>
                        <tr class="bg-blue-gray-100 text-gray-700">
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">Photo Profile</th>
                            <th class="py-3 px-4 text-left">Qr Code</th>
                            <th class="py-3 px-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-blue-gray-900">
                        @foreach ($certificates as $certificate)
                            <tr class="border-b border-blue-gray-200">
                                <td class="py-3 px-4">{{ $certificate->name }}</td>
                                <td class="py-3 px-4">{{ $certificate->email }}</td>
                                <td class="py-3 px-4"><img src="{{ asset($certificate->photo_profile) }}" alt="Photo Profile"
                                        width="100"></td>
                                <td class="py-3 px-4"><img src="{{ asset($certificate->qr_code_path) }}" alt="QR Code"
                                        width="100"></td>
                                <td class="py-3 px-4">
                                    <a class="font-medium text-blue-600 hover:text-blue-800"
                                        href="{{ route('certificates.show', $certificate->certificate_number) }}">View</a>

                                        <a class="font-medium text-green-600 hover:text-green-800"
                                            href="{{ route('certificates.downloadQr', $certificate->certificate_number) }}">Unduh</a>
                                        </tr>
                                </td>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="w-full pt-5 px-4 mb-8 mx-auto mt-4">
                <div class="text-sm text-gray-700 py-1 text-center">
                    Made with ❤ <a class="text-gray-700 font-semibold" href="https://hmtiudinus.org" target="_blank">Bidang
                        IPTEK</a> by <a href="https://www.creative-tim.com?ref=tailwindcomponents"
                        class="text-gray-700 font-semibold" target="_blank">HMTI Software Team</a>.
                </div>
            </div>
        </div>
    </div>
@endsection
