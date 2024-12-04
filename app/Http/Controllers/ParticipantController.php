<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Participant;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantController extends Controller
{
    // Menampilkan form untuk membuat participant baru
    public function create()
    {
        $certificates = Certificate::all();
        return view('participants.create', compact('certificates'));
    }


    // Menyimpan participant baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'position' => 'required|in:Moderator,Pembicara,Peserta,Panitia',
            'certificate_id' => 'required'
        ]);

        $certificate = Certificate::find($request->certificate_id);
        $certificate_number = $certificate->certificate_number;  // Misalnya: 002-HMTI-SEMNASTI-XI-2024-001
        
        // Hitung jumlah peserta yang sudah ada dengan ID sertifikat tertentu
        $count = Participant::where('certificate_id', $request->certificate_id)->count(); 
        
        // Ambil angka terakhir dari $certificate_number
        $parts = explode('-', $certificate_number);
        $lastNumber = (int) end($parts); // Ambil bagian terakhir sebagai integer
        
        // Tambahkan $count ke angka terakhir
        $newNumber = $lastNumber + $count;
        
        // Format ulang nomor sertifikat
        $parts[count($parts) - 1] = str_pad($newNumber, 3, '0', STR_PAD_LEFT); // Format dengan 3 digit
        $cn = implode('-', $parts);

        $qrCodeData = route('certificates.show', $cn);
        $qrCodePath = 'storage/qrcodes/' . $cn . '.png';

        // Generate QR Code
        QrCode::format('png')->size(300)->generate($qrCodeData, public_path($qrCodePath));
        
        // $cn akan menjadi: 002-HMTI-SEMNASTI-XI-2024-004
        Participant::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'certificate_id' => $request->certificate_id,
            'certificate_number' => $cn,
            'qr_code_path' => $qrCodePath
        ]);

        return redirect()->route('participants.index')->with('success', 'Participant created successfully!');
    }

    // Menampilkan daftar participants
    public function index()
    {
    // Mengambil semua participant dengan sertifikat yang terkait
        $participants = Participant::with('certificate')->get();
        // dd($participants->toArray());
        return view('participants.index', compact('participants'));
    }



    // Menampilkan form untuk edit participant
    public function edit($id)
    {
        $participant = Participant::findOrFail($id);
        return view('participants.edit', compact('participant'));
    }

    // Mengupdate participant
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'position' => 'required|in:Moderator,Pembicara,Peserta,Panitia',
        ]);

        $participant = Participant::findOrFail($id);
        $participant->update([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
        ]);

        return redirect()->route('participants.index')->with('success', 'Participant updated successfully!');
    }

    // Menghapus participant
    public function destroy($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Participant deleted successfully!');
    }
}

