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
    const STATUS_INSTALMENT = "Cicilan";
}