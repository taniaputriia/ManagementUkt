<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // Gender
    const GENDER_MAN = "Laki-laki";
    const GENDER_WOMAN = "Perempuan";

    const GENDER_CHOICE = [
        self::GENDER_MAN => self::GENDER_MAN,
        self::GENDER_WOMAN => self::GENDER_WOMAN,
    ];

    // Program Studi
    const STUDYPROGRAM_CIVIL1 = "D3 Teknik Sipil";
    const STUDYPROGRAM_CIVIL2= "D4 Perancangan Jalan dan Jembatan";
    const STUDYPROGRAM_CIVIL3= "D4 Teknologi Industri Tanaman Perkebunan";

    const ProgramStudy_CHOICE = [
        self::STUDYPROGRAM_CIVIL1=> self::STUDYPROGRAM_CIVIL1,
        self::STUDYPROGRAM_CIVIL2 => self::STUDYPROGRAM_CIVIL2,
    ];



}
