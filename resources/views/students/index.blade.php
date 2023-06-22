@extends('layouts.app')

@section('css_after')

@endsection

@section('content')
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
                                <table id="data-table" class="table table-striped table-bordered" width="100%">
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
@endsection

@section('js_after')
    {{-- Select 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            getDatatable();
            $(".select_meeting_room").select2();
        });

        let data_table = "";

        function getDatatable() {
            data_table = $("#data-table").DataTable({
                ajax: "{{ route('student.datatable') }}",
                serverSide: true,
                processing: true,
                destroy: true,
                order: [
                    [5, 'desc']
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
