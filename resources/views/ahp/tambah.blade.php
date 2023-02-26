<?php

// mendapatkan data edit

if (isset($_POST['tambah'])) {
    if ($_POST['type'] == 'alternative') {
        $result = DB::table('alternative')
            ->select('type', 'nama')
            ->orderBy('type')
            ->get();
    }
} else {
    $result = DB::table('criteria')
        ->select('type', 'nama')
        ->orderBy('type')
        ->get();
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

if (isset($_POST['tambah'])) {
    $type = $_POST['type'];
    $nama = $_POST['nama'];

    if ($_POST['type'] == 'criteria') {
        $result = DB::table('criteria')->insert(['type' => $type, 'nama' => $nama]);
    } else {
        $result = DB::table('alternative')->insert(['type' => $type, 'nama' => $nama]);
    }

    header("location: /user/$type");
    exit(0);
}

?>
@extends('ahp.header');

@section('content')
    <h2>เพิ่ม</h2>
    <form class="ui form" method="post" action="{{ route('ahp.tambah') }}">
        @csrf
        <div class="inline field">
            <label></label>
            <input type="text" name="nama" placeholder=" ">
            <input type="hidden" name="type" value="<?php echo $type; ?>">
        </div>
        <br>
        <input class="ui green button" type="submit" name="tambah" value="ยืนยัน">
    </form>
@endsection

<?php @include 'footer.blade.php'; ?>
