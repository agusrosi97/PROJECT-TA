<?php
	session_start();
	require '../koneksi/function_global.php';
	$day = "jam_transaksi >= DATE_SUB(NOW(),INTERVAL 24 HOUR) AND status = 'VALID'";
	$week = "jam_transaksi >= DATE_SUB(NOW(),INTERVAL 168 HOUR) AND status = 'VALID'";
	$month = "jam_transaksi >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY) AND status = 'VALID'";
	$year = "YEAR(jam_transaksi) = YEAR(CURRENT_DATE()) AND status = 'VALID'";
	$ambilData = mysqli_query($conn, "SELECT sum(total_pembayaran_kamar) AS total_bayar_kamar FROM tbl_transaksi_pembayaran WHERE ".$_SESSION['currentDate_Trans']."");
	$get = mysqli_fetch_assoc($ambilData);
?>
<?php if($get['total_bayar_kamar'] > 0): ?>
	<div class="h4 mb-0 text-light">
	  <span class="">Rp.<?= number_format($get['total_bayar_kamar'],0,',','.');?>,-</span>
	</div>
	<?php if($day === $_SESSION['currentDate_Trans']):?>
		<small class='text-light text-uppercase font-weight-bold'>Total Transaksi dalam 24 jam terakhir</small>
	<?php elseif($week === $_SESSION['currentDate_Trans']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Total Transaksi dalam 1 minggu terakhir</small>
	<?php elseif($month === $_SESSION['currentDate_Trans']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Total Transaksi dalam sebulan terakhir</small>
	<?php elseif($year === $_SESSION['currentDate_Trans']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Total Transaksi dalam setahun terakhir</small>
	<?php else: ?> 
		<small class='text-light text-uppercase font-weight-bold'>Total Transaksi</small>
	<?php endif; ?>
<?php else: ?>
	<div class="h5 mb-0 text-light">
	  <span class="">Masih Menunggu</span>
	</div>
<?php endif; ?>