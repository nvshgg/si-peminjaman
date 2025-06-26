<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemLoan extends Model
{
    protected $table = 'item_loans';
    protected $guarded = [];
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returns()
    {
        return $this->hasMany(ItemReturn::class, 'loan_id');
    }

    public function getRemainingQtyAttribute()
    {
        $returned = $this->returns()->sum('qty');
        return $this->qty - $returned;
    }


}
