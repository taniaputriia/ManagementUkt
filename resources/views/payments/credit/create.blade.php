@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Pembayaran Cicilan</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('payment.update_credit', Crypt::encrypt($data['id'])) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <h5>Data Mahasiswa Pembayaran Cicilan</h5>
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
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="va_number">Nomor Rekening</label>
                        <input type="number" name="va_number" class="form-control" id="va_number"
                            value="{{ $data['va_number'] }}" placeholder="masukkan nomor rekening" disabled>
                    </div>
                </div>
                <hr>
                <h5>Data Cicilan</h5>

                @if ($data->status == App\Models\Payment::STATUS_CREDIT)
                    <input type="hidden" name="type" value="1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_payment">Cicilan Pertama</label>
                                <input type="text" class="form-control" id="first_payment" value="@currency($data['first_payment'])"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_payment">Total Bayar</label>
                                <input type="text" name="first_payment" class="form-control" id="first_payment"
                                    value="@currency($data['first_payment'])" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bukti Bayaran (Ekstensi Jpg,Jpeg,Png | Maks 1 MB)</label>
                                <input type="file" name="file" class="form-control" id="file" required>
                            </div>
                        </div>
                    </div>
                @elseif ($data->status == App\Models\Payment::STATUS_FIRST_CREDIT)
                    <input type="hidden" name="type" value="2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="second_payment">Cicilan Kedua</label>
                                <input type="text" class="form-control" id="second_payment" value="@currency($data['second_payment'])"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="second_payment">Total Bayar</label>
                                <input type="text" name="second_payment" class="form-control" id="second_payment"
                                    value="@currency($data['second_payment'])" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bukti Bayaran (Ekstensi Jpg,Jpeg,Png | Maks 1 MB)</label>
                                <input type="file" name="file" class="form-control" id="file" required>
                            </div>
                        </div>
                    </div>
                @elseif ($data->status == App\Models\Payment::STATUS_SECOND_CREDIT)
                    <input type="hidden" name="type" value="3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="third_payment">Cicilan Ketiga</label>
                                <input type="text" class="form-control" id="third_payment" value="@currency($data['third_payment'])"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="third_payment">Total Bayar</label>
                                <input type="text" name="third_payment" class="form-control" id="third_payment"
                                    value="@currency($data['third_payment'])" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bukti Bayaran (Ekstensi Jpg,Jpeg,Png | Maks 1 MB)</label>
                                <input type="file" name="file" class="form-control" id="file" required>
                            </div>
                        </div>
                    </div>
                @endif
                <br>
                <a href="{{ route('payment.index_credit') }}" class="btn btn-warning">Kembali</a>
                <button type="submit" onclick="return confirm('Konfirmasi Pembayaran?')"
                    class="btn btn-primary mr-2">Simpan</button>
            </form>
        </div>
    </div>
@endsection
