<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    // Index: Menampilkan daftar sertifikat
    public function index(){
        $certificates = Certificate::paginate(10);
        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('certificates.create');
    }

    // Create: Form untuk menambah sertifikat baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'position' => 'required|string|max:255',
        ]);

        try {
            // Simpan foto profil
            $photoProfilePath = $request->file('photo_profile')->store('photo_profiles', 'public');

            // Buat sertifikat baru
            $certificate = Certificate::create([
                'name' => $request->name,
                'email' => $request->email,
                'position' => $request->position,
                'photo_profile' => $photoProfilePath,
            ]);

            // Generate nomor sertifikat
            $certificateNumber = '002-HMTI-SEMNASTI-XI-2024-' . str_pad($certificate->id, 3, '0', STR_PAD_LEFT);
            $qrCodeData = route('certificates.show', $certificateNumber);
            $qrCodePath = 'storage/qrcodes/' . $certificateNumber . '.png';

            // Generate QR Code
            QrCode::format('png')->size(300)->generate($qrCodeData, public_path($qrCodePath));

            // Update sertifikat
            $certificate->update([
                'certificate_number' => $certificateNumber,
                'qr_code_path' => $qrCodePath,
            ]);

            // Update participant dengan certificate_id
            $participant = Participant::where('email', $request->email)->first();
            if ($participant) {
                $participant->update(['certificate_id' => $certificate->id]);
            }

            return redirect()->route('certificates.index')->with('success', 'Certificate created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($certificateNumber)
    {
        $participant = Participant::where('certificate_number', $certificateNumber)->firstOrFail();
        return view('certificates.show', compact('participant'));
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
