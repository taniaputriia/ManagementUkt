@extends('layouts.app')

@section('css_after')
@endsection

@section('content-header')
    <h3>Profile Statistics</h3>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="form-group has-icon-left">
            <label for="first-name-icon">Nama Lengkap</label>
            <div class="position-relative">
                <input type="text" class="form-control"
                    placeholder="Input with icon left" id="first-name-icon">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">

        <div class="form-group has-icon-left">
            <label for="email-id-icon">Email</label>
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Email"
                    id="email-id-icon">
                <div class="form-control-icon">
                    <i class="bi bi-envelope"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group has-icon-left">
            <label for="mobile-id-icon">Mobile</label>
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Mobile"
                    id="mobile-id-icon">
                <div class="form-control-icon">
                    <i class="bi bi-phone"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group has-icon-left">
            <label for="password-id-icon">Password</label>
            <div class="position-relative">
                <input type="password" class="form-control" placeholder="Password"
                    id="password-id-icon">
                <div class="form-control-icon">
                    <i class="bi bi-lock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class='form-check'>
            <div class="checkbox mt-2">
                <input type="checkbox" id="remember-me-v" class='form-check-input'
                    checked>
                <label for="remember-me-v">Remember Me</label>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
        <button type="reset"
            class="btn btn-light-secondary me-1 mb-1">Reset</button>
    </div>
</div>
@endsection

@section('js_after')
@endsection
