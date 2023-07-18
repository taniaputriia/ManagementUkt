@extends('layouts.app')

@section('content')
    {{-- Admin --}}
    @hasanyrole('Bagian Keuangan|Admin KPA|Wakil Direktur II')
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Data Mahasiswa</h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Manajemen Data Mahasiswa</h4>
                                </div>
                                <a class="text-end btn btn-sm btn-outline-info" href="{{ route('student.create') }}"><i
                                        class="fa fa-plus"></i> Tambah Data</a>
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
                                                <th>Program Studi</th>
                                                <th>Jurusan</th>
                                                <th>Semester</th>
                                                <th>Tahun Akademik</th>
                                                <th>Uang Kuliah Tunggal</th>
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
    @endhasanyrole

    {{-- Mahasiswa --}}
    @role('Mahasiswa')
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Data Mahasiswa</h4>
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
                                                <label>Jenis Kelamin</label>
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
                ajax: "{{ route('student.datatable') }}",
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
                        name: 'study_program',
                        data: 'study_program'
                    },
                    {
                        name: 'major',
                        data: 'major'
                    },
                    {
                        name: 'semester',
                        data: 'semester'
                    },
                    {
                        name: 'academic_year',
                        data: 'academic_year'
                    },
                    {
                        name: 'tuition_fee',
                        data: 'tuition_fee'
                    },
                ],
            });
        }
    </script>
@endsection
