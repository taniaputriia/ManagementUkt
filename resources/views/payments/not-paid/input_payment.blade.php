@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Pembayaran UKT</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Crypt::encrypt(Auth::user()->id) }}">
                <h5>Data Mahasiswa yang belum bayar</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nim">NIM </label>
                            <input type="text" class="form-control" id="nim" value="{{ $data['nim'] }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" value="{{ $data['name'] }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tuition_fee">Semester (Pembayaran Semester)</label>
                            <select class="form-select select_semester" name="semester" id="semester" required>
                                <option value="" selected>Pilih Salah Satu</option>
                                @foreach (App\Models\Student::SEMESTER_CHOICE as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                @error('semester')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </select>
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
                        <input type="number" min="0" name="va_number" class="form-control" id="va_number"
                            value="{{ old('va_number') }}" placeholder="masukkan nomor rekening" required>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <label>Pilih Jenis Pembayaran : </label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" id="full_payment"
                                value="option1">
                            <label class="form-check-label" for="full_payment">Lunas</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" id="credit_payment"
                                value="option2">
                            <label class="form-check-label" for="credit_payment">Cicilan</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="detail_payment">
                    </div>
                </div>

                <hr>
                <a href="{{ route('payment.index') }}" class="btn btn-warning">Kembali</a>
                <button type="submit" onclick="return confirm('Simpan Data? Data tidak dapat diedit kembali')"
                    class="btn btn-primary mr-2">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('js_after')
    <script>
        $(document).ready(function() {
            paymentSelect();
        });

        function paymentSelect() {
            $("#full_payment").click(function() {
                $('.detail_payment').empty();
                $(".detail_payment").append(`
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                            <label>Pembayaran : </label>
                            <input class="form-control" name ="total_payment" value="{{ $data['tuition_fee'] }}" readonly></input>
                                </div>
                            </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bukti Bayaran (Ekstensi Jpg,Jpeg,Png | Maks 1 MB)</label>
                            <input type="file" name="file" class="form-control" id="file"
                             required>
                        </div>
                    </div>
                            </div>

                `)
            });

            $("#credit_payment").click(function() {
                $('.detail_payment').empty();
                $(".detail_payment").append(`
                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_payment">Cicilan Pertama</label>
                            <input type="text" name="first_payment" class="form-control number-separator"
                            placeholder="masukkan cicilan pertama" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="second_payment">Cicilan Kedua</label>
                            <input type="text" name="second_payment" class="form-control number-separator"
                            placeholder="masukkan cicilan kedua" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="third_payment">Cicilan Ketiga</label>
                            <input type="text" name="third_payment" class="form-control number-separator"
                            placeholder="masukkan cicilan ketiga" required>
                        </div>
                    </div>
                </div>
                `)
            })
        }
    </script>
@endsection
