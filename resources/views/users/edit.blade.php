@extends('layouts.app')

@section('css_after')
    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Edit User</h4>
            </div>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('user.update', Crypt::encrypt($user['id'])) }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="name">Nama User </label>
                    <input type="text" name="name" class="form-control" id="name"
                        value="{{ old('name', $user['name']) }}" placeholder="Nama Role..." required>
                </div>
                <div class="form-group">
                    <label for="email">Email </label>
                    <input type="email" name="email" class="form-control" id="email"
                        value="{{ old('email', $user['email']) }}" placeholder="Email..." required>
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
                <div class="form-group">
                    <label>Role </label>
                    <select name="roles[]" class="form-control mb-3 select_role" multiple required>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>
                                {{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('user.index') }}" class="btn btn-warning">Kembali</a>
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
