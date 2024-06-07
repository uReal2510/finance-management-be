<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 
        'tipe', 
        'kategori', 
        'deskripsi', 
        'jumlah',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($expense) {
    //         $expense->user_id = auth()->id();
    //     });
    // }

}
