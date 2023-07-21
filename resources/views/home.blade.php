@extends('layouts.app')

@section('css_after')
@endsection

@section('content-header')
    <h3>Dashboard</h3>
@endsection

@section('content')
    <section class="row">
        @hasanyrole('Bagian Keuangan|Admin KPA|Wakil Direktur II')
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Mahasiswa Polsri</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalStudent }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah yang mengajukan cicilan</h6>
                                        {{-- <h6 class="font-extrabold mb-0">{{ $totalCreditPayment }}</h6> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah yang belum bayar cicilan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalNotPaidPayment }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah mahasiswa lunas cicilan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalFullPayment }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Golongan Uang Kuliah Tunggal Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="3">Program Studi</th>
                                            </tr>
                                            <tr>
                                                <th colspan="6" align="center">Uang Kuliah Tunggal Per Semester</th>
                                            </tr>
                                            <tr>
                                                <th>Kel. III</th>
                                                <th>Kel. IV</th>
                                                <th>Kel. V</th>
                                                <th>Kel. VI</th>
                                                <th>Kel. VII</th>
                                                <th>Kel. VIII</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>D3 Administrasi Bisnis</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Akuntansi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Bahasa Inggris</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Manajemen Informatika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Elektronika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Kimia</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Komputer</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Listrik</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Mesin</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Sipil</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Telekomunikasi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Akuntansi Sektor Publik</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Manajemen Bisnis</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Manajemen Informatika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Perancangan Jalan dan Jembatan</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Elektronika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Energi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Mesin Produksi Dan Perawatan</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Kimia</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Telekomunikasi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknologi Informatika Multimedia Digital </th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknologi Kimia Industri</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Usaha Perjalanan Wisata</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        @endhasanyrole
    </section>

    <section class="row">
        @role('Mahasiswa')

            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Golongan Uang Kuliah Tunggal Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="3">Program Studi</th>
                                            </tr>
                                            <tr>
                                                <th colspan="6" align="center">Uang Kuliah Tunggal Per Semester</th>
                                            </tr>
                                            <tr>
                                                <th>Kel. III</th>
                                                <th>Kel. IV</th>
                                                <th>Kel. V</th>
                                                <th>Kel. VI</th>
                                                <th>Kel. VII</th>
                                                <th>Kel. VIII</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>D3 Administrasi Bisnis</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Akuntansi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Bahasa Inggris</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Manajemen Informatika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Elektronika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Kimia</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Komputer</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Listrik</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Mesin</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Sipil</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Telekomunikasi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Akuntansi Sektor Publik</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Manajemen Bisnis</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Manajemen Informatika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Perancangan Jalan dan Jembatan</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Elektronika</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Energi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Mesin Produksi Dan Perawatan</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D3 Teknik Kimia</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknik Telekomunikasi</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknologi Informatika Multimedia Digital </th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Teknologi Kimia Industri</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>9.000.000</th>
                                            </tr>
                                            <tr>
                                                <th>D4 Usaha Perjalanan Wisata</th>
                                                <th>1.420.000</th>
                                                <th>2.500.000</th>
                                                <th>4.000.000</th>
                                                <th>5.500.000</th>
                                                <th>6.500.000</th>
                                                <th>7.500.000</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        @endrole
    </section>
@endsection

@section('js_after')
@endsection
