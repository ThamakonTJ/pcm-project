<?php
// mencari ID criteria
// berdasarkan urutan ke berapa (C1, C2, C3)
function getcriteriaID($no_urut)
{
    
@include('ahp/config');
    $query = "SELECT id FROM criteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $listID[] = $row['id'];
    }

    return $listID[($no_urut)];
}

// mencari ID alternative
// berdasarkan urutan ke berapa (A1, A2, A3)
function getalternativeID($no_urut)
{
    @
@include('ahp/config');
    $query = "SELECT id FROM alternative ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $listID[] = $row['id'];
    }

    return $listID[($no_urut)];
}

// mencari nama criteria
function getcriteriaNama($no_urut)
{
    @
@include('ahp/config');
    $query = "SELECT nama FROM criteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $nama[] = $row['nama'];
    }

    return $nama[($no_urut)];
}

// mencari nama alternative
function getalternativeNama($no_urut)
{
    @
@include('ahp/config');
    $query = "SELECT nama FROM alternative ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $nama[] = $row['nama'];
    }

    return $nama[($no_urut)];
}

// mencari priority vector alternative
function getalternativePV($id_alternative, $id_criteria)
{
    @
@include('ahp/config');
    $query = "SELECT nilai FROM pv_alternative WHERE id_alternative=$id_alternative AND id_criteria=$id_criteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $pv = $row['nilai'];
    }

    return $pv;
}

// mencari priority vector criteria
function getcriteriaPV($id_criteria)
{
    @
@include('ahp/config');
    $query = "SELECT nilai FROM pv_criteria WHERE id_criteria=$id_criteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $pv = $row['nilai'];
    }

    return $pv;
}

// mencari jumlah alternative
function getJumlahalternative()
{
    @
@include('ahp/config');
    $query = "SELECT count(*) FROM alternative";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $jmlData = $row[0];
    }

    return $jmlData;
}

// mencari jumlah criteria
function getJumlahcriteria()
{
    @
@include('ahp/config');
    $query = "SELECT count(*) FROM criteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $jmlData = $row[0];
    }

    return $jmlData;
}

// menambah data criteria / alternative
function addData($tabel, $nama)
{
    @
@include('ahp/config');

    $query = "INSERT INTO $tabel (nama) VALUES ('$nama')";
    $tambah = mysqli_query($koneksi, $query);

    if (!$tambah) {
        echo "Gagal mmenambah data" . $tabel;
        exit();
    }
}

// hapus criteria
function deletecriteria($id)
{
    @
@include('ahp/config');

    // hapus record dari tabel criteria
    $query = "DELETE FROM criteria WHERE id=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel pv_criteria
    $query = "DELETE FROM pv_criteria WHERE id_criteria=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel pv_alternative
    $query = "DELETE FROM pv_alternative WHERE id_criteria=$id";
    mysqli_query($koneksi, $query);

    $query = "DELETE FROM perbandingan_criteria WHERE criteria1=$id OR criteria2=$id";
    mysqli_query($koneksi, $query);

    $query = "DELETE FROM perbandingan_alternative WHERE pembanding=$id";
    mysqli_query($koneksi, $query);
}

// hapus alternative
function deletealternative($id)
{
    @
@include('ahp/config');

    // hapus record dari tabel alternative
    $query = "DELETE FROM alternative WHERE id=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel pv_alternative
    $query = "DELETE FROM pv_alternative WHERE id_alternative=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel ranking
    $query = "DELETE FROM ranking WHERE id_alternative=$id";
    mysqli_query($koneksi, $query);

    $query = "DELETE FROM perbandingan_alternative WHERE alternative1=$id OR alternative2=$id";
    mysqli_query($koneksi, $query);
}

// memasukkan nilai priority vektor criteria
function inputcriteriaPV($id_criteria, $pv)
{
    @
@include('ahp/config');

    $query = "SELECT * FROM pv_criteria WHERE id_criteria=$id_criteria";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO pv_criteria (id_criteria, nilai) VALUES ($id_criteria, $pv)";
    } else {
        $query = "UPDATE pv_criteria SET nilai=$pv WHERE id_criteria=$id_criteria";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "";
        exit();
    }

}

// memasukkan nilai priority vektor alternative
function inputalternativePV($id_alternative, $id_criteria, $pv)
{
    @
@include('ahp/config');

    $query = "SELECT * FROM pv_alternative WHERE id_alternative = $id_alternative AND id_criteria = $id_criteria";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO pv_alternative (id_alternative,id_criteria,nilai) VALUES ($id_alternative,$id_criteria,$pv)";
    } else {
        $query = "UPDATE pv_alternative SET nilai=$pv WHERE id_alternative=$id_alternative AND id_criteria=$id_criteria";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "";
        exit();
    }

}

// memasukkan bobot nilai perbandingan criteria
function inputDataPerbandingancriteria($criteria1, $criteria2, $nilai)
{
    @
@include('ahp/config');

    $id_criteria1 = getcriteriaID($criteria1);
    $id_criteria2 = getcriteriaID($criteria2);

    $query = "SELECT * FROM perbandingan_criteria WHERE criteria1 = $id_criteria1 AND criteria2 = $id_criteria2";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO perbandingan_criteria (criteria1,criteria2,nilai) VALUES ($id_criteria1,$id_criteria2,$nilai)";
    } else {
        $query = "UPDATE perbandingan_criteria SET nilai=$nilai WHERE criteria1=$id_criteria1 AND criteria2=$id_criteria2";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "";
        exit();
    }

}

