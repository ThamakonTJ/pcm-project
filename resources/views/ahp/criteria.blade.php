<?php
@include 'ahp/config';
@include 'ahp/fungsi';

$result = DB::table('criteria')
                ->select('id', 'nama','type')
                ->orderBy('id')
                ->get();

if(isset($_POST['edit'])) {
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	///header('Location: edit.php?jenis=criteria&id='.$id);
    header("location: /user/edit?type=criteria&id=$id&nama=$nama");
	exit(0);
}

// menjalankan perintah delete
if(isset($_POST['delete'])) {
	$id = $_POST['id'];
    $result = DB::table('criteria')
			->where('id', $id)  // find your user by their email
			->limit(1)  // optional - to ensure only one record is updated.
			->delete(array('id' => $id));  // update the record in the DB. 

   		header("location: /user/criteria");
		exit(0);

}

// menjalankan perintah tambah
if(isset($_POST['tambah'])) {
	$nama = $_POST['nama'];
	addData('criteria',$nama);
}
?>

@extends('ahp.header')
@section('content')
    <h2 class="ui header">เกณฑ์การตัดสินใจ</h2>
    <table class="ui celled table">
        <thead>
            <tr>
                <th class="collapsing">ลำดับ</th>
                <th colspan="2">ชื่อ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result as $key => $row)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{$row->nama }}</td>
                    <td class="right aligned collapsing">
                        <form method="post" action="{{ route('ahp.criteria') }}">
                            @csrf
                            <input type="hidden" name="nama" value="<?php echo $row->nama ?>">
                            <input type="hidden" name="id" value="<?php echo $row->id ?>">
                            <button type="submit" name="edit" class="ui mini teal left labeled icon button"><i
                                    class="right edit icon"></i>แก้ไข</button>
                            <button type="submit" name="delete" class="ui mini red left labeled icon button"><i
                                    class="right remove icon"></i>ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot class="full-width">
            <tr>
                <th colspan="3">
                    <a href= "{{route('ahp.tambah', ['type' => 'criteria'])}}" >
                        <div class="ui right floated small primary labeled icon button">
                            <i class="plus icon"></i>เพิ่ม
                        </div>
                    </a>
                </th>
            </tr>
        </tfoot>
    </table>

    <br>



    <form action="{{route('ahp.alternative')}}">
        <button class="ui right labeled icon button" style="float: right;">
            <i class="right arrow icon"></i>
            ต่อไป
        </button>
    </form>
@endsection

@extends('ahp.footer')
