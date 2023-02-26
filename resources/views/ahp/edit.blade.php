<?php
@include 'ahp/config';
@include 'ahp/fungsi';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    $nama = $_GET['nama'];
    // // hapus record
    // $query 	= "SELECT nama FROM $type WHERE id=$id";
    // $result	= mysqli_query($koneksi, $query);

    // while ($row = mysqli_fetch_array($result)) {
    // 	$nama = $row['nama'];
    // }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $type = $_POST['type'];

    if ($_POST['type'] === 'criteria') {
        $result = DB::table('criteria')
            ->where('id', $id) // find your user by their email
            ->limit(1) // optional - to ensure only one record is updated.
            ->update(['nama' => $nama]); // update the record in the DB.
        header('location: /user/criteria');
        exit(0);
    } else {

        $result = DB::table('alternative')
            ->where('id', $id) // find your user by their email
            ->limit(1) // optional - to ensure only one record is updated.
            ->update(['nama' => $nama]); // update the record in the DB.
        header('location: /user/alternative');
        exit(0);
	}
}

?>

@extends('ahp.header')
@section('content')
    <h2>แก้ไข</h2>

    <form class="ui form" method="post" action="{{ route('ahp.edit') }}">
        @csrf
        <div class="inline field">
            <label></label>
            <input type="text" name="nama" value="<?php echo $nama; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="type" value="<?php echo $type; ?>">
        </div>
        <br>
        <input class="ui green button" type="submit" name="update" value="อัปเดต">
    </form>
@endsection
@extends('ahp.footer')
