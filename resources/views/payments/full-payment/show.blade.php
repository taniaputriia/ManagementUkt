@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data Mahasiswa Pembayaran Lunas</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nim">NIM </label>
                        <input type="text" class="form-control" id="nim" value="{{ $data['student']['nim'] }}"
                            disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" value="{{ $data['student']['name'] }}"
                            disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tuition_fee">Semester (Pembayaran Semester)</label>
                        <input type="text" class="form-control" id="name" value="{{ $data['semester'] }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tuition_fee">Uang Kuliah Tunggal</label>
                        <input type="text" class="form-control number-separator" id="tuition_fee"
                            value="@currency($data['tuition_fee'])" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="va_number">Nomor Rekening</label>
                    <input type="number" name="va_number" class="form-control" id="va_number"
                        value="{{ $data['va_number'] }}" placeholder="masukkan nomor rekening" disabled>
                </div>
            </div>
            <a href="{{ route('payment.index_full_payment') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@endsection
