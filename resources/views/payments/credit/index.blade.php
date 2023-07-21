@extends('layouts.app')

@section('content')
    {{-- Admin --}}
    @hasanyrole('Bagian Keuangan|Admin KPA|Wakil Direktur II')
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Data Pembayaran Cicilan</h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Manajemen Data Pembayaran Cicilan</h4>
                                </div>
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
                                                <th>Semester</th>
                                                <th>UKT</th>
                                                <th>Sisa Pembayaran</th>
                                                <th>Status</th>
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
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Data Pembayaran Cicilan</h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Data Pembayaran Cicilan</h4>
                                </div>
                            </div>
                            <a class="text-end btn btn-sm btn-danger" target = "_blank" href="{{ route('payment.report_credit') }}"><i class="fa fa-plus"></i> Cetak PDF</a>
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
                                                <th>Semester</th>
                                                <th>UKT</th>
                                                <th>Sisa Pembayaran</th>
                                                <th>Status</th>
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
@endsection

@section('js_after')
@hasanyrole('Bagian Keuangan|Admin KPA|Wakil Direktur II')
        <script>
            $(document).ready(function() {
                getDatatable();
            });

            let data_table = "";

            function getDatatable() {
                data_table = $("#data-table").DataTable({
                    ajax: "{{ route('payment.datatable_credit') }}",
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
                            name: 'semester',
                            data: 'semester'
                        },
                       
                        {
                            name: 'tuition_fee',
                            data: 'tuition_fee'
                        },
                        {
                            name: 'remain_payment',
                            data: 'remain_payment'
                        },
                        {
                            name: 'status',
                            data: 'status'
                        },
                    ],
                });
            }
        </script>
    @endhasanyrole

    @role('Mahasiswa')
        <script>
            $(document).ready(function() {
                getDatatable();
            });

            let data_table = "";

            function getDatatable() {
                data_table = $("#data-table").DataTable({
                    ajax: "{{ route('payment.datatable_credit_student') }}",
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
                            name: 'semester',
                            data: 'semester'
                        },
                        {
                            name: 'va_number',
                            data: 'va_number'
                        },
                        {
                            name: 'tuition_fee',
                            data: 'tuition_fee'
                        },
                        {
                            name: 'remain_payment',
                            data: 'remain_payment'
                        },
                        {
                            name: 'status',
                            data: 'status'
                        },
                    ],
                });
            }
        </script>
    @endrole
@endsection
