<?php

namespace App\Http\Controllers;

use App\Models\ItemLoan;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemLoanController extends Controller
{
    
    function index(){
        
        $loans = ItemLoan::with(['item','user'])->get();

        return view('item-loan.index', compact('loans'));
    }

    public function create()
    {
        // hanya barang available & qty > 0
        $items = Item::where('status','available')
                    ->where('qty','>',0)
                    ->get();
        $users = User::all();
        return view('item-loan.create', compact('items','users'));
    }


     public function store(Request $request)
    {
        $data = $request->validate([
            'item_id'    => 'required|exists:items,id',
            'user_id'    => 'required|exists:users,id',
            'qty'        => 'required|integer|min:1',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        \DB::transaction(function() use($data) {
            $loan = ItemLoan::create($data);
            Item::find($data['item_id'])->decrement('qty', $data['qty']);
        });

        return redirect()->route('item-loan.index')
                         ->with('success','Peminjaman berhasil dibuat!');
    }

    public function edit(ItemLoan $item_loan)
    {
        $items = Item::where('status','available')
                    ->where('qty','>',0)
                    ->orWhere('id', $item_loan->item_id)
                    ->get();

        $users = User::all(); // tambahkan ini

        return view('item-loan.edit', compact('item_loan','items','users'));
    }

    public function update(Request $request, ItemLoan $item_loan)
    {
        $data = $request->validate([
            'item_id'    => 'required|exists:items,id',
            'user_id'    => 'required|exists:users,id',      // kalau pakai field ini
            'qty'        => 'required|integer|min:1',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        DB::transaction(function() use($item_loan, $data) {
            // kembalikan stok lama
            Item::find($item_loan->item_id)
                ->increment('qty', $item_loan->qty);

            // update loan (termasuk user_id/peminjam)
            $item_loan->update($data);

            // kurangi stok baru
            Item::find($data['item_id'])
                ->decrement('qty', $data['qty']);
        });

        return redirect()->route('item-loan.index')
                        ->with('success','Peminjaman berhasil diubah!');
    }
}
