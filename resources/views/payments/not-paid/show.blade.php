@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data Mahasiswa yang belum bayar</h4>
            </div>
        </div>

        <div class="card-body">
            {{-- <h5>Akun Mahasiswa</h5>
            <div class="row">
                <div class="col-lg-6">
                    <label>Nama User</label>
                    <input type="text" class="form-control" value="{{ $data['user']['name'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{ $data['user']['email'] }}" disabled>
                </div>
            </div>
            <hr> --}}
            <h5>Data Mahasiswa</h5>
            <div class="row">
                <div class="text-center">
                    <img src="{{ asset('assets/mahasiswa/' . $data['photo']) }}" class="rounded-circle"
                        alt="{{ $data['photo'] }}" width="200px">
                </div>
                <div class="col-lg-6">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="{{ $data['nim'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $data['name'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Jenis Kelamin</label>
                    <input type="text" class="form-control" value="{{ $data['gender'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>No. Handphone</label>
                    <input type="text" class="form-control" value="{{ $data['phone_number'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Alamat</label>
                    <input type="text" class="form-control" value="{{ $data['address'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Program Studi</label>
                    <input type="text" class="form-control" value="{{ $data['study_program'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Jurusan</label>
                    <input type="text" class="form-control" value="{{ $data['major'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Semester</label>
                    <input type="text" class="form-control" value="{{ $data['semester'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Tahun Akademik</label>
                    <input type="text" class="form-control" value="{{ $data['academic_year'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Uang Kuliah Tunggal (UKT)</label>
                    <input type="text" class="form-control" value="@currency($data['tuition_fee'])" disabled>
                </div>
            </div>
            <hr>
            <a href="{{ route('payment.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@endsection
