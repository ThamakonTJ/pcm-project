<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>AHP</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
	<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body>
<header>
	<h1>ระบบสนับสนุนการตัดสินใจเลือกซัพพลายเออร์</h1>
</header>

<div class="wrapper">
	<nav id="navigation" role="navigation">
		<ul>
			<li><a class="item" href="index.php">หน้าแรก</a></li>
			<li>
				<a class="item" href="kriteria.php">เกณฑ์การตัดสินใจ
					<div class="ui blue tiny label" style="float: right;"><?php echo getJumlahKriteria(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="alternatif.php">ซัพพลายเออร์ทางเลือก
					
				</a>
			</li>
			<li><a class="item" href="bobot_kriteria.php">เปรียบเทียบเกณฑ์</a></li>
			<li><a class="item" href="bobot.php?c=1">เปรียบเทียบซัพพลายเออร์</a></li>
				<ul>
					<?php

						if (getJumlahKriteria() > 0) {
							for ($i=0; $i <= (getJumlahKriteria()-1); $i++) { 
								echo "<li><a class='item' href='bobot.php?c=".($i+1)."'>".getKriteriaNama($i)."</a></li>";
							}
						}

					?>
				</ul>

			<?php

			?>
			<li><a class="item" href="hasil.php">ผลลัพธ์</a></li>

			
			<li><a class="item" href="../../roleMain/">หน้าหลัก</a></li>
		</ul>
	</nav>