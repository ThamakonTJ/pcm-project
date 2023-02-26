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
                <form action="{{ route($prefix.'.update' , $editpr->id) }}" method="post">
                    @csrf
                    <h1>แก้ไข Purchaing Requestion (ใบคำสั่งซื้อ)</h1>
                    @php
                        $success = Session::get('success');
                    @endphp
                    @if ($success)
                        <div class="=alert alert-success">{{ $success }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    <div class="mb-3 row">
                        <label for="department" class="col-sm-1 col-form-label" name="Doc_NO">Doc No :</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="Doc_NO" name="Doc_NO"
                                value="{{ $editpr->Doc_NO }}">
                        </div>

                        <label for="date" class="col-sm-1 col-form-label" name="date">วันที่</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $editpr->date }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-1 col-form-label">ชื่อ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="{{ $editpr->company_name }}">
                        </div>
                        <label for="date" class="col-sm-1 col-form-label">แผนก</label>
                        <div class="col">
                            <input type="text" class="form-control" id="department" name="department"
                                value="{{ $editpr->department }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="reason_to_buy" class="col-sm-3 col-form-label">เหตุผลในการขออนุมัติซื้อ</label>
                        <div class="col">
                            <input type="text" class="form-control" id="reason_to_buy" name="reason_to_buy"
                                value="{{ $editpr->reason_to_buy }}">
                        </div>
                    </div>
                    <table class="table table-bordered" id="dynamicAddRemove">

                        <tr>
                            <th>รายการ</th>
                            <th>จำนวนสินค้า</th>
                            <th>ราคา/หน่วย</th>
                            <th>ราคารวม</th>
                            <th>หมายเหตุ</th>
                            <th>ลบ</th>
                        </tr>

                        @php
                            $result = DB::table('prmultis')
                                ->where('Doc_NO', '=', $editpr->Doc_NO)
                                ->get();
                        @endphp

                        @foreach ($result as $key => $row)
                            <tr>
                                <input hidden type="text" name="id[{{ $loop->index }}]" id="id[]" name="product[]"
                                    value="<?php echo $row->id; ?>">
                                <td><input type="text" name="product[{{ $loop->index }}]" placeholder="Enter product"
                                        class="form-control" id="product[]" value="<?php echo $row->product; ?>"></td>
                                <td><input type="text" name="pcs[{{ $loop->index }}]" placeholder="Enter pcs"
                                        class="form-control" id="pcs[]" value="<?php echo $row->pcs; ?>"></td>
                                <td><input type="text" name="price_pcs[{{ $loop->index }}]"
                                        placeholder="Enter price for pcs" class="form-control" id="price_pcs[]"
                                        value="<?php echo $row->price_pcs; ?>">
                                </td>
                                <td><input type="text" name="total_price[{{ $loop->index }}]"
                                        placeholder="Enter total price" class="form-control" id="total_price[]"
                                        value="<?php echo $row->total_price; ?>"></td>
                                <td><input type="text" name="note[{{ $loop->index }}]" placeholder="Enter note"
                                        class="form-control" id="note[]" value="<?php echo $row->note; ?>"></td>
                                <form action="{{ route($prefix. '.detroy' , $editpr->id) }}" method="get">
                                    @csrf
                                    @if ($loop->index != 0)
                                        <td>
                                            <button type="submit" name="delete" value="<?php echo $row->id; ?>"
                                                class="btn btn-danger remove-tr">Remove</button>
                                        </td>
                                    @endif
                                </form>
                            </tr>
                        @endforeach


                    </table>
                    <td><button type="button" name="add" id="add-btn" class="btn btn-success">Add
                            More</button></td>

                    <button type="submit" class="btn btn-success">update</button>
                    @php
                        $success = Session::get('success');
                    @endphp
                    @if ($success)
                        <div class="=alert alert-success">{{ $success }}</div>
                    @endif

                </form>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        var i = 0;

        $("#add-btn").click(function() {
            $("#dynamicAddRemove").append('<tr><td>' +
                `<input hidden type="text" name="newId[${i}]" id="newId[]" value="${i}">` +
                '<input type="text" id="newProduct" name="newProduct[' + i +
                ']" placeholder="Enter product" class="form-control" /></td><td><input type="text" id="newPcs" name="newPcs[' +
                i +
                ']" placeholder="Enter pcs" class="form-control" /></td><td><input type="text" id=newPrice_pcs name="newPrice_pcs[' +
                i +
                ']" placeholder="Enter price for pcs" class="form-control" /></td></td><td><input type="text" id=newTotal_price name="newTotal_price[' +
                i +
                ']" placeholder="Enter total price" class="form-control" /></td><td><input type="text" id="newNote" name="newNote[' +
                i +
                ']" placeholder="Enter note" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr1">Remove</button></td></tr>'
            );
            ++i;

        });     
        $(document).on('click', '.remove-tr1', function() {
        $(this).parents('tr').remove();
        });
    </script>
@endsection
