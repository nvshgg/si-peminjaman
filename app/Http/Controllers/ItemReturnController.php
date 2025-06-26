<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemLoan;
use App\Models\ItemReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemReturnController extends Controller
{
    /**
     * Tampilkan daftar semua pengembalian
     */
    public function index()
    {
        $returns = ItemReturn::with(['loan.item', 'loan.user'])->latest()->paginate(15);
        return view('item-return.index', compact('returns'));
    }

    /**
     * Form pengembalian baru
     */
    public function create()
    {
        // Hanya tampilkan peminjaman yang masih ada sisa qty untuk dikembalikan
        $loans = ItemLoan::with('item', 'user')
            ->get()
            ->filter(function($loan) {
                return $loan->remaining_qty > 0;
            });
        return view('item-return.create', compact('loans'));
    }

    /**
     * Simpan data pengembalian dan update stok item
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'loan_id'     => 'required|exists:item_loans,id',
            'qty'         => 'required|integer|min:1',
            'return_date' => 'required|date',
        ]);

        $loan = ItemLoan::withSum('returns', 'qty')->findOrFail($data['loan_id']);
        $alreadyReturned = $loan->returns_sum_qty ?? 0;
        $maxReturnable = $loan->qty - $alreadyReturned;

        if ($data['qty'] > $maxReturnable) {
            return back()
                ->withInput()
                ->withErrors(['qty' => "Maksimum pengembalian untuk peminjaman ini adalah {$maxReturnable} pcs."]);
        }

        DB::transaction(function() use ($loan, $data) {
            // 1) Buat record pengembalian
            ItemReturn::create($data);

            // 2) Tambahkan kembali stok di tabel items
            Item::find($loan->item_id)->increment('qty', $data['qty']);
        });

        return redirect()->route('item-return.index')
                         ->with('success', 'Pengembalian berhasil diproses!');
    }

    public function edit(ItemReturn $item_return)
    {
        // Daftar loan yang masih punya sisa, sekaligus include current loan agar tetap muncul
        $loans = ItemLoan::withSum('returns', 'qty')
            ->get()
            ->filter(function($loan) use ($item_return) {
                $returned = $loan->returns_sum_qty ?? 0;
                $remaining = $loan->qty - $returned;
                // tampilkan jika masih ada sisa, atau ini adalah loan yg sedang di-edit
                return $remaining > 0 || $loan->id === $item_return->loan_id;
            });

        return view('item-return.edit', [
            'item_return' => $item_return,
            'loans'       => $loans,
        ]);
    }

    /**
     * Proses update pengembalian dan penyesuaian stok
     */
    public function update(Request $request, ItemReturn $item_return)
    {
        $data = $request->validate([
            'loan_id'     => 'required|exists:item_loans,id',
            'qty'         => 'required|integer|min:1',
            'return_date' => 'required|date',
        ]);

        DB::transaction(function() use ($item_return, $data) {
            // 1. kembalikan stok sesuai old qty
            $oldLoan = $item_return->loan;
            Item::find($oldLoan->item_id)
                ->decrement('qty', $item_return->qty);

            // 2. update record
            $item_return->update($data);

            // 3. tambah stok sesuai new qty pada item baru
            $newLoan = ItemLoan::find($data['loan_id']);
            Item::find($newLoan->item_id)
                ->increment('qty', $data['qty']);
        });

        return redirect()->route('item-return.index')
                         ->with('success', 'Data pengembalian berhasil diubah!');
    }

    /**
     * Hapus record pengembalian dan sesuaikan stok
     */
    public function destroy(ItemReturn $item_return)
    {
        DB::transaction(function() use ($item_return) {
            // kurangi kembali stok (karena pengembalian dibatalkan)
            $loan = $item_return->loan;
            Item::find($loan->item_id)
                ->decrement('qty', $item_return->qty);

            $item_return->delete();
        });

        return redirect()->route('item-return.index')
                         ->with('success', 'Pengembalian berhasil dihapus!');
    }

    // Anda bisa tambahkan edit/update/destroy jika perlu
}
