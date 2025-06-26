<?php

namespace App\Models;
use App\Models\ItemLoan;   
use App\Models\ItemReturn;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $guarded = [];

    public function loans()
    {
        return $this->hasMany(ItemLoan::class);
    }

    public function returns()
    {
        return $this->hasManyThrough(
            ItemReturn::class,
            ItemLoan::class,
            'item_id',   
            'loan_id',   
            'id',        
            'id'         
        );
    }

     protected $appends = [
        'total_loaned',
        'total_returned',
    ];

    public function getTotalLoanedAttribute()
    {
        
        if (isset($this->loans_qty_sum)) {
            return (int) $this->loans_qty_sum;
        }
        
        return $this->loans->sum('qty');
    }

    public function getTotalReturnedAttribute()
    {
        if (isset($this->returns_qty_sum)) {
            return (int) $this->returns_qty_sum;
        }
        return $this->returns->sum('qty');
    }
}


