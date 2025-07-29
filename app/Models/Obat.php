<?php

// app/Models/Obat.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // app/Models/Obat.php
    protected $fillable = [
        'kode_obat', // <-- TAMBAHKAN INI
        'nama', 
        'jenis', 
        'satuan', 
        'harga_jual', 
        'harga_beli', 
        'stok', 
        'supplier', 
        'gambar'
    ];
}