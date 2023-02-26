@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))

@section('title', 'Quotation')

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Create Quotation</title>
    </head>

    <body>

        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <h2>เพิ่มใบเสนอราคา</h2>
                </div>
                <div class="container mt-2">
                    <a href="{{ route('quotation.index') }}" class="btn btn-primary">Back</a>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('quotation.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <label for="date" class="col-sm-1 col-form-label" name="date">วันที่</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>เลขที่เอกสารใบเสนอราคา</strong>
                                <input type="text" name="job_no" class="form-control">
                                @error('job_no')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>ชื่อบริษัท</strong>
                                <input type="text" name="sup_name" class="form-control">
                                @error('sup_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>ผู้รับ</strong>
                                <input type="text" name="recipient" class="form-control">
                                @error('recipient')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>เอกสาร</strong>
                                <input type="file" name="quotation_file" class="form-control">
                                @error('quotation_file')
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
