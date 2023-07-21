@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Verifikasi Pembayaran Lunas</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('payment.verification_full_payment', Crypt::encrypt($data['id'])) }}" method="post">
                @csrf
                @method('put')
                <h5>Data Mahasiswa Pembayaran Lunas</h5>
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
                            <input type="text" class="form-control" id="name" value="{{ $data['semester'] }}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tuition_fee">Uang Kuliah Tunggal</label>
                            <input type="text" class="form-control number-separator" id="tuition_fee"
                                value="@currency($data['tuition_fee'])" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="va_number">Nomor Rekening</label>
                            <input type="number" name="va_number" class="form-control" id="va_number"
                                value="{{ $data['va_number'] }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="created_at">Tanggal</label>
                            <input type="text" name="created_at" class="form-control" id="created_at"
                                value="{{ $data['created_at'] }}" disabled>
                        </div>
                    </div>
                <div class="col-md-12 mb-5 mt-4">
                    <div class="text-center">
                        <h5>Bukti Pembayaran</h5>
                        <img src="{{ asset('assets/bukti_bayar/' . $data['file']) }}" alt="{{ $data['file'] }}"
                            class="img-thumbnail" width="80%">
                    </div>
                </div>
                </div>
                <a href="{{ route('payment.index_verification_full_payment') }}" class="btn btn-warning">Kembali</a>
                <button type="submit" onclick="return confirm('Konfirmasi Pembayaran?')"
                    class="btn btn-primary mr-2">Konfirmasi</button>
            </form>
        </div>
    </div>
@endsection
