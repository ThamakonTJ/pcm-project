@extends('dashboards.users.layouts.user-dash-layout')
@section('title','Quotation')
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')

<h1>Quotation</h1>
    <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
       @csrf
          
       @if (Session::has('success'))
       <div class="alert alert-success text-center">
           <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
           <p>{{ Session::get('success') }}</p>
       </div>
        @endif
       
        <div class="mb-3 row">
            <label for="text" class="col-sm-1 col-form-label">เลขที่เอกสารใบเสนอราคา</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="Job_No">
            </div>
            <label for="text" class="col-sm-1 col-form-label">ชื่อบริษัท</label>
            <div class="col">
                <input type="text" class="form-control" id="sup_name">
            </div>
        </div>
        <div class="mb-3 row">
            
            <label for="text" class="col-sm-1 col-form-label">ผู้รับ</label>
            <div class="col">
                <input type="text" class="form-control" id="recipient">
            </div>
        </div>  
        <div class="col-md-12">
            <label for="text" class="col-sm-1 col-form-label">เอกสาร</label>
                <input type="file" name="quotation_file" class="form-control">
        </div> 
        <br>      
        <button type="submit" class="btn btn-primary">ยืนยัน</button>
        @php
        $success = Session::get('success');
         @endphp
        @if ($success)
        <div class="=alert alert-success">{{ $success }}</div>
        @endif
    </form>

@endsection