<?php

namespace App\Imports;

use App\Models\Participant;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Excel;

class ParticipantsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);
        // Generate Certificate Number
        $certificate = Certificate::find($row['certificate_id']);
        $certificate_number = $certificate->certificate_number;
        $count = Participant::where('certificate_id', $row['certificate_id'])->count();
        $parts = explode('-', $certificate_number);
        $lastNumber = (int) end($parts);
        $newNumber = $lastNumber + $count;
        $parts[count($parts) - 1] = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        $cn = implode('-', $parts);

        // Generate QR Code
        $qrCodeData = route('certificates.show', $cn);
        $qrCodePath = 'storage/qrcodes/' . $cn . '.png';
        QrCode::format('png')->size(300)->generate($qrCodeData, public_path($qrCodePath));

        return new Participant([
            'name' => $row['name'],
            'email' => $row['email'],
            'position' => $row['position'],
            'certificate_id' => $row['certificate_id'],
            'certificate_number' => $cn,
            'qr_code_path' => $qrCodePath,
        ]);
    }
}
