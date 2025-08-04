<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pembeli', 'tanggal', 'total'];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function getTotalAttribute()
    {
        return $this->details->sum(fn($d) => $d->signed_subtotal);
    }
}
