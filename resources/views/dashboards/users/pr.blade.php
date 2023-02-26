@php
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
   $prefix = Str::replace('/', '', Request::route()->getPrefix());
@endphp 
@extends(((Auth()->user()->role == 2) ? 'dashboards.admins.layouts.admin-dash-layout' : 'dashboards.users.layouts.user-dash-layout'))

@section('title', 'Purchaing Requestion')

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')


    <form>

    </form>
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route($prefix. '.submit') }}" method="post">
                    @csrf
                    <h1>Purchaing Requestion (ใบขอซื้อ)</h1>
                    
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    <div class="mb-3 row">
                        <label for="department" class="col-sm-1 col-form-label" name="Doc_NO">Doc No :</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="PO_NO" name="Doc_NO">
                        </div>

                        <label for="date" class="col-sm-1 col-form-label" name="date">วันที่</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-1 col-form-label">ชื่อ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="company_name" name="company_name">
                        </div>
                        <label for="date" class="col-sm-1 col-form-label">แผนก</label>
                        <div class="col">
                            <input type="text" class="form-control" id="department" name="department">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="reason_to_buy" class="col-sm-3 col-form-label">เหตุผลในการขออนุมัติซื้อ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="reason_to_buy" name="reason_to_buy">
                        </div>
                    </div>
                    <table class="table table-bordered" id="dynamicAddRemove">

                        <tr>
                            <th>รายการ</th>
                            <th>จำนวนสินค้า</th>
                            <th>ราคา/หน่วย</th>
                            <th>ราคารวม</th>
                            <th>หมายเหตุ</th>
                        </tr>
                        <tr>
                            <td><input type="text" placeholder="Enter product" class="form-control"
                                    id="product[]" name="product[]" value="{{ old('product') }}"></td>
                            <td><input type="text"  placeholder="Enter pcs" class="form-control"
                                    id="pcs[]" name="pcs[]" value="{{ old('pcs') }}"></td>
                            <td><input type="text"  placeholder="Enter price for pcs"
                                    class="form-control" id="price_pcs[]" name="price_pcs[]" value="{{ old('price_pcs') }}">
                            </td>
                            <td><input type="text"  placeholder="Enter total price"
                                    class="form-control" id="total_price[]" name="total_price[]"
                                    value="{{ old('total_price') }}"></td>
                            <td><input type="text"  placeholder="Enter note" class="form-control"
                                    id="note[]" name="note[]" value="{{ old('note') }}"></td>

                            <td><button type="button" name="add" id="add-btn" class="btn btn-success">Add
                                    More</button></td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-success">Save</button>
                    @php
                        $success = Session::get('success');
                    @endphp
                    @if ($success)
                        <div class="=alert alert-success">{{ $success }}</div>
                    @endif

                </form>

                <h1></h1>
                <table id="tbContent" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 150px;">Doc NO</th>
                            <th style="width: 150px;">วันที่</th>
                            <th style="width: 550px;">ใบคำสั่งซื้อ</th>
                        </tr>
                    </thead>
                    @foreach ($pr as $Pr)
                        <tr>
                            <td>{{ $Pr->Doc_NO }}</td>
                            <td>{{ $Pr->date }}</td>
                            <td>{{ $Pr->reason_to_buy }}</td>
                            <td>

                                <form action="{{ route($prefix.'.delete', $Pr->id) }}" method="POST">
                                    <a type="button" name="view" id="view" class="btn btn-info"
                                        target="blank" href="{{ url($prefix.'/pimpr/' . $Pr->Doc_NO) }}" role="button">View</a>
                                    <a href="{{ route($prefix.'.editpr', $Pr->id) }}" class="btn btn-warning">แก้ไข</a>
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('ยืนยันการลบ')" class="btn btn-danger">ลบ</button>

                                </form>



                            </td>
                        </tr>
                    @endforeach


            </div>
        </div>
    </div>
    <script type="text/javascript">
        var i = 0;
        $("#add-btn").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><input type="text" name="product[' + i +
                ']" placeholder="Enter product" class="form-control" /></td><td><input type="text" name="pcs[' +
                i +
                ']" placeholder="Enter pcs" class="form-control" /></td><td><input type="text" name="price_pcs[' +
                i +
                ']" placeholder="Enter price for pcs" class="form-control" /></td></td><td><input type="text" name="total_price[' +
                i +
                ']" placeholder="Enter total price" class="form-control" /></td><td><input type="text" name="note[' +
                i +
                ']" placeholder="Enter note" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>

@endsection
