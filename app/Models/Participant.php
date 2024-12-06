<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'position','certificate_id', 'certificate_number', 'qr_code_path'];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id');
    }

}
