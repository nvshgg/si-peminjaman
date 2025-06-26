<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    function index(){
        $items = Item::all();

        return view('item.index', compact('items'));
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'qty'    => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        Item::create($data);
        return redirect()->route('item.index')
                         ->with('success', 'Barang berhasil ditambah!');
    }
    
    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'qty'    => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        $item->update($data);
        return redirect()->route('item.index')
                         ->with('success', 'Barang berhasil diubah!');
    }

    // Hapus barang
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('item.index')
                         ->with('success', 'Barang berhasil dihapus!');
    }

}
