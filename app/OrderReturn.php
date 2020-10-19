<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
	public $timestamps = false;
	
    protected $guarded = [];
    protected $appends = ['status_label'];

    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Menunggu Konfirmasi</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-danger">Ditolak</span>';
        } elseif ($this->status == 3) {
            return '<span class="badge badge-warning">Dikirim</span>';
        } elseif ($this->status == 4) {
            return '<span class="badge badge-success">Diterima oleh Pelanggan</span>';
        }
        return '<span class="badge badge-success">Diterima</span>';
    }
}
