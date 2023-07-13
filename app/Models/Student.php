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
    const STUDY_PROGRAM_MACHINE1 = "D3 Teknik Mesin";
    const STUDY_PROGRAM_MACHINE2 = "D4 Teknik Mesin Produksi dan Perawatan";
    const STUDY_PROGRAM_ELECTRO1 = "D3 Teknik Listrik";
    const STUDY_PROGRAM_ELECTRO2 = "D3 Teknik Elektronika";
    const STUDY_PROGRAM_ELECTRO3 = "D3 Teknik Telekomunikasi";
    const STUDY_PROGRAM_ELECTRO4 = "D4 Teknik Telekomunikasi";
    const STUDY_PROGRAM_ELECTRO5 = "D4 Teknik Elektro";
    const STUDY_PROGRAM_CHEMICAL1 = "D3 Teknik Kimia";
    const STUDY_PROGRAM_CHEMICAL2 = "D3 Teknologi Pangan";
    const STUDY_PROGRAM_CHEMICAL3 = "D4 Teknologi Kimia Industri";
    const STUDY_PROGRAM_CHEMICAL4 = "D4 Teknik Energi";
    const STUDY_PROGRAM_CHEMICAL5 = "S2 Teknik Energi Terbarukan";
    const STUDY_PROGRAM_ACCOUNTING1 = "D3 Akuntansi";
    const STUDY_PROGRAM_ACCOUNTING2 = "D4 Akuntansi Sektor Publik";
    const STUDY_PROGRAM_BUSINESS_ADMINISTRATION1 = "D3 Administrasi Bisnis";
    const STUDY_PROGRAM_BUSINESS_ADMINISTRATION2 = "D4 Manajemen Bisnis";
    const STUDY_PROGRAM_BUSINESS_ADMINISTRATION3 = "D4 Usaha Perjalanan Wisata";
    const STUDY_PROGRAM_COMPUTER1 = "D3 Teknik Komputer";
    const STUDY_PROGRAM_COMPUTER2 = "D4 Teknologi Informatika Multimedia Digital";
    const STUDY_PROGRAM_INFORMATICS_MANAGEMENT1 = "D3 Manajemen Informatika";
    const STUDY_PROGRAM_INFORMATICS_MANAGEMENT2 = "D4 Manajemen Informatika";


    const STUDY_PROGRAM_CHOICE = [
        self::STUDY_PROGRAM_CIVIL1 => self::STUDY_PROGRAM_CIVIL1,
        self::STUDY_PROGRAM_CIVIL2 => self::STUDY_PROGRAM_CIVIL2,
        self::STUDY_PROGRAM_CIVIL3 => self::STUDY_PROGRAM_CIVIL3,
        self::STUDY_PROGRAM_MACHINE1 => self::STUDY_PROGRAM_MACHINE1,
        self::STUDY_PROGRAM_MACHINE2 => self::STUDY_PROGRAM_MACHINE2,
        self::STUDY_PROGRAM_ELECTRO1 => self::STUDY_PROGRAM_ELECTRO1,
        self::STUDY_PROGRAM_ELECTRO2 => self::STUDY_PROGRAM_ELECTRO2,
        self::STUDY_PROGRAM_ELECTRO3 => self::STUDY_PROGRAM_ELECTRO3,
        self::STUDY_PROGRAM_ELECTRO4 => self::STUDY_PROGRAM_ELECTRO4,
        self::STUDY_PROGRAM_ELECTRO5 => self::STUDY_PROGRAM_ELECTRO5,
        self::STUDY_PROGRAM_CHEMICAL1 => self::STUDY_PROGRAM_CHEMICAL1,
        self::STUDY_PROGRAM_CHEMICAL2 => self::STUDY_PROGRAM_CHEMICAL2,
        self::STUDY_PROGRAM_CHEMICAL3 => self::STUDY_PROGRAM_CHEMICAL3,
        self::STUDY_PROGRAM_CHEMICAL4 => self::STUDY_PROGRAM_CHEMICAL4,
        self::STUDY_PROGRAM_CHEMICAL5 => self::STUDY_PROGRAM_CHEMICAL5,
        self::STUDY_PROGRAM_ACCOUNTING1 => self::STUDY_PROGRAM_ACCOUNTING1,
        self::STUDY_PROGRAM_ACCOUNTING2 => self::STUDY_PROGRAM_ACCOUNTING2,
        self::STUDY_PROGRAM_BUSINESS_ADMINISTRATION1 => self::STUDY_PROGRAM_BUSINESS_ADMINISTRATION1,
        self::STUDY_PROGRAM_BUSINESS_ADMINISTRATION2 => self::STUDY_PROGRAM_BUSINESS_ADMINISTRATION2,
        self::STUDY_PROGRAM_BUSINESS_ADMINISTRATION3 => self::STUDY_PROGRAM_BUSINESS_ADMINISTRATION3,
        self::STUDY_PROGRAM_COMPUTER1 => self::STUDY_PROGRAM_COMPUTER1,
        self::STUDY_PROGRAM_COMPUTER2 => self::STUDY_PROGRAM_COMPUTER2,
        self::STUDY_PROGRAM_INFORMATICS_MANAGEMENT1 => self::STUDY_PROGRAM_INFORMATICS_MANAGEMENT1,
        self::STUDY_PROGRAM_INFORMATICS_MANAGEMENT2 => self::STUDY_PROGRAM_INFORMATICS_MANAGEMENT2,
    ];

    // Jurusan
    const MAJOR_CIVIL = "Teknik Sipil";
    const MAJOR_MACHINE = "Teknik Mesin";
    const MAJOR_ELECTRO = "Teknik Elektro";
    const MAJOR_CHEMICAL = "Teknik Kimia";
    const MAJOR_ACCOUNTING = "Akuntansi";
    const MAJOR_BUSINESS_ADMINISTRATION = "Administrasi Bisnis";
    const MAJOR_COMPUTER = "Teknik Komputer";
    const MAJOR_INFORMATICS_MANAGEMENT = "Manajemen Informatika";
    const MAJOR_ENGLISH = "Bahasa Inggris";


    const MAJOR_CHOICE = [
        self::MAJOR_CIVIL => self::MAJOR_CIVIL,
        self::MAJOR_MACHINE => self::MAJOR_MACHINE,
        self::MAJOR_ELECTRO => self::MAJOR_ELECTRO,
        self::MAJOR_CHEMICAL => self::MAJOR_CHEMICAL,
        self::MAJOR_ACCOUNTING => self::MAJOR_ACCOUNTING,
        self::MAJOR_BUSINESS_ADMINISTRATION => self::MAJOR_BUSINESS_ADMINISTRATION,
        self::MAJOR_COMPUTER => self::MAJOR_COMPUTER,
        self::MAJOR_INFORMATICS_MANAGEMENT => self::MAJOR_INFORMATICS_MANAGEMENT,
        self::MAJOR_ENGLISH => self::MAJOR_ENGLISH,
    ];

    const SEMESTER1 = "1";
    const SEMESTER2 = "2";
    const SEMESTER3 = "3";
    const SEMESTER4 = "4";
    const SEMESTER5 = "5";
    const SEMESTER6 = "6";
    const SEMESTER7 = "7";
    const SEMESTER8 = "8";
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
