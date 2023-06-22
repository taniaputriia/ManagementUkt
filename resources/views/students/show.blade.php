@extends('layouts.app')

@section('css_after')
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Lihat Data</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-block p-card">
                        <div class="profile-box">
                            <div class="profile-card rounded">
                                <h3 class="font-600 text-black text-center mb-4">{{ $student['nim'] }}</h3>
                                <h3 class="font-600 text-black text-center mb-4">{{ $student['name'] }}</h3>
                                <div class="card">{{ $student['photo'] }}</div>

                            </div>
                            <div class="pro-content rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-icon mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="mb-0 eml">{{ $student['address'] }}</p>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-icon mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
@endsection

@section('js_after')
@endsection
