
<?php
include 'config.php';
include 'fungsi.php';

// menjalankan perintah edit
if (isset($_POST['edit'])) {
    $id = $_POST['id'];

    header('Location: /ahp/edit.php?jenis=alternatif&id=' . $id);
    exit();
}

// menjalankan perintah delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteAlternatif($id);
}

// menjalankan perintah tambah
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    tambahData('alternatif', $nama);
}

if (isset($_POST['product_type'])) {
    $product_type = $_POST['product_type'];
}

if (isset($_POST['result'])) {
    $ids = explode(",", $_POST['ids']);
	$querySelected = "SELECT * FROM alternatif ORDER BY id";
	$resultSelected = mysqli_query($koneksi, $querySelected);

	$selected = array();
	while ($row = mysqli_fetch_array($resultSelected)) {
		if (in_array($row['id'], $ids)) {
			array_push($selected, $row);
		}
	}

	// delete
	$qDelete = "DELETE FROM sup_select";
	$rDelete = mysqli_query($koneksi, $qDelete);

	foreach ($selected as $row) {
		$columns = implode(", ",array_keys($row));
		// echo $columns;
		$values  = implode(", ", array_values($row));
		// echo $values;

		$id = $row['id'];
		$nama = $row['nama'];
		$product_type = $row['product_type'];
		$qInsert = "INSERT INTO sup_select(id, nama, product_type) VALUES ('$id', '$nama', '$product_type')";
		$rInsert = mysqli_query($koneksi, $qInsert);

		echo $qInsert;
		if (!$rInsert) {
			echo "Gagal mmenambah data";
		}

		header('Location: /ahp/bobot_kriteria.php');
	}
}

include 'header.php';

?>


<section class="content">

	<h2 class="ui header">ซัพพลายเออร์ทางเลือก</h2>

	<form name='myform' action='alternatif.php' method='post'>
		<select name="product_type" onchange="this.form.submit()" class="ui dropdown">
			<?php
// Menampilkan list alternatif
$queryType = "SELECT product_type FROM alternatif GROUP BY product_type";
$resultType = mysqli_query($koneksi, $queryType);

$i = 0;
while ($row = mysqli_fetch_array($resultType)) {
    if ($i == 0 && !isset($_POST['product_type'])) {
        $product_type = $row['product_type'];
    }
    $i++;
    ?>
				<option
					value="<?php echo $row['product_type'] ?>"
					<?php
					if ($product_type == $row['product_type']) {
        ?>
								selected="selected"
							<?php
}
    ?>
				>
					<?php echo $row['product_type'] ?>
				</option>
			<?php
}
?>
		</select>
	</form>
	<script>
		var selectedList = []
		function updateColor(element, id) {
			var isSelect = element.className === "ui mini gray left labeled icon button";
			selectedList = selectedList.filter(x => x !== id)
			if (isSelect) {
				element.className = "ui mini green left labeled icon button";
				selectedList = [...selectedList, id]
			} else {
				element.className = "ui mini gray left labeled icon button";
			}
			document.getElementById("ids").value = selectedList.join(',')
		}
	</script>
	<table class="ui celled table">
		<thead>
			<tr>
				<th class="collapsing">ลำดับ</th>
				<th colspan="2">ชื่อ</th>
			</tr>
		</thead>
		<tbody>
		<form method="post" action="alternatif.php">
		<input type="hidden" name="ids" id="ids" value="">
		<?php
// Menampilkan list alternatif
$query = "SELECT id,nama,product_type FROM alternatif WHERE product_type = '$product_type'";
$result = mysqli_query($koneksi, $query);

$i = 0;
while ($row = mysqli_fetch_array($result)) {
    $i++;
    ?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $row['nama'] ?></td>
				<td class="right aligned collapsing">
				<button type="button" onclick="updateColor(this, '<?php echo $row['id'] ?>')" name="select" class="ui mini gray left labeled icon button"><i class="right check icon"></i>Select</button>
				</td>
			</tr>
		<?php
}
?>

		</tbody>

	</table>

	<br>


		<button type="submit" name="result" class="ui right labeled icon button" style="float: right;">
			<i class="right arrow icon"></i>
			ต่อไป
		</button>
	</form>
</section>

<?php include 'footer.php';?>