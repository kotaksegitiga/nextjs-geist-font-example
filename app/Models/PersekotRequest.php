<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersekotRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'jabatan',
        'departemen',
        'kantor',
        'usage_details',
        'total',
        'status',
        'approval_note',
    ];

    protected $casts = [
        'usage_details' => 'array',
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
