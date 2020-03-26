<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	protected $guarded = [];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['status_label'];

    public function getStatusLabelAttribute()
    {
        if ($this->status == 'pending') {
            return '<span class="badge badge-secondary">Menunggu Pembayaran</span>';
        } elseif ($this->status == 'success') {
            return '<span class="badge badge-primary">Pembayaran Diterima</span>';
        } elseif ($this->status == 'failed') {
            return '<span class="badge badge-danger">Pembayaran Gagal</span>';
        } elseif ($this->status == 'expired') {
            return '<span class="badge badge-danger">Pembayaran Kadaluwarsa</span>';
        } elseif ($this->status == 'proses') {
            return '<span class="badge badge-info">Proses</span>';
        } elseif ($this->status == 'dikirim') {
            return '<span class="badge badge-warning">Dikirim</span>';
        }
        return '<span class="badge badge-success">Selesai</span>';
    }

    public function return()
    {
        return $this->hasOne(OrderReturn::class);
    }

    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }
 
    /**
     * Set status to Success
     *
     * @return void
     */
    public function setSuccess()
    {
        $this->attributes['status'] = 'success';
        self::save();
    }
 
    /**
     * Set status to Failed
     *
     * @return void
     */
    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }
 
    /**
     * Set status to Expired
     *
     * @return void
     */
    public function setExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }
}
