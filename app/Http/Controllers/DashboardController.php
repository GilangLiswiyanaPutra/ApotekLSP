<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /** Menampilkan halaman etalase obat */
    public function index(Request $request)
    {
        $query = Obat::query()->where('stok', '>', 0); // Hanya tampilkan obat yang ada stok

        $query->when($request->search, function ($q, $search) {
            return $q->where('nama', 'like', "%{$search}%");
        });

        $obats = $query->latest()->paginate(8); // Tampilkan 8 obat per halaman
        
        // Check if this is the customer dashboard route
        if ($request->route()->getName() === 'dashboard_pelanggan') {
            return view('dashboard_pelanggan', compact('obats'));
        }
        
        return view('dashboard', compact('obats'));
    }

    /** Memproses pembelian obat */
    public function purchase(Request $request)
    {
        // Handle cart-based purchases (multiple items)
        if ($request->has('items')) {
            $request->validate([
                'items' => 'required|array',
                'items.*.obat_id' => 'required|exists:obats,id',
                'items.*.jumlah' => 'required|integer|min:1',
            ]);

            DB::transaction(function () use ($request) {
                foreach ($request->items as $item) {
                    $obat = Obat::findOrFail($item['obat_id']);
                    $jumlahBeli = $item['jumlah'];

                    // Validasi stok
                    if ($obat->stok < $jumlahBeli) {
                        throw new \Exception("Stok untuk {$obat->nama} tidak mencukupi. Sisa stok: {$obat->stok}");
                    }

                    // Kurangi stok
                    $obat->decrement('stok', $jumlahBeli);

                    // Catat transaksi
                    Transaksi::create([
                        'user_id' => Auth::id(),
                        'obat_id' => $obat->id,
                        'jumlah' => $jumlahBeli,
                        'total_harga' => $obat->harga_jual * $jumlahBeli,
                    ]);
                }
            });

            return redirect()->route('dashboard_pelanggan')->with('success', 'Pembelian berhasil diproses!');
        }

        // Handle single item purchases (from modal)
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($request->obat_id);
        $jumlahBeli = $request->jumlah;

        // Validasi stok
        if ($obat->stok < $jumlahBeli) {
            return back()->withErrors(['jumlah' => 'Stok obat tidak mencukupi. Sisa stok: ' . $obat->stok]);
        }

        DB::transaction(function () use ($obat, $jumlahBeli) {
            // Kurangi stok
            $obat->decrement('stok', $jumlahBeli);

            // Catat transaksi
            Transaksi::create([
                'user_id' => Auth::id(),
                'obat_id' => $obat->id,
                'jumlah' => $jumlahBeli,
                'total_harga' => $obat->harga_jual * $jumlahBeli,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Pembelian ' . $obat->nama . ' berhasil!');
    }
}