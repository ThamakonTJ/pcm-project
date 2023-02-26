@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.saffs.layouts.saff-dash-layout'))

@section('title', 'Profile')

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Edit Invoice</title>
    </head>

    <body>

        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Edit Invoice</h2>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('invoice.update', $invoiceid->id) }} " method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>หมายเลขใบสั่งซื้อ PO</strong>
                            <input type="text" name="PO_NO" class="form-control" value="{{ $invoiceid->PO_NO }}">
                            @error('PO_NO')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>หมายเลขใบส่งของ Invoice</strong>
                            <input type="text" name="In_No" class="form-control" value="{{ $invoiceid->In_No }}">
                            @error('In_No')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>ชื่อบริษัท</strong>
                            <input type="text" name="sup_name" class="form-control" value="{{ $invoiceid->sup_name }}">
                            @error('sup_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>ผู้รับ</strong>
                            <input type="text" name="recipient" class="form-control"
                                value="{{ $invoiceid->recipient }}">
                            @error('recipient')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>เอกสาร</strong>
                            <input type="file" name="invoices_file" class="form-control"
                                value="{{ $invoiceid->quotation_file }}">
                            @error('invoices_file')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>ราคารวม</strong>
                            <input type="text" name="price" class="form-control"
                                value="{{ $invoiceid->price }}">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">อัพเดท</button>

            </div>
        </div>
        </div>
        </form>


        </div>

        </div>
    </body>



@endsection
