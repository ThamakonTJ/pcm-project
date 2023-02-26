@extends('ahp.header');



<section class="content">
	<h3 class="ui header">ตารางเปรียบเทียบแบบคู่</h3>
	<table class="ui collapsing celled blue table">
		<thead>
			<tr>
				<th>เกณฑ์</th>
<?php
	for ($i=0; $i <= ($n-1); $i++) {
		echo "<th>".getalternativeNama($i)."</th>";
	}
?>
			</tr>
		</thead>
		<tbody>
<?php
	for ($x=0; $x <= ($n-1); $x++) {
		echo "<tr>";
		echo "<td>".getalternativeNama($x)."</td>";
			for ($y=0; $y <= ($n-1); $y++) {
				echo "<td>".round($matrik[$x][$y],5)."</td>";
			}

		echo "</tr>";
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<th>ทั้งหมด</th>
<?php
		for ($i=0; $i <= ($n-1); $i++) {
			echo "<th>".round($jmlmpb[$i],5)."</th>";
		}
?>
			</tr>
		</tfoot>
	</table>


	<br>

	<h3 class="ui header">Normalized Matrix</h3>
	<table class="ui celled red table">
		<thead>
			<tr>
				<th>เกณฑ์</th>
<?php
	for ($i=0; $i <= ($n-1); $i++) {
		echo "<th>".getalternativeNama($i)."</th>";
	}
?>
				<th>ทั้งหมด</th>
				<th>ค่าน้ำหนักของเกณฑ์</th>
			</tr>
		</thead>
		<tbody>
<?php
	for ($x=0; $x <= ($n-1); $x++) {
		echo "<tr>";
		echo "<td>".getalternativeNama($x)."</td>";
			for ($y=0; $y <= ($n-1); $y++) {
				echo "<td>".round($matrikb[$x][$y],5)."</td>";
			}

		echo "<td>".round($jmlmnk[$x],5)."</td>";
		echo "<td>".round($pv[$x],5)."</td>";

		echo "</tr>";
	}
?>

		</tbody>
		<tfoot>
			
		</tfoot>
	</table>



<?php

	if ($consRatio > 0.1) {
?>
		<div class="ui icon red message">
			<i class="close icon"></i>
			<i class="warning circle icon"></i>
			<div class="content">
				<div class="header">
					 !!!
				</div>
				<p></p>
			</div>
		</div>

		<br>

		<a href='javascript:history.back()'>
			<button class="ui left labeled icon button">
				<i class="left arrow icon"></i>
				ย้อนกลับ
			</button>
		</a>

<?php

	} else {
		if ($jenis == getJumlahcriteria()) {
?>

<br>

<form action="hasil.php">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		ต่อไป
	</button>
</form>


<?php

		} else {

?>
<br>
	<a href="<?php echo "bobot.php?c=".($jenis + 1)?>">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		ต่อไป
	</button>
	</a>

<?php

		}
	}

	echo "</section>";   
	

?>	@extends('ahp.footer');
