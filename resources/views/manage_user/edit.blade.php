@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Edit User</title>
    </head>

    <body>
        <div class="py-12"></div>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Edit Product</h2>
                </div>
                <div>
                    <a href="{{ route('manage_user.index') }}" class="btn btn-primary">Back</a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('manage_user.update', $user->id ) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>ชื่อผู้ใช้</strong>
                            <input type="text" name="name" class="form-control"
                                value="{{ $user->name }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>        
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>อีเมล</strong>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>brand_id</strong>
                                <input type="text" name="brand_id" class="form-control"
                                    value="{{ $product->brand_id }}">
                                @error('brand')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Model ID</strong>
                                <input type="text" name="model_id" class="form-control"
                                    value="{{ $product->model_id }}">
                                @error('model_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>BOM ID</strong>
                                <input type="text" name="bom_id" class="form-control" value="{{ $product->bom_id }}">
                                @error('bom_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>จำนวน</strong>
                                <input type="text" name="quantity" class="form-control"
                                    value="{{ $product->quantity }}">
                                @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">อัพเดท</button>
                    </div>
                </form>



            </div>
        </div>
        </div>
    </body>



@endsection
