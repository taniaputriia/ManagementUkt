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
            <form action="{{ route('student.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h5>Akun Mahasiswa</h5>
                <div class="form-group">
                    <label for="user_name">Nama User </label>
                    <input type="text" name="user_name" class="form-control" id="user_name"
                        value="{{ old('user_name') }}" placeholder="Nama User..." required>
                </div>
                <div class="form-group">
                    <label for="email">Email </label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                        placeholder="Email..." required>
                </div>
                <div class="form-group">
                    <label for="password">Password </label>
                    <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}"
                        placeholder="Password..." required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Konfirmasi Password </label>
                    <input type="password" name="confirm-password" class="form-control" id="confirm-password"
                        value="{{ old('confirm-password') }}" placeholder="Konfirmasi Password..." required>
                </div>
                <hr>
                <h5>Data Mahasiswa</h5>
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
                    <label for="gender">Jenis Kelamin</label>

                    <select class="form-select" name="gender" id="gender" required>
                        <option value="" selected>Pilih Salah Satu</option>
                        @foreach (App\Models\Student::GENDER_CHOICE as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone_number">No Hp </label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number"
                        value="{{ old('phone_number') }}" placeholder="masukkan nomor hp" required>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" name="address" class="form-control" id="address"required>
                        </textarea>
                </div>
                <div class="form-group">
                    <label for="study_program">Program Studi</label>
                    <select class="form-select select_study_program" name="study_program" id="study_program" required>
                        <option value="" selected>Pilih Salah Satu</option>
                        @foreach (App\Models\Student::STUDY_PROGRAM_CHOICE as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        @error('study_program')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
                <div class="form-group">
                    <label for="major">Jurusan</label>
                    <select class="form-select select_major" name="major" id="major" required>
                        <option value="" selected>Pilih Salah Satu</option>
                        @foreach (App\Models\Student::MAJOR_CHOICE as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        @error('major')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select class="form-select select_semester" name="semester" id="study_program" required>
                        <option value="" selected>Pilih Salah Satu</option>
                        @foreach (App\Models\Student::STUDY_PROGRAM_CHOICE as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        @error('semester')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>

                <div class="form-group">
                    <label for="academic_year">Tahun Akademik</label>
                    <input type="text" name="academic_year" class="form-control" id="academic_year"
                        value="{{ old('academic_year') }}" placeholder="masukkan tahun akademik anda" required>
                </div>
                <div class="form-group">
                    <label for="tuition_fee">Uang Kuliah Tunggal</label>
                    <input type="text" name="tuition_fee" class="form-control number-separator" id="tuition_fee"
                        value="{{ old('tuition_fee') }}" placeholder="masukkan ukt">
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="photo" class="form-control" id="photo"
                        value="{{ old('photo') }}" placeholder="masukkan foto" required>
                </div>
                <hr>
                <a href="{{ route('student.index') }}" class="btn btn-warning">Kembali</a>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('js_after')
    {{-- Select 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".select_user").select2();
            $(".select_study_program").select2();
            $(".select_study_department").select2();
        });
    </script>
@endsection
