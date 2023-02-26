@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
   $prefix = Str::replace('/', '', Request::route()->getPrefix());
@endphp 
@extends('dashboards.saffs.layouts.saff-dash-layout')
@section('title','Purchase Order')
@section('content')
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<h1>Purchaing order(ใบสั่งซื้อ)</h1>
<div class="mb-2">
    
</div>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
<div>
    <table id="tbContent" class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 150px;">Doc NO</th>
                <th style="width: 150px;">วันที่</th>
                <th style="width: 150px;">บริษัท</th>
                <th style="width: 350px;">ใบคำสั่งซื้อ</th>
            </tr>
        </thead>
        @foreach ($po as $po_details)
            <tr>
                <td>{{ $po_details->PO_NO }}</td>
                <td>{{ $po_details->date }}</td>
                <td>{{ $po_details->company_name }}</td>
                <td>{{ $po_details->reason_to_buy }}</td>
                <td>
                    <form action="{{route($prefix.'.delete2', $po_details->id)}}" method="POST">
                       <a type="button" name="view" id="view" class="btn btn-info"
                                    target="blank"  href="{{ url($prefix.'/pimpo/' . $po_details->PO_NO) }}" role="button">View</a>
                        @csrf

                    </form>
                </td>
            </tr>
        @endforeach
</div>


@endsection
