@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp
@extends(Auth()->user()->role == 2 ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout')

@section('title', 'Profile')

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Create Supplier</title>
    </head>

    <body>

        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <h2>เพิ่มผู้ใช้งาน</h2>
                </div>
                <div>
                    <a href="{{ route('manage_user.index') }}" class="btn btn-primary">Back</a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('manage_user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>ชื่อผู้ใช้</strong>
                                <input type="text" name="name" class="form-control">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>อีเมล</strong>
                                <input type="text" name="email" class="form-control">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>ตำแหน่งผู้ใช้งาน</strong>
                                <select name="role" id="role" class="form-control">
                                    <option value="2">Admin</option>
                                    <option value="0">Purchasing Officer</option>
                                    <option value="1">Warehouse staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>รหัส</strong>
                                <input type="text" name="password" class="form-control">
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>



            </div>

        </div>
    </body>



@endsection
