<?php
	include('config.php');
	include('fungsi.php');

	include('header.php');
?>
<section class="content">
	<h2 class="ui header">เปรียบเทียบเกณฑ์</h2>
	<?php showTabelPerbandingan('kriteria','kriteria'); ?>
</section>

<?php include('footer.php'); ?>