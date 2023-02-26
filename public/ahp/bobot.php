<?php
	include('config.php');
	include('fungsi.php');

	$jenis = $_GET['c'];

	include('header.php');
?>
<section class="content">
	<h2 class="ui header">เปรียบเทียบซัพพลายเออร์ &rarr; <?php echo getKriteriaNama($jenis-1) ?></h2>
	<?php showTabelPerbandingan($jenis,'sup_select'); ?>
</section>

<?php include('footer.php'); ?>