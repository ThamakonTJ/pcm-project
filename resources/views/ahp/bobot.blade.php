<?php
	@include('config.blade.php');
	@include('fungsi.blade.php');

	/*$jenis = $_GET['c'];*/
	@include('header.blade.php');
?>
@extends('ahp.header')
@section('content')
	<h2 class="ui header">เปรียบเทียบซัพพลายเออร์ &rarr; <?php /*echo getcriteriaNama($jenis-1) */?></h2>
	<?php /*showTabelPerbandingan($jenis,'alternative'); */?>
@endsection

<?php @include('footer.blade.php'); ?>