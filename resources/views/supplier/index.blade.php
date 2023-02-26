@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))

@section('title', 'Supplier')

@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <h1>Supplier</h1>
    <div class="mb-2">
        <a href="{{ route('supplier.create') }}" role="button" class="btn btn-sm btn-success">Add Supplier</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div>
        <table id="tbContent" class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>รหัสบริษัท</th>
                <th>ชื่อบริษัท</th>
                <th>ที่อยู่</th>
                <th>ประเภทสินค้า</th>
                <th>เบอร์โทรศัทพ์</th>
                <th>เบอร์Fax</th>
                <th>ปีที่ก่อตั้ง</th>
                <th>ทุนจดทะเบียน</th>
                <th>ชื่อผู้ติดต่อ</th>
                <th>Email</th>
                <th style="width: 200px"></th>

            </tr>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->sup_id }}</td>
                    <td>{{ $supplier->sup_name }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->product_type }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->fax }}</td>
                    <td>{{ $supplier->since }}</td>
                    <td>{{ $supplier->registered_capital }}</td>
                    <td>{{ $supplier->contact_name }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>
                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST">
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-warning">แก้ไข</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $suppliers->links('pagination::bootstrap-5') !!}
    </div>
@endsection