// memasukkan bobot nilai perbandingan alternative
function inputDataPerbandinganalternative($alternative1, $alternative2, $pembanding, $nilai)
{
    @
@include('ahp/config');

    $id_alternative1 = getalternativeID($alternative1);
    $id_alternative2 = getalternativeID($alternative2);
    $id_pembanding = getcriteriaID($pembanding);

    $query = "SELECT * FROM perbandingan_alternative WHERE alternative1 = $id_alternative1 AND alternative2 = $id_alternative2 AND pembanding = $id_pembanding";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO perbandingan_alternative (alternative1,alternative2,pembanding,nilai) VALUES ($id_alternative1,$id_alternative2,$id_pembanding,$nilai)";
    } else {
        $query = "UPDATE perbandingan_alternative SET nilai=$nilai WHERE alternative1=$id_alternative1 AND alternative2=$id_alternative2 AND pembanding=$id_pembanding";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "";
        exit();
    }

}

// mencari nilai bobot perbandingan criteria
function getNilaiPerbandingancriteria($criteria1, $criteria2)
{
    @
@include('ahp/config');

    $id_criteria1 = getcriteriaID($criteria1);
    $id_criteria2 = getcriteriaID($criteria2);

    $query = "SELECT nilai FROM perbandingan_criteria WHERE criteria1 = $id_criteria1 AND criteria2 = $id_criteria2";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    if (mysqli_num_rows($result) == 0) {
        $nilai = 1;
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $nilai = $row['nilai'];
        }
    }

    return $nilai;
}

// mencari nilai bobot perbandingan alternative
function getNilaiPerbandinganalternative($alternative1, $alternative2, $pembanding)
{
    @
@include('ahp/config');

    $id_alternative1 = getalternativeID($alternative1);
    $id_alternative2 = getalternativeID($alternative2);
    $id_pembanding = getcriteriaID($pembanding);

    $query = "SELECT nilai FROM perbandingan_alternative WHERE alternative1 = $id_alternative1 AND alternative2 = $id_alternative2 AND pembanding = $id_pembanding";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }
    if (mysqli_num_rows($result) == 0) {
        $nilai = 1;
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $nilai = $row['nilai'];
        }
    }

    return $nilai;
}

// menampilkan nilai IR
function getNilaiIR($jmlcriteria)
{
    @
@include('ahp/config');
    $query = "SELECT nilai FROM ir WHERE jumlah=$jmlcriteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $nilaiIR = $row['nilai'];
    }

    return $nilaiIR;
}

// mencari Principe Eigen Vector (λ maks)
function getEigenVector($matrik_a, $matrik_b, $n)
{
    $eigenvektor = 0;
    for ($i = 0; $i <= ($n - 1); $i++) {
        $eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
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
    $consindex = getConsIndex($matrik_a, $matrik_b, $n);
    $consratio = $consindex / getNilaiIR($n);

    return $consratio;
}

// menampilkan tabel perbandingan bobot
function showTabelPerbandingan($jenis, $criteria)
{

@include('ahp/config');

    if ($criteria == 'criteria') {
        $n = getJumlahcriteria();
    } else {
        $n = getJumlahalternative();
    }

    $query = "SELECT nama FROM $criteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Error database!!!";
        exit();
    }

    // buat list nama pilihan
    while ($row = mysqli_fetch_array($result)) {
        $pilihan[] = $row['nama'];
    }

    // tampilkan tabel
    ?>

<form class="ui form" action="proses.php" method="post">
    <table class="ui celled selectable collapsing table">
        <thead>
            <tr>
                <th colspan="2">เลือกอันที่สำคัญกว่า</th>
                <th>ค่าเปรียบเทียบ</th>
            </tr>
        </thead>
        <tbody>

            <?php

    //inisialisasi
    $urut = 0;

    for ($x = 0; $x <= ($n - 2); $x++) {
        for ($y = ($x + 1); $y <= ($n - 1); $y++) {

            $urut++;

            ?>
            <tr>
                <td>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input name="pilih<?php echo $urut; ?>" value="1" checked="" class="hidden"
                                type="radio">
                            <label><?php echo $pilihan[$x]; ?></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input name="pilih<?php echo $urut; ?>" value="2" class="hidden" type="radio">
                            <label><?php echo $pilihan[$y]; ?></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="field">

                        <?php
                        if ($criteria == 'criteria') {
                            $nilai = getNilaiPerbandingancriteria($x, $y);
                        } else {
                            $nilai = getNilaiPerbandinganalternative($x, $y, $jenis - 1);
                        }
                        
                        ?>
                        <input type="text" name="bobot<?php echo $urut; ?>" value="<?php echo $nilai; ?>" required>
                    </div>
                </td>
            </tr>
            <?php
}
    }

    ?>
        </tbody>
    </table>
    <input type="text" name="jenis" value="<?php echo $jenis; ?>" hidden>
    <br><br><input class="ui submit button" type="submit" name="submit" value="ยืนยัน">
</form>

<?php
}
?>
