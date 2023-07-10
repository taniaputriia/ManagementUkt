<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const NOTE_STATUS_NOT_PAID = "Pembayaran Belum Lunas";
    const NOTE_STATUS_FULL_PAYMENT = "Pembayaran Lunas";
    const NOTE_STATUS_CREDIT_PAYMENT = "Pembayaran Cicilan";

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
