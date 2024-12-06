@extends('layouts')
@section('content')
    <div class="container mx-auto text-center mt-5">
        <h1 class="text-4xl font-bold mb-4">Welcome to Our Application</h1>
        <p class="text-lg mb-6">Please click the button below to login.</p>
        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
    </div>
@endsection