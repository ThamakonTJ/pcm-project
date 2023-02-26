@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))

@section('title', 'Product')
@section('content')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <h1>Product</h1>
    <div class="mb-2">
        <a href="{{ route('product.create') }}" role="button" class="btn btn-sm btn-success">Add Product</a>
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
                <th>ชื่อ</th>
                <th>รุ่น</th>
                <th>จำนวน</th>
                <th>รูปสินค้า</th>
                <th style="width: 200px"></th>

            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->model_id }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <img src="{{asset($product->product_image) }}" alt="" width="100px" height="100px">
                    </td>

                    <td>
                        <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning">แก้ไข</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $products->links('pagination::bootstrap-5') !!}
    </div>
@endsection
