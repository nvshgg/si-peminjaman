<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua item dengan subquery SUM di SQL
        $items = Item::query()
            ->withSum('loans', 'qty')     
            ->withSum('returns', 'qty')   
            ->get();

        return view('dashboard.index', compact('items'));
    }
}
