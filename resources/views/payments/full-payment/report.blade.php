@extends('layouts.app')

@section('content')
@hasanyrole('Admin Keuangan|Wakil Direktur II')
<div class="row">
    <div class="col-md-12 mb-4 mt-1">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h4 class="font-weight-bold">Laporan Pembayaran Lunas</h4>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a class="text-end btn btn-sm btn-outline-info" href="{{ route('student.create') }}"><i
                                class="fa fa-plus"></i> cetak</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-striped table-bordered text-nowrap"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama Lengkap</th>
                                        <th>Semester</th>
                                        <th>UKT</th>
                                        <th>Tanggal</th>
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
@endsection

@section('js_after')
@hasanyrole('Admin Keuangan|Wakil Direktur II')
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
                    columns: [{
                            data: null,
                            sortable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
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
                            name: 'semester',
                            data: 'semester'
                        },
                        {
                            name: 'tuition_fee',
                            data: 'tuition_fee'
                        },
                        {
                            name: 'created_at',
                            data: 'created_at'
                        },
                    ],
                });
            }
        </script>
@endhasanyrole
@endsection

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembayaran Lunas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <img src="" width="100px">
    <h5 class="text-center">Laporan Pembayaran Lunas</h5>
    <br>

    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Semester</th>
                <th>Nomor Rekening</th>
                <th>UKT</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @php
                $i = 1;
            @endphp
            @forelse ($data as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item ['student']['nim'] }}</td>
                    <td>{{ $item ['student']['name'] }}</td>
                    <td>{{ $item ['semester']}}</td>
                    <td>{{ $item ['va_number'] }}</td>
                    <td>{{ $item ['tuition_fee'] }}</td>
                    <td>{{ $item ['status'] }}</td>
                    <td>{{ $item ['created_at'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data Tidak Ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html> --}}

