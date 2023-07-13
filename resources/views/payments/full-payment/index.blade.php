@extends('layouts.app')

@section('content')
    {{-- Admin --}}
    @role('Bagian Keuangan')
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Data Pembayaran Lunas</h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Manajemen Data Pembayaran Lunas</h4>
                                </div>
                                {{-- <a class="text-end btn btn-sm btn-outline-info" href="{{ route('payment.create') }}"><i
                                        class="fa fa-plus"></i> Tambah Data</a> --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped table-bordered text-nowrap"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Aksi</th>
                                                <th>Nim</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nomor Rekening</th>
                                                <th>UKT</th>
                                                <th>Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    {{-- Mahasiswa --}}
    @role('Mahasiswa')
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Data Pembayaran</h4>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-block p-card">
                            <div class="profile-box">
                                <div class="profile-card rounded">
                                    <img src="{{ asset('assets/mahasiswa/' . $student['photo']) }}" alt="Mahasiswa"
                                        class="avatar-100 rounded d-block mx-auto img-fluid mb-3" width="250px">
                                    <h3 class="font-600 text-white text-center mb-4">Mahasiswa</h3>
                                </div>
                                <hr>
                                <div class="pro-content rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>NIM</label>
                                                <input type="text" class="form-control" value="{{ $student['nim'] }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" value="{{ $student['name'] }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Nomor Rekening</label>
                                                <input type="text" class="form-control" value="{{ $student['gender'] }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>No HP</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $student['phone_number'] }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control" value="{{ $student['address'] }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Program Studi</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $student['study_program'] }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Semester</label>
                                                <input type="text" class="form-control" value="{{ $student['semester'] }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Tahun Akademik</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $student['academic_year'] }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Uang Kuliah Tunggal</label>
                                                <input type="text" class="form-control"
                                                    value="Rp.{{ number_format($student['tuition_fee']) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection

@section('js_after')
    <script>
        $(document).ready(function() {
            getDatatable();
        });

        let data_table = "";

        function getDatatable() {
            data_table = $("#data-table").DataTable({
                ajax: "{{ route('payment.datatable') }}",
                serverSide: true,
                processing: true,
                destroy: true,
                order: [
                    [3, 'asc']
                ],
                columns: [{
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: null,
                        sortable: false,
                        name: 'action',
                        data: 'action'
                    },

                    {
                        name: 'nim',
                        data: 'nim'
                    },
                    {
                        name: 'name',
                        data: 'name'
                    },
                    {
                        name: 'va_number'
                        data: 'va_number'
                    },
                    {
                        name: 'tuition_fee',
                        data: 'tuition_fee'
                    },
                    {
                        name: 'total_payment',
                        data: 'total_payment'
                    },
                    {
                        name: 'remain_payment',
                        data: 'remain_payment'
                    },
                    {
                        name: 'first_payment',
                        data: 'first_payment'
                    },
                    {
                        name: 'second_payment',
                        data: 'second_payment'
                    },
                    {
                        name: 'third_payment',
                        data: 'third_payment'
                    },
                    {
                        name: 'verified',
                        data: 'verified'
                    },
                    {
                        name: 'status',
                        data: 'status'
                    },
                    {
                        name: 'description',
                        data: 'description'
                    },
                ],
            });
        }
    </script>
@endsection
