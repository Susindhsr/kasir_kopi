<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = ['produk_id', 'jumlah', 'subtotal', 'is_deduction'];

    protected $casts = ['is_deduction' => 'boolean'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function getSignedSubtotalAttribute()
    {
        return $this->is_deduction ? -$this->subtotal : $this->subtotal;
    }
}
