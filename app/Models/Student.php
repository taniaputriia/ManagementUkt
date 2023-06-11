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
    const STUDY_PROGRAM_CIVIL1 = "D3 Teknik Sipil";
    const STUDY_PROGRAM_CIVIL2 = "D4 Perancangan Jalan dan Jembatan";
    const STUDY_PROGRAM_CIVIL3 = "D4 Teknologi Industri Tanaman Perkebunan";

    const STUDY_PROGRAM_CHOICE = [
        self::STUDY_PROGRAM_CIVIL1 => self::STUDY_PROGRAM_CIVIL1,
        self::STUDY_PROGRAM_CIVIL2 => self::STUDY_PROGRAM_CIVIL2,
        self::STUDY_PROGRAM_CIVIL3 => self::STUDY_PROGRAM_CIVIL3,
    ];
}
