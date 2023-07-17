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
                    <input type="text" class="form-control" value="{{ $data['student']['semester'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Uang Kuliah Tunggal (UKT)</label>
                    <input type="text" class="form-control" value="@currency($data['tuition_fee'])" disabled>
                </div>
                <div class="col-lg-6">
                    <label>No. Rekening</label>
                    <input type="text" class="form-control" value="{{ $data['va_number'] }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Sisa Pembayaran</label>
                    <input type="text" class="form-control" value="@currency($data['remain_payment'])" disabled>
                </div>


            </div>
            <hr>
            <a href="{{ route('payment.index_credit') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@endsection
