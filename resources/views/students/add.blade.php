@extends('layouts.app')

@section('css_after')
    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Tambah Data</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('student.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nim">NIM </label>
                    <input type="text" name="nim" class="form-control" id="nim" value="{{ old('nim') }}"
                        placeholder="masukkan nim anda" required>
                </div>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"
                        placeholder="masukkan nama anda" required>
                </div>
                <div class="form-group">
                    <label for="text">Jenis Kelamin</label>
                    <input type="text" name="gender" class="form-control" id="gender" value="{{ old('gender') }}"
                        placeholder="masukkan jenis kelamin" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">No Hp </label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number"
                        value="{{ old('phone_number') }}" placeholder="masukkan nomor hp" required>
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}"
                        placeholder="masukkan alamat anda" required>
                </div>
                <div class="form-group">
                    <label for="study_program">Program Studi</label>
                    <input type="text" name="study_program" class="form-control" id="study_program" value="{{ old('study_program') }}"
                        placeholder="masukkan program studi anda" required>
                </div>
                <div class="form-group">
                    <label for="major">Jurusan</label>
                    <input type="text" name="major" class="form-control" id="major" value="{{ old('major') }}"
                        placeholder="masukkan jurusan" required>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" name="semester" class="form-control" id="semester"
                        value="{{ old('semester') }}" placeholder="masukkan semester" required>
                </div>

                <div class="form-group">
                    <label for="academic_year">Tahun Akademik</label>
                    <input type="text" name="academic_year" class="form-control" id="academic_year" value="{{ old('academic_year') }}"
                        placeholder="masukkan tahun akademik anda" required>
                </div>
                <div class="form-group">
                    <label for="tuition_fee">Uang Kuliah Tunggal</label>
                    <input type="currency" name="tuition_fee" class="form-control" id="tuition_fee" value="{{ old('tuition_fee') }}"
                        placeholder="masukkan ukt">
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="text" name="photo" class="form-control" id="photo"
                        value="{{ old('photo') }}" placeholder="masukkan foto" required>
                </div>
                <hr>

                <a href="{{ route('student.index') }}" class="btn btn-warning">Kembali</a>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('js_after')
    {{-- Select 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".select_role").select2();
        });
    </script>
@endsection
