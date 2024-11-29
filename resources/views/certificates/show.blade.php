@extends('layouts')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 text-center w-[90%] max-w-lg">
        <!-- Nomor Sertifikat -->
        <p class="text-sm font-medium text-gray-500 tracking-widest mb-4">Nomor Sertifikat: {{ str_replace('-', '/', $certificate->certificate_number) }}</p>

        <div class="flex justify-center items-center gap-2 mb-4">
            <img src="{{ asset('images/logo_dinus_new.png') }}" alt="Logo Dinus" class="w-24 h-24">
            <h1 class="text-3xl font-medium text-dark font-serif text-left">Program Studi Teknik Informatika</h1>
            <img src="{{ asset('images/logo_dinus_unggul.png') }}" alt="Logo Dinus" class="w-20 h-24 ">
        </div>

        <!-- Foto Profil -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset($certificate->photo_profile) }}" alt="Photo Profile" class="w-36 h-36 rounded-full border-4 border-yellow-500 object-cover">
        </div>        

        <!-- Nama -->
        <h2 class="text-xl font-extrabold text-gray-800">{{ $certificate->name }}</h2>
        <p class="text-sm font-medium text-gray-500 tracking-widest mb-4">PENANDATANGAN</p>

        <!-- Judul -->
        <p class="text-lg font-bold ">Dalam Kegiatan</p>

        <h2 class="text-2xl font-bold text-white mb-2 tracking-wider  [text-shadow:_10px_2px_12px_rgba(4,167,251,0.30)]">
            <span class="bg-gradient-to-r from-primary to-[#075F8D] text-transparent bg-clip-text">SEMNASTI X 4U SECURITY </span>
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
            Program Studi Teknik Informatika, Fakultas Ilmu Komputer<br>
            Universitas Dian Nuswantoro
        </p>
    </div>
</div>
@endsection
