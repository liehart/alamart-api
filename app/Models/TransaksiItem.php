<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'transaksi_id', 'quantity'];

    public function transaksi() {
        return $this->belongsTo('App\Models\Tansaksi');
    }

    public function item() {
        return $this->belongsTo('App\Models\Item');
    }
}
