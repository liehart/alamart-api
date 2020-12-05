<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['alamat_pengiriman', 'tanggal_pengiriman', 'harga', 'user_id'];

    public function getCreatedAtAttribute() {
        if (!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format("Y-m-d H:i:s");
        }
    }

    public function getUpdatedAtAttribute() {
        if (!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format("Y-m-d H:i:s");
        }
    }

    public function transaksi_item() {
        return $this->hasMany('App\Models\TransaksiItem');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
