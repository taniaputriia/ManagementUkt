@extends('layouts.app')

@section('css_after')
@endsection

@section('content-header')
    <div class="page-header">
        <div class="page-title">
            <div class="row">
                <div class="col-12 md-6">
                    <h3>Data Mahasiswa</h3>
                </div>
                <div class="col-12 md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Data Mahasiswa</h4>
                    </div>
                    <a class="text-end btn btn-sm btn-outline-info" href="{{ route('student.create') }}"><i
                            class="fa fa-plus"></i> Tambah Data</a>
                </div>

                <div class="card-content">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Nim</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No Hp</th>
                                        <th>Alamat</th>
                                        <th>Program Studi</th>
                                        <th>Jurusan</th>
                                        <th>Semester</th>
                                        <th>Tahun Akademik</th>
                                        <th>Uang Kuliah Tunggal</th>
                                        <th>Foto</th>
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
</section>
@endsection

@section('js_after')
    <script>
        $(document).ready(function() {
            getDatatable();
        });

        let data_table = "";

        function getDatatable() {
            data_table = $("#data-table").DataTable({
                ajax: {
                    url: "{{ route('student.datatable') }}",
                },
                serverSide: true,
                destroy: true,
                order: [
                    [4, 'desc']
                ],
                columns: [{
                        "data": null,
                        "sortable": false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
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
                        name: 'gender',
                        data: 'gender'
                    },
                    {
                        name: 'phone_number',
                        data: 'phone_number'
                    },
                    {
                        name: 'address',
                        data: 'address'
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
                    {
                        name: 'photo',
                        data: 'photo'
                    },
                ],
            });
        }
    </script>
@endsection
