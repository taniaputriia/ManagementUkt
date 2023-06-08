@extends('layouts.app')

@section('css_after')
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Lihat Role</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <h4 class="card-title text-center">{{ $role['name'] }}</h4>
            <hr>
            <div class="form-group">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hak Akses</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($rolePermissions as $item)
                                    <button type="button"
                                        class="btn btn-outline-primary btn-sm mr-2">{{ $item['name'] }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('role.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@endsection

@section('js_after')
@endsection
