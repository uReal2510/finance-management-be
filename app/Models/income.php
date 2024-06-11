<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class income extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 
        'kategori', 
        'deskripsi', 
        'jumlah',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
