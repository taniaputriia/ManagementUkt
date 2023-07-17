<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    const STATUS_PAID = "Lunas";
    const STATUS_NOT_PAID = "Belum Lunas";
    const STATUS_CREDIT = "Cicilan";
    const STATUS_FIRST_CREDIT = "Cicilan Pertama";
    const STATUS_SECOND_CREDIT = "Cicilan Kedua";
    const STATUS_THIRD_CREDIT = "Cicilan Ketiga";
    const STATUS_NOT_CONFIRMED_CREDIT = "Menunggu Konfirmasi Cicilan";
    const STATUS_NOT_CONFIRMED_FIRST_CREDIT = "Menunggu Konfirmasi Cicilan Pertama";
    const STATUS_NOT_CONFIRMED_SECOND_CREDIT = "Menunggu Konfirmasi Cicilan Kedua";
    const STATUS_NOT_CONFIRMED_THIRD_CREDIT = "Menunggu Konfirmasi Cicilan Ketiga";
    const STATUS_NOT_CONFIRMED = "Menunggu Konfirmasi";

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
