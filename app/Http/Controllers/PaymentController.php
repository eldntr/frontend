<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Order $order)
    {
        // Misalkan pembayaran langsung berhasil tanpa verifikasi pihak ketifa
        $order->update([
            'status' => 'paid'
        ]);

        // Kembalikan pengguna ke halaman transaksi dengan pesan sukses
        return redirect()->route('transactions.index')->with('success', 'Pembayaran berhasil!');
    }
}

