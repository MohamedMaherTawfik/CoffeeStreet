<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cartItems extends Model
{
    protected $table = 'cart_items';
    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
