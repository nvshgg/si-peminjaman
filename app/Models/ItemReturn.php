<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    protected $guarded = [];
    protected $casts = [
        'return_date' => 'date',
    ];
    
    public function loan()
    {
        return $this->belongsTo(ItemLoan::class, 'loan_id');
    }
    //
}
