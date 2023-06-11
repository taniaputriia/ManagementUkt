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
                    <label for="user_id">Nama Akun </label>
                    <select class="form-select select_user" name="user_id" id="user_id" required>
                        <option value="" selected>Pilih Akun</option>
                        @foreach ($users as $item)
                            <option value="{{ Crypt::encrypt($item->id) }}">{{ $item->name }}</option>
                        @endforeach
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
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
                    <textarea name="address" name="address" class="form-control" id="address" value="{{ old('address') }}"required>
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
                    <input type="text" name="semester" class="form-control" id="semester" value="{{ old('semester') }}"
                        placeholder="masukkan semester" required>
                </div>

                <div class="form-group">
                    <label for="academic_year">Tahun Akademik</label>
                    <input type="text" name="academic_year" class="form-control" id="academic_year"
                        value="{{ old('academic_year') }}" placeholder="masukkan tahun akademik anda" required>
                </div>
                <div class="form-group">
                    <label for="tuition_fee">Uang Kuliah Tunggal</label>
                    <input type="currency" name="tuition_fee" class="form-control" id="tuition_fee"
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
