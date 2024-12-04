@extends('layouts')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md">
            <a href="{{ route('participants.index') }}" class="mt-4 px-4 py-2 bg-primary text-white rounded-md">Back</a>
            <h1 class="text-2xl font-bold mb-4 text-center">Create Participant</h1>
            <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Position:</label>
                    <select name="position" id="position" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Moderator">Moderator</option>
                        <option value="Pembicara">Pembicara</option>
                        <option value="Peserta">Peserta</option>
                        <option value="Panitia">Panitia</option>
                    </select>

                </div>
                <div>
                    <label for="certificate_id" class="block text-sm font-medium text-gray-700">Signature Certificate:</label>
                    <select name="certificate_id" id="certificate_id" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($certificates as $certificate)
                            <option value="{{ $certificate->id }}">
                                {{ $certificate->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create
                        Participant</button>
                </div>
            </form>
        </div>
    </div>
@endsection
