<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateSeeder extends Seeder
{
    public function run()
    {
        // Pastikan folder QR Code tersedia
        $qrCodeDirectory = public_path('storage/qrcodes');
        if (!file_exists($qrCodeDirectory)) {
            mkdir($qrCodeDirectory, 0777, true);
        }

        // Data tetap
        $name = 'SRI WINARNO, Ph.D';
        $email = 'sri.winarno@dsn.dinus.ac.id';
        $position = 'Ketua Program Studi Teknik Informatika';
        $photoProfile = 'https://ibb.co.com/df2cK0C';

        for ($i = 1; $i <= 600; $i++) {
            // Simpan data sertifikat
            $certificate = Certificate::create([
                'name' => $name,
                'email' => $email,
                'position' => $position,
                'photo_profile' => $photoProfile,
            ]);

            // Generate nomor sertifikat
            $certificateNumber = '002-HMTI-SEMNASTI-XI-2024-' . str_pad($certificate->id, 3, '0', STR_PAD_LEFT);
            $qrCodeData = route('certificates.show', $certificateNumber);
            $qrCodePath = 'storage/qrcodes/' . $certificateNumber . '.png';

            // Generate QR Code
            QrCode::format('png')->size(300)->generate($qrCodeData, public_path($qrCodePath));

            // Update nomor sertifikat dan QR code
            $certificate->update([
                'certificate_number' => $certificateNumber,
                'qr_code_path' => $qrCodePath,
            ]);

            // Tambahkan ke tabel participants
            Participant::create([
                'name' => $name,
                'email' => $email,
                'position' => $position,
                'certificate_id' => $certificate->id,
            ]);
        }
    }
}
