<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id','produk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
