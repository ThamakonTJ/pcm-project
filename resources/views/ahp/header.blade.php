<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>AHP</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/semantic/dist/semantic.min.css">
</head>

<body>
<header>
	<h1>ระบบสนับสนุนการตัดสินใจเลือกซัพพลายเออร์</h1>
</header>


<?php
// Menampilkan list alternative
$alternative = DB::table('alternative')->select()->get()->count();
$criteria = DB::table('criteria')->select()->get()->count();
/*$query = "SELECT id,nama FROM alternative ORDER BY id";
$result	= mysqli_query($koneksi, $query);*/

$i = 0;
/*while ($row = mysqli_fetch_array($result)) {
	$i++;*/
?>

<div class="wrapper">
	<nav id="navigation" role="navigation">
		<ul>
			<li><a class="item" href="{{ route('ahp.index') }}">หน้าแรก</a></li>
			<li>
				<a class="item" href="{{ route('ahp.criteria') }}">เกณฑ์การตัดสินใจ
					<div class="ui blue tiny label" style="float: right;"><?php echo $criteria ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="{{ route('ahp.alternative') }}">ซัพพลายเออร์ทางเลือก
					<div class="ui blue tiny label" style="float: right;"><?php echo $alternative ?></div>
				</a>
			</li>
			<li><a class="item" href="{{ route('ahp.bobot_criteria', ['type' => 'criteria']) }}">เปรียบเทียบเกณฑ์</a></li>
			<li><a class="item" href="{{ route('ahp.bobot') }}">เปรียบเทียบซัพพลายเออร์</a></li>
				<ul>
					<?php

						/*if (getJumlahcriteria() > 0) {
							for ($i=0; $i <= (getJumlahcriteria()-1); $i++) { 
								echo "<li><a class='item' href='bobot.php?c=".($i+1)."'>".getcriteriaNama($i)."</a></li>";
							}
						}*/

					?>
				</ul>
			<li><a class="item" href="{{ route('ahp.output') }}">ผลลัพธ์</a></li>
			<li><a class="item" href="{{ route('user.dashboard') }}">หน้าหลัก</a></li>
		</ul>
		
	</nav>
	<div class="content-wrapper">
		@yield('content')
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
					</div><!-- /.col -->
					<div class="col-sm-6">
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->

		<!-- /.content -->

	</div>