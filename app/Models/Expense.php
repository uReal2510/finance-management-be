<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'tanggal',  
        'kategori', 
        'deskripsi', 
        'jumlah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($expense) {
    //         $expense->user_id = auth()->id();
    //     });
    // }

}
