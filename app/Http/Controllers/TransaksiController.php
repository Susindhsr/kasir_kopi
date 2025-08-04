<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
{
    $transaksis = Transaksi::with('details.produk')->orderBy('created_at', 'desc')->get();
    $produks = Produk::all();  // <-- tambah ini
    return view('transaksi.index', compact('transaksis', 'produks'));
}


    public function create()
    {
        $produks = Produk::all();
        return view('transaksi.create', compact('produks'));
    }

public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah.*' => 'required|integer|min:1',
            'is_deduction.*' => 'nullable|boolean',
        ]);

        // Gabungkan produk yang sama (berdasarkan produk_id + is_deduction)
        $produkGabungan = [];

        foreach ($request->produk_id as $i => $prodId) {
            $jumlah = $request->jumlah[$i];
            $isDeduct = $request->is_deduction[$i] ?? false;

            $key = $prodId . '_' . ($isDeduct ? '1' : '0');

            if (isset($produkGabungan[$key])) {
                $produkGabungan[$key]['jumlah'] += $jumlah;
            } else {
                $produkGabungan[$key] = [
                    'produk_id' => $prodId,
                    'jumlah' => $jumlah,
                    'is_deduction' => $isDeduct,
                ];
            }
        }

        $transaksi = Transaksi::create([
            'nama_pembeli' => $request->nama_pembeli,
            'tanggal' => now(),
            'total' => 0,
        ]);

        $total = 0;
        foreach ($produkGabungan as $item) {
            $produk = Produk::findOrFail($item['produk_id']);
            $subtotal = $produk->harga * $item['jumlah'];

            $transaksi->details()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $subtotal,
                'is_deduction' => $item['is_deduction'],
            ]);

            $total += $item['is_deduction'] ? -$subtotal : $subtotal;
        }

        $transaksi->update(['total' => $total]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil!');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
        $produks = Produk::all();

        return view('transaksi.edit', compact('transaksi', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah.*' => 'required|integer|min:1',
            'is_deduction.*' => 'nullable|boolean',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->nama_pembeli = $request->nama_pembeli;

        // Hapus detail lama dulu
        $transaksi->details()->delete();

        // Gabungkan produk sama seperti di store
        $produkGabungan = [];

        foreach ($request->produk_id as $i => $prodId) {
            $jumlah = $request->jumlah[$i];
            $isDeduct = $request->is_deduction[$i] ?? false;

            $key = $prodId . '_' . ($isDeduct ? '1' : '0');

            if (isset($produkGabungan[$key])) {
                $produkGabungan[$key]['jumlah'] += $jumlah;
            } else {
                $produkGabungan[$key] = [
                    'produk_id' => $prodId,
                    'jumlah' => $jumlah,
                    'is_deduction' => $isDeduct,
                ];
            }
        }

        $total = 0;
        foreach ($produkGabungan as $item) {
            $produk = Produk::findOrFail($item['produk_id']);
            $subtotal = $produk->harga * $item['jumlah'];

            $transaksi->details()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $subtotal,
                'is_deduction' => $item['is_deduction'],
            ]);

            $total += $item['is_deduction'] ? -$subtotal : $subtotal;
        }

        $transaksi->total = $total;
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->details()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }

    // public function cetakStruk($id)
    // {
    //     $transaksi = Transaksi::with('details.produk')->findOrFail($id);
    //     return view('transaksi.struk', compact('transaksi'));
    // }
    public function showStruk($id)
{
    // Ambil transaksi beserta detailnya
    $transaksi = Transaksi::with('details.produk')->findOrFail($id);

    // Hitung subtotal kopi dan selip
    $subtotalKopi = 0;
    $subtotalSelip = 0;

    foreach ($transaksi->details as $item) {
        if (strtolower($item->produk->nama) == 'kopi') {
            $subtotalKopi = $item->subtotal;
        }
        if (strtolower($item->produk->nama) == 'selip') {
            $subtotalSelip = $item->subtotal;
        }
    }

    // Total jadi hasil pengurangan kopi - selip
    $transaksi->total = $subtotalKopi - $subtotalSelip;

    // Kirim data ke view struk
    return view('transaksi.struk', compact('transaksi'));

}

}
