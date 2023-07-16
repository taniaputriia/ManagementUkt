@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data Mahasiswa yang belum bayar</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="text-center mb-3">
                    <img src="{{ asset('assets/mahasiswa/' . $data['student']['photo']) }}" class="rounded-circle"
                        alt="{{ $data['student']['photo'] }}" width="200px">
                </div>
                <div class="col-lg-6">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="{{ $data['student']['nim'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $data['student']['name'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Semester</label>
                    <input type="text" class="form-control" value="{{ $data['student']['gender'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Uang Kuliah Tunggal (UKT)</label>
                    <input type="text" class="form-control" value="@currency($data['tuition_fee'])" disabled>
                </div>
                <div class="col-lg-6">
                    <label>No. Handphone</label>
                    <input type="text" class="form-control" value="{{ $data['student']['phone_number'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Alamat</label>
                    <input type="text" class="form-control" value="{{ $data['student']['address'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Program Studi</label>
                    <input type="text" class="form-control" value="{{ $data['student']['study_program'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Jurusan</label>
                    <input type="text" class="form-control" value="{{ $data['student']['major'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Semester</label>
                    <input type="text" class="form-control" value="{{ $data['student']['semester'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Tahun Akademik</label>
                    <input type="text" class="form-control" value="{{ $data['student']['academic_year'] }}" disabled>
                </div>

            </div>
            <hr>
            <a href="{{ route('payment.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@endsection
