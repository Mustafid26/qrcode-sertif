<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    // Index: Menampilkan daftar sertifikat
    public function index()
    {
        $certificates = Certificate::all();
        return view('certificates.index', compact('certificates'));
    }

    // Create: Form untuk menambah sertifikat baru
    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'position' => 'required|string|max:255',
        ]);
    
        try {
            // Simpan foto profil ke storage
            $photoProfilePath = null;
            if ($request->hasFile('photo_profile')) {
                $photoProfile = $request->file('photo_profile');
                $photoProfilePath = $photoProfile->store('photo_profiles', 'public');
            }
    
            // Buat record sertifikat sementara
            $certificate = Certificate::create([
                'name' => $request->name,
                'email' => $request->email,
                'position' => $request->position,
                'certificate_number' => '', // Placeholder
                'photo_profile' => $photoProfilePath,
                'qr_code_path' => '', // Placeholder
            ]);
    
            // Generate nomor sertifikat
            $participantNumber = str_pad($certificate->id, 3, '0', STR_PAD_LEFT);
            $certificateNumber = '002-HMTI-SEMNASTI-XI-2024-' . $participantNumber;
    
            // Generate QR code data
            $qrCodeData = route('certificates.show', $certificateNumber);
            $qrCodePath = 'qrcodes/' . $certificateNumber . '.png';
    
            // Buat direktori jika belum ada
            $qrCodeDirectory = public_path('storage/qrcodes');
            if (!file_exists($qrCodeDirectory)) {
                mkdir($qrCodeDirectory, 0777, true);
            }
    
            // Simpan QR code ke storage
            QrCode::format('png')->size(300)->generate($qrCodeData, public_path('storage/' . $qrCodePath));
    
            // Update record sertifikat
            $certificate->update([
                'certificate_number' => $certificateNumber,
                'qr_code_path' => 'storage/' . $qrCodePath,
            ]);
    
            return redirect()->route('certificates.index')->with('success', 'Certificate created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create certificate: ' . $e->getMessage()]);
        }
    }
    
    

    // Show: Menampilkan detail sertifikat
    public function show($certificateNumber)
    {
        $certificate = Certificate::where('certificate_number', $certificateNumber)->firstOrFail();
        return view('certificates.show', compact('certificate'));
    }


    public function downloadQrCode($certificateNumber)
    {
        $certificate = Certificate::where('certificate_number', $certificateNumber)->firstOrFail();

        // Path to QR Code
        $filePath = public_path($certificate->qr_code_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'QR Code not found.');
        }

        // Return file download response
        return response()->download($filePath, $certificate->certificate_number . '-qr-code.png');
    }


    public function destroy($id)
    {
        Certificate::findOrFail($id)->delete();

        $lastId = Certificate::max('id'); // Cari ID maksimum yang tersisa
        DB::statement('ALTER TABLE certificates AUTO_INCREMENT = ' . ($lastId + 1));

        return redirect()->route('certificates.index')->with('success', 'Data berhasil dihapus dan ID telah direset.');
    }


    
}
