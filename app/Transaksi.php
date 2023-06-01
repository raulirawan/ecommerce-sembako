<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id','id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id','id');
    }
    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id','id');
    }
}
