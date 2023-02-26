@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.saffs.layouts.saff-dash-layout'))

@section('title', 'Invoice')

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <h1>Invoice</h1>
    <div class="mb-2">
        <a href="{{ route('invoice.create') }}" role="button" class="btn btn-sm btn-success">เพิ่มใบเสร็จ</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div>
        <table id="tbContent" class="table table-bordered">
            <tr>
                <th>เลขที่เอกสารใบสั่งซื้อ</th>
                <th>เลขที่เอกสารใบส่งของ</th>
                <th>ชื่อบริษัท</th>
                <th>ผู้รับ</th>
                <th>ราคารวม</th>
               
            </tr>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->PO_NO }}</td>
                    <td>{{ $invoice->In_No }}</td>
                    <td>{{ $invoice->sup_name }}</td>
                    <td>{{ $invoice->recipient }}</td>
                    <td>{{ number_format($invoice->price)}}</td>
                    
                    <td>

                        <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST">
                            <a href="{{ route('invoice.piminvoice', $invoice->id) }}" class="btn btn-primary">ใบเสร็จ</a>
                            <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-warning">แก้ไข</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $invoices->links('pagination::bootstrap-5') !!}
    </div>
@endsection
