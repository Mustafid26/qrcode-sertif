@extends('layouts')

@section('content')
<div class="flex justify-center items-center min-h-screen mt-5 mb-5">
    <div class="bg-[#CECECE] shadow-md rounded-lg p-6 text-center w-[90%] max-w-lg">
        <!-- Nomor Sertifikat -->
        <p class="text-sm font-medium text-gray-500 tracking-widest mb-4">Nomor Sertifikat: {{ str_replace('-', '/', $certificate->certificate_number) }}</p>

        <div class="flex items-center justify-between">
            <img src="{{ asset('images/logo_dinus_new.png') }}" alt="Logo Udinus" class="w-[3rem] md:w-20">
            <h1 class="text-md md:text-2xl font-semibold text-center font-serif flex-1 mx-4">
                Program Studi Teknik Informatika
            </h1>
            <img src="{{ asset('images/logo_dinus_unggul.png') }}" alt="Akreditasi Unggul" class="w-[2.5rem] md:w-16">
        </div>        

        <!-- Foto Profil -->
        <div class="flex justify-center mb-4 mt-5">
            <img src="{{ asset($certificate->photo_profile) }}" alt="Photo Profile" class="w-36 h-36 rounded-full border-4 border-yellow-500 object-cover">
        </div>        

        <!-- Nama -->
        <h2 class="text-xl font-extrabold text-gray-800">{{ $certificate->name }}</h2>
        <p class="text-sm font-medium text-gray-500 tracking-widest mb-4">PENANDATANGAN</p>

        <!-- Judul -->
        <p class="text-lg font-bold ">Dalam Kegiatan</p>

        <h2 class="mt-2">
            {{-- <span class="bg-gradient-to-r from-primary to-[#075F8D] text-transparent bg-clip-text">SEMNASTI X 4U SECURITY </span> --}}
            <img src="{{ asset('images/semnasti.png') }}" alt="" srcset="">
        </h2>
        <!-- Keterangan -->
        <h1 class="mt-4">Dengan Tema:</h1>
        <h3 class="text-sm font-medium  text-dark mb-8 tracking-wide">
            INDONESIA'S CYBER SECURITY CHALLENGE IN<br />
            BUILDING A ROBUST DEFENSE
        </h3>

        <p class="text-sm text-dark leading-relaxed  mt-4">
            Diselenggarakan oleh <b>Himpunan Mahasiswa Teknik Informatika</b><br>
            pada tanggal 30 November 2024<br>
            <br>
            <b>Program Studi Teknik Informatika <br> Fakultas Ilmu Komputer<br>
                Universitas Dian Nuswantoro</b>
        </p>
    </div>
</div>
@endsection
