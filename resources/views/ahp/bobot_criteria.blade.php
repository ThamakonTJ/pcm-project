<?php
if (isset($_GET['type'])) {
    if ($_GET['type'] == 'criteria') {
        $criteria = DB::table('criteria')
            ->select('id', 'nama')
            ->orderBy('id')
            ->get();
    }

    $type = $_GET['type'];
    $result = $criteria->toArray();
}
/*
	if () {
		
            $result = DB::table('criteria')
                ->select('id', 'nama','type')
                ->orderBy('id')
                ->get();
	}
    if ($criteria == 'criteria') {
       $n = getJumlahcriteria();
    } else {
        $n = getJumlahalternative();
    }
    
    $query = "SELECT nama FROM $criteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo 'Error database!!!';
        exit();
    }
    
    // buat list nama pilihan
    while ($row = mysqli_fetch_array($result)) {
        $pilihan[] = $row['nama'];
    }
    
    // tampilkan tabel
    */
?>

@extends('ahp.header')
@section('content')
    <h2 class="ui header">เปรียบเทียบเกณฑ์</h2>

    <form class="ui form" action="{{ route('ahp.proses') }}" method="post">
        @csrf
        <table class="ui celled selectable collapsing table">
            <thead>
                <tr>
                    <th colspan="2">เลือกอันที่สำคัญกว่า</th>
                    <th>ค่าเปรียบเทียบ</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($result) - 1; $i++)
                    @for ($j = 1 + $i; $j < count($result); $j++)
                        <tr>
                            <td>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="hidden" name="<?php echo "{$result[$i]->nama}{$result[$j]->nama}id1"; ?>" value="<?php echo $result[$i]->id; ?>">
                                        <input type="radio" id="<?php echo "checkbox{$i}{$j}"; ?>" name="<?php echo "{$result[$i]->nama}{$result[$j]->nama}"; ?>"
                                            value="1" checked="">
                                        <label><?php echo $result[$i]->nama; ?></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="hidden" name="<?php echo "{$result[$i]->nama}{$result[$j]->nama}id2"; ?>" value="<?php echo $result[$j]->id; ?>">
                                        <input type="radio" id="<?php echo "checkbox{$i}{$j}"; ?>" name="<?php echo "{$result[$i]->nama}{$result[$j]->nama}"; ?>"
                                            value="2">
                                        <label><?php echo $result[$j]->nama; ?></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $nilaiResult = DB::table('perbandingan_kriteria')
                                        ->select('nilai')
                                        ->where('kriteria1', '=', $result[$i]->id)
                                        ->where('kriteria2', '=', $result[$j]->id)
                                        ->get();
                                    
                                    if ($nilaiResult->isEmpty()) {
                                        $nilai = 1;
                                    } else {
                                        $nilai = $nilaiResult->first()->nilai;
                                    }
                                @endphp
                                <div class="field">
                                    <input type="text" name="<?php echo "result{$i}{$j}"; ?>" value="<?php echo $nilai; ?>" required>
                                </div>
                            </td>
                        </tr>
                    @endfor
                @endfor
            </tbody>
        </table>
        <input type="text" name="type" value="<?php echo $type; ?>" hidden>
        <br><br><input class="ui submit button" type="submit" name="submit" value="ยืนยัน">
    </form>

    <?php/* showTabelPerbandingan('criteria','criteria'); */?>
@endsection

@extends('ahp.footer')
