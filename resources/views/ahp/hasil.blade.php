<?php

@include('config.blade.php');
@include('fungsi.blade.php');


// menghitung perangkingan
$jmlcriteria 	= getJumlahcriteria();
$jmlalternative	= getJumlahalternative();
$nilai			= array();

// mendapatkan nilai tiap alternative
for ($x=0; $x <= ($jmlalternative-1); $x++) {
	// inisialisasi
	$nilai[$x] = 0;

	for ($y=0; $y <= ($jmlcriteria-1); $y++) {
		$id_alternative 	= getalternativeID($x);
		$id_criteria	= getcriteriaID($y);

		$pv_alternative	= getalternativePV($id_alternative,$id_criteria);
		$pv_criteria	= getcriteriaPV($id_criteria);

		$nilai[$x]	 	+= ($pv_alternative * $pv_criteria);
	}
}

// update nilai ranking
for ($i=0; $i <= ($jmlalternative-1); $i++) { 
	$id_alternative = getalternativeID($i);
	$query = "INSERT INTO ranking VALUES ($id_alternative,$nilai[$i]) ON DUPLICATE KEY UPDATE nilai=$nilai[$i]";
	$result = mysqli_query($koneksi,$query);
	if (!$result) {
		echo "Gagal mengupdate ranking";
		exit();
	}
}

@include('header.blade.php');

?>

<section class="content">
	<h2 class="ui header">ผลการคำนวณ</h2>
	<table class="ui celled table">
		<thead>
		<tr>
			<th>เกณฑ์</th>
			<th>ค่าน้ำหนักของเกณฑ์</th>
			<?php
			for ($i=0; $i <= (getJumlahalternative()-1); $i++) { 
				echo "<th>".getalternativeNama($i)."</th>\n";
			}
			?>
		</tr>
		</thead>
		<tbody>

		<?php
			for ($x=0; $x <= (getJumlahcriteria()-1) ; $x++) { 
				echo "<tr>";
				echo "<td>".getcriteriaNama($x)."</td>";
				echo "<td>".round(getcriteriaPV(getcriteriaID($x)),5)."</td>";

				for ($y=0; $y <= (getJumlahalternative()-1); $y++) { 
					echo "<td>".round(getalternativePV(getalternativeID($y),getcriteriaID($x)),5)."</td>";
				}


				echo "</tr>";
			}
		?>
		</tbody>

		<tfoot>
		<tr>
			<th colspan="2">Total</th>
			<?php
			for ($i=0; $i <= ($jmlalternative-1); $i++) { 
				echo "<th>".round($nilai[$i],5)."</th>";
			}
			?>
		</tr>
		</tfoot>

	</table>


	<h2 class="ui header">อันดับ</h2>
	<table class="ui celled collapsing table">
		<thead>
			<tr>
				<th>อันดับ</th>
				<th>ซัพพลายเออร์</th>
				<th>คะแนน</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query  = "SELECT id,nama,id_alternative,nilai FROM alternative,ranking WHERE alternative.id = ranking.id_alternative ORDER BY nilai DESC";
				$result = mysqli_query($koneksi, $query);

				$i = 0;
				while ($row = mysqli_fetch_array($result)) {
					$i++;
				?>
				<tr>
					<?php if ($i == 1) {
						echo "<td><div class=\"ui ribbon label\">อันดับ 1</div></td>";
					} else {
						echo "<td>".$i."</td>";
					}

					?>

					<td><?php echo $row['nama'] ?></td>
					<td><?php echo $row['nilai'] ?></td>
				</tr>

				<?php	
				}


			?>
		</tbody>
	</table>
</section>

<?php @include('footer.blade.php'); ?>