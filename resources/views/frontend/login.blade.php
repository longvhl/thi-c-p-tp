@extends('layouts.client')

@section('title', 'Đăng nhập - BikeGo')

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-theme-blue text-center py-3">
                    <h5 class="mb-0"><i class="fa fa-sign-in-alt"></i> Đăng nhập</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="example@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-theme w-100 fw-bold rounded-pill p-2">Đăng nhập</button>
                        <div class="text-center mt-4">
                            <a href="/register" class="text-theme-pink text-decoration-none fw-bold">Chưa có tài khoản? Đăng ký tài khoản</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
