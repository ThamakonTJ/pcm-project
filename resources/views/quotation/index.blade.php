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
    </head>

    <h1>Quotation</h1>
    <div class="mb-2">
        <a href="{{ route('quotation.create') }}" role="button" class="btn btn-sm btn-success">เพิ่มใบเสนอราคา</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div>
        <table id="tbContent" class="table table-bordered">
            <tr>
                <th>เลขที่เอกสารใบเสนอราคา</th>
                <th>ชื่อบริษัท</th>
                <th>ผู้รับ</th>
                <th>วันที่</th>
            </tr>
            @foreach ($quotations as $quotation)
                <tr>
                    <td>{{ $quotation->job_no }}</td>
                    <td>{{ $quotation->sup_name }}</td>
                    <td>{{ $quotation->recipient }}</td>
                    <td>{{ $quotation->date }}</td>
                    
                    
                    <td>
                        <form action="{{ route('quotation.destroy', $quotation->id) }}" method="POST">
                            <a href="{{ route('quotation.pimquo', $quotation->id) }}" class="btn btn-primary">ใบเสนอราคา</a>
                            <a href="{{ route('quotation.edit', $quotation->id) }}" class="btn btn-warning">แก้ไข</a>
                            @csrf
                            @method('DELETE')
                            <button  onclick="return confirm('ยืนยันการลบ')" type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $quotations->links('pagination::bootstrap-5') !!}
    </div>
@endsection
