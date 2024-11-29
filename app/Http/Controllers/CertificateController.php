<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

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
        'email' => 'required|email|unique:certificates',
        'photo_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'position' => 'required|string|max:255',
    ]);

    try {
        // Handle Photo Profile Upload
        if ($request->hasFile('photo_profile')) {
            $photoProfile = $request->file('photo_profile');
            $photoProfilePath = $photoProfile->store('photo_profiles', 'public');
        }

        // Temporarily create certificate to get the `id` for incremental number
        $temporaryCertificate = Certificate::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'certificate_number' => '', // Placeholder, will be updated below
            'photo_profile' => 'storage/' . $photoProfilePath,
            'qr_code_path' => '', // Placeholder, will be updated below
        ]);

        // Get participant number from `id`
        $participantNumber = str_pad($temporaryCertificate->id, 3, '0', STR_PAD_LEFT);

        // Generate Certificate Number
        $certificateNumber = '002-HMTI-SEMNASTI-XI-2024-' . $participantNumber;

        // Generate QR Code Data (URL to Certificate Detail)
        $qrCodeData = route('certificates.show', $certificateNumber);

        // Path to Save QR Code
        $qrCodeDirectory = public_path('storage/qrcodes');
        if (!file_exists($qrCodeDirectory)) {
            mkdir($qrCodeDirectory, 0777, true); // Ensure the directory exists
        }

        // Define QR Code Path
        $qrCodePath = 'qrcodes/' . $certificateNumber . '.png';

        // Generate and Save QR Code
        QrCode::format('png')->size(300)->generate($qrCodeData, public_path('storage/' . $qrCodePath));

        // Update the certificate with correct certificate number and QR code path
        $temporaryCertificate->update([
            'certificate_number' => $certificateNumber,
            'qr_code_path' => 'storage/' . $qrCodePath,
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully!');
    } catch (\Exception $e) {
        // Handle exceptions and rollback changes
        return redirect()->back()->withErrors(['error' => 'Failed to create certificate: ' . $e->getMessage()]);
    }
}
    

    // Show: Menampilkan detail sertifikat
    public function show($certificateNumber)
    {
        $certificate = Certificate::where('certificate_number', $certificateNumber)->firstOrFail();
        return view('certificates.show', compact('certificate'));
    }

      // Show: Menampilkan detail sertifikat
    //   public function show($certificateNumber)
    //   {
    //       // Mendapatkan data sertifikat berdasarkan nomor sertifikat
    //       $certificate = Certificate::where('certificate_number', $certificateNumber)->firstOrFail();
  
    //       // URL ngrok
    //       $ngrokUrl = 'https://ee59-2001-448a-4003-27d4-598d-3e-b337-7500.ngrok-free.app';
  
    //       // URL lengkap sertifikat yang mengarah ke halaman detail sertifikat
    //       $certificateUrl = $ngrokUrl . '/certificate/' . $certificate->certificate_number;
  
    //       // Generate QR Code
    //       $qrCode = QrCode::size(300)->generate($certificateUrl);
  
    //       // Mengirim data ke view
    //       return view('certificates.show', compact('certificate', 'qrCode'));
    //   }

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

    
}
