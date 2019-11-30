<?php
	session_start();
	require '../../koneksi/function_global.php';
	$day = "DAY(jam_reservasi) = DAY(CURRENT_DATE())";
	$month = "MONTH(jam_reservasi) = MONTH(CURRENT_DATE())";
	$year = "YEAR(jam_reservasi) = YEAR(CURRENT_DATE())";
	$ambilData = mysqli_query($conn, "SELECT COUNT(id_tamu) AS banyak_tamu FROM tbl_reservasi WHERE ".$_SESSION['currentDate_Resv']."");
	$get = mysqli_fetch_assoc($ambilData);
?>
<?php if($get['banyak_tamu'] > 0): ?>
	<div class="h4 mb-0 text-light">
	  <span class=""><?= $get['banyak_tamu'];?></span>
	</div>
	<?php if($day === $_SESSION['currentDate_Resv']):?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi pada hari ini</small>
	<?php elseif($month === $_SESSION['currentDate_Resv']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi pada bulan ini</small>
	<?php elseif($year === $_SESSION['currentDate_Resv']): ?>
		<small class='text-light text-uppercase font-weight-bold'>Reservasi pada tahun ini</small>
	<?php else: ?> 
		<small class='text-light text-uppercase font-weight-bold'>Total Reservasi</small>
	<?php endif; ?>
<?php else: ?>
	<div class="h5 mb-0 text-light">
	  <span class="">Masih Menunggu 😉</span>
	</div>
<?php endif; ?>