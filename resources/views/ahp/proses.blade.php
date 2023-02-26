<?php
if (isset($_POST['submit'])) {
    $type = $_POST['type'];

    if ($type == 'criteria') {
        $n = DB::table('criteria')
            ->select('id', 'nama')
            ->orderBy('id')
            ->get();
    } else {
        $n = DB::table('alternative')
            ->select('id', 'nama')
            ->orderBy('id')
            ->get();
    }

    // memetakan nilai ke dalam bentuk matrik
    // x = baris
    // y = kolom
    $matric = [];

    function getCriteriaID($index)
    {
        $criteriaId = DB::table('criteria')
            ->select('id')
            ->orderBy('id')
            ->where('id', '=', $index)
            ->get();

        return $criteriaId;
    }

    for ($i = 0; $i < count($n) - 1; $i++) {
        for ($j = 1 + $i; $j < count($n); $j++) {
            $checkbox = "{$n[$i]->nama}{$n[$j]->nama}";
            $result = "result{$i}{$j}";
            if ($_POST[$checkbox] == 1) {
                $matric[$i][$j] = $_POST[$result];
                $matric[$j][$i] = 1 / $_POST[$result];
            } else {
                $matric[$i][$j] = 1 / $_POST[$result];
                $matric[$j][$i] = $_POST[$result];
            }

            if ($type == 'criteria') {
                $id1 = $_POST["{$n[$i]->nama}{$n[$j]->nama}id1"];
                $id2 = $_POST["{$n[$i]->nama}{$n[$j]->nama}id2"];
                $_result = DB::table('perbandingan_kriteria')
                    ->select('id')
                    ->where('kriteria1', '=', $id1)
                    ->where('kriteria2', '=', $id2)
                    ->get();

                if ($_result->isEmpty()) {
                    DB::table('perbandingan_kriteria')->insert([
                        'kriteria1' => $id1,
                        'kriteria2' => $id2,
                        'nilai' => $matric[$i][$j],
                    ]);
                } else {
                    DB::table('perbandingan_kriteria')
                        ->where('kriteria1', '=', $id1)
                        ->where('kriteria2', '=', $id2)
                        ->update(['nilai' => $matric[$i][$j]]);
                }
            } else {
                // inputDataPerbandinganAlternatif($x, $y, $jenis - 1, $matric[$x][$y]);
            }
        }
    }

    for ($i = 0; $i < count($n) - 1; $i++) {
        $matric[$i][$i] = 1;
    }

    // inisialisasi jumlah tiap kolom dan baris kriteria
    $jmlmpb = [];
    $jmlmnk = [];
    for ($i = 0; $i < count($n) - 1; $i++) {
        $jmlmpb[$i] = 0;
        $jmlmnk[$i] = 0;
    }

    // menghitung jumlah pada kolom kriteria tabel perbandingan berpasangan
    for ($i = 0; $i < count($n) - 1; $i++) {
        for ($j = 0; $j < count($n) - 1; $j++) {
            $value = $matric[$i][$j];
            $jmlmpb[$j] += $value;
        }
    }

    // menghitung jumlah pada baris kriteria tabel nilai kriteria
    // matrikb merupakan matrik yang telah dinormalisasi
    for ($x = 0; $x < count($n) - 1; $x++) {
        for ($y = 0; $y < count($n) - 1; $y++) {
            $matrikb[$x][$y] = $matric[$x][$y] / $jmlmpb[$y];
            $value = $matrikb[$x][$y];
            $jmlmnk[$x] += $value;
        }

        // nilai priority vektor
        // echo $jmlmnk[$x];
        $pv[$x] = $jmlmnk[$x] / count($n);

        // memasukkan nilai priority vektor ke dalam tabel pv_kriteria dan pv_alternatif
        if ($type == 'criteria') {
            $collection = DB::table('criteria')
                ->select('id', 'nama')
                ->orderBy('id')
                ->get();
            $id_kriteria = $collection->values()->get($x)->id;

            echo $id_kriteria;

            $_result = DB::table('pv_kriteria')
                ->select()
                ->where('id_kriteria', '=', $id_kriteria)
                ->get();

            if ($_result->isEmpty()) {
                DB::table('pv_kriteria')->insert([
                    'id_kriteria' => $id_kriteria,
                    'nilai' => $pv[$x],
                ]);
            } else {
                DB::table('pv_kriteria')
                    ->where('id_kriteria', '=', $id_kriteria)
                    ->update(['nilai' => $pv[$x]]);
            }
        } else {
            // $id_kriteria = getKriteriaID($jenis - 1);
            // $id_alternatif = getAlternatifID($x);
            // inputAlternatifPV($id_alternatif, $id_kriteria, $pv[$x]);
        }
    }

    function getEigenVector($matrik_a, $matrik_b, $n)
    {
        $eigenvektor = 0;
        for ($i = 0; $i <= $n - 1; $i++) {
            $eigenvektor += $matrik_a[$i] * ($matrik_b[$i] / $n);
        }

        return $eigenvektor;
    }

    // mencari Cons Index
    function getConsIndex($matrik_a, $matrik_b, $n)
    {
        $eigenvektor = getEigenVector($matrik_a, $matrik_b, $n);
        $consindex = ($eigenvektor - $n) / ($n - 1);

        return $consindex;
    }

    // Mencari Consistency Ratio
    function getConsRatio($matrik_a, $matrik_b, $n)
    {
        $conllection = DB::table('ir')
                ->select('nilai')
                ->where('jumlah', '=', $n)
                ->get();

        $nilai =  $conllection->values()->get(0)->nilai;
        $consindex = getConsIndex($matrik_a, $matrik_b, $n);
        $consratio = $consindex / $nilai;

        return $consratio;
    }

    //     // cek konsistensi
    $eigenvektor = getEigenVector($jmlmpb, $jmlmnk, count($n)-1);
    $consIndex = getConsIndex($jmlmpb, $jmlmnk, count($n)-1);
    $consRatio = getConsRatio($jmlmpb, $jmlmnk, count($n)-1);

        if ($type == 'criteria') {
            // include 'output.php';
        } else {
            // include 'bobot_hasil.php';
        }
}

?>
<div>test</div>
<?php /**PATH C:\xampp\htdocs\pcm_project\resources\views/ahp/proses.blade.php ENDPATH**/?>
