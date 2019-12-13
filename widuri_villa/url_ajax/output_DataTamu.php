<?php
	session_start();
	require '../koneksi/function_global.php';
	$day = "date_create >= DATE_SUB(NOW(),INTERVAL 24 HOUR)";
	$week = "date_create >= DATE_SUB(NOW(),INTERVAL 168 HOUR)";
	$month = "date_create >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY)";
	$year = "YEAR(date_create) = YEAR(CURRENT_DATE())";
	$ambilData = mysqli_query($conn, "SELECT COUNT(id_tamu) AS akun_tamu FROM tbl_tamu WHERE ".$_SESSION['currentDate_Tamu']."");
	$get = mysqli_fetch_assoc($ambilData);
?>
<?php if($get['akun_tamu'] > 0): ?>
	<div class="h4 mb-0 text-light">
	  <span class=""><?= $get['akun_tamu'];?></span>
	</div>
	<?php if($day === $_SESSION['currentDate_Tamu']):?>
		<small class='text-light text-uppercase font-weight-bold'>Tamu terdaftar dalam 24 jam terakhir</small>
	<?php elseif($week === $_SESSION['currentDate_Tamu']):?>
		<small class='text-light text-uppercase font-weight-bold'>Tamu terdaftar dalam seminggu terakhir</small>
	<?php elseif($month === $_SESSION['currentDate_Tamu']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Tamu terdaftar dalam sebulan terakhir</small>
	<?php elseif($year === $_SESSION['currentDate_Tamu']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Tamu terdaftar dalam setahun terakhir</small>
	<?php else: ?> 
		<small class='text-light text-uppercase font-weight-bold'>Total Tamu terdaftar</small>
	<?php endif; ?>
<?php else: ?>
	<div class="h5 mb-0 text-light">
	  <span class="">Belum ada Tamu terdaftar</span>
	</div>
<?php endif; ?>