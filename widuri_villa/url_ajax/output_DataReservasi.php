<?php
	session_start();
	date_default_timezone_set('Asia/Singapore');
	require '../koneksi/function_global.php';
	$day = "jam_reservasi >= DATE_SUB(NOW(),INTERVAL 24 HOUR)";
	$week = "jam_reservasi >= DATE_SUB(NOW(),INTERVAL 168 HOUR)";
	$month = "jam_reservasi >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY)";
	$year = "YEAR(jam_reservasi) = YEAR(CURRENT_DATE())";
	$ambilData = mysqli_query($conn, "SELECT COUNT(id_tamu) AS banyak_tamu FROM tbl_reservasi WHERE ".$_SESSION['currentDate_Resv']."");
	$get = mysqli_fetch_assoc($ambilData);
?>
<?php if($get['banyak_tamu'] > 0): ?>
	<div class="h4 mb-0 text-light">
	  <span class=""><?= $get['banyak_tamu'];?></span>
	</div>
	<?php if($day === $_SESSION['currentDate_Resv']):?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi dalam 24 jam terakhir</small>
	<?php elseif($week === $_SESSION['currentDate_Resv']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi dalam 1 minggu terakhir</small>
	<?php elseif($month === $_SESSION['currentDate_Resv']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi dalam sebulan terakhir</small>
	<?php elseif($year === $_SESSION['currentDate_Resv']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi dalam setahun terakhir</small>
	<?php else: ?> 
		<small class='text-light text-uppercase font-weight-bold'>Total Reservasi</small>
	<?php endif; ?>
<?php else: ?>
	<div class="h5 mb-0 text-light">
	  <span class="">Masih Menunggu</span>
	</div>
<?php endif; ?>