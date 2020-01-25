<?php
  session_start();
  if(!isset($_SESSION['loggedin_pengguna'])):
    header("location: ../login/login.php");
    exit;
  endif;
  date_default_timezone_set('Asia/Jakarta');
  require_once '../koneksi/function_global.php';
  // PRINT CHEKIN & CHEKOUT
  if (!empty($_SESSION['tglrsvcn']) AND !empty($_SESSION['tglrsvct']) AND $_SESSION['compar'] === 'A'):
		$tglrsvcn = $_SESSION['tglrsvcn'];
		$tglrsvct = $_SESSION['tglrsvct'];
		$sql = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
	    FROM tbl_transaksi_pembayaran
	    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
	    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
	    LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
	    WHERE tgl_checkin >= '".$tglrsvcn."' AND tgl_checkout <= '".$tglrsvct."' AND `status` = 'VALID'
	    ORDER BY tbl_reservasi.id_reservasi DESC
	  ");
	// PERIODE RESV
	elseif (!empty($_SESSION['periode_awal']) AND !empty($_SESSION['periode_akhir']) AND $_SESSION['compar'] === 'B'):
	 	$periode_awal = $_SESSION['periode_awal'];
		$periode_akhir = $_SESSION['periode_akhir'];
		$sql = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
      FROM tbl_transaksi_pembayaran
      LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
      LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
      LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
      WHERE jam_reservasi BETWEEN '".$periode_awal."' AND '".$periode_akhir."' + interval 24 hour AND `status` = 'VALID' ORDER BY tbl_reservasi.id_reservasi DESC
	  ");
	// DEFAULT
	elseif (!isset($_SESSION['compar'])):
		$sql = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
	    FROM tbl_transaksi_pembayaran
	    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
	    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
	    LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
	    WHERE CURDATE() <= tbl_reservasi.tgl_checkout AND tbl_transaksi_pembayaran.status = 'VALID'
	    ORDER BY tbl_transaksi_pembayaran.id_reservasi DESC
	  ");
	// elseif ($_SESSION['compar'] === 'C'):
	// 	$sql = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
	//    FROM tbl_transaksi_pembayaran
 	//    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
 	//    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
 	//    LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
 	//    WHERE CURDATE() <= tbl_reservasi.tgl_checkout AND tbl_transaksi_pembayaran.status = 'VALID' AND DATE_SUB(CURDATE(), INTERVAL 1 day)
 	//    ORDER BY tbl_transaksi_pembayaran.id_reservasi DESC 
	//   ");
  else :
		$sql = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
	    FROM tbl_transaksi_pembayaran
	    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
	    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
	    LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
	    WHERE CURDATE() <= tbl_reservasi.tgl_checkout AND tbl_transaksi_pembayaran.status = 'VALID'
	    ORDER BY tbl_transaksi_pembayaran.id_reservasi DESC
	  ");
	endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Print Result</title>
	<link rel="shortcut icon" type="image/png" href="../assets/images/logo-w.png">
	<link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
  <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'> -->
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
  <!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
</head>
<body>
	<div class="container position-relative">
		<header class="head_print mb-4">
			<img src="../assets/images/logo-title.png" width="140" height="95" alt="Logo">
			<div class="text-center">
				<h2 class="text-center mt-4 font-weight-bold">Widuri Villa</h2>
				<h5 class="font-weight-normal text-secondary">Jln. Raya Kerobokan Kelod, No: 101, Br. Taman, Kuta Utara,</br> Badung, Bali - Indonesia</h5>
				<div class="d-flex justify-content-center text-secondary align-items-center">
					<i class="fas fa-phone"></i>&nbsp;+62 8179 719 692&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-envelope"></i>&nbsp;widuri@gmail.com
				</div>
			</div>
		</header>
		<hr class="py-0 mb-3 hr_print">
		<div class="row">
			<div class="col-12 text-center mb-3">
				<h4>Laporan Reservasi</h4>
				<?php
      	if (!empty($tglrsvcn) AND !empty($tglrsvct)) :
      		if(($_SESSION['compar'] === 'A') AND ($tglrsvcn === $tglrsvct)): ?>
        		<span class="text-center text-wrap">Checkin & checkout pada tanggal <b><?=tgl_indo($tglrsvcn) ?></b>.</span>
        	<?php else: ?>
        		<span class="text-center text-wrap">Checkin & checkout dari tanggal <b><?=tgl_indo($tglrsvcn) ?></b> sampai <b><?=tgl_indo($tglrsvct) ?></b>.</span>
        	<?php endif; ?>
      	<?php endif; ?>
      	<?php 
      	if (!empty($periode_awal) AND !empty($periode_akhir)) :
      		if(($_SESSION['compar'] === 'B') AND ($periode_awal === $periode_akhir)): ?>
        		<span class="text-center text-wrap">Pada tanggal <b><?=tgl_indo($periode_awal) ?></b>.</span>
        	<?php else: ?>
        		<span class="text-center text-wrap">Periode <b><?=tgl_indo($periode_awal) ?></b> sampai <b><?=tgl_indo($periode_akhir) ?></b>.</span>
        	<?php endif; ?>
      	<?php endif; ?>
      	<?php 
      	if (empty($periode_awal) AND empty($periode_akhir) AND empty($tglrsvcn) AND empty($tglrsvct)):
      		if(empty($_SESSION['compar'])): ?>
        		<span class="text-center text-wrap">Saat ini (<b><?php echo tgl_indo2(date("Y-m-d")); ?></b>)</span>
        	<?php else: ?>
        		<span class="text-center text-wrap">Saat ini (<b><?php echo tgl_indo2(date("Y-m-d")); ?></b>)</span>
        	<?php endif; ?>
      	<?php endif; ?>
			</div>
			<div class="col-12 position-relative" style="padding: 0 !important">
				<table class="table lap table-hover rounded">
					<thead class="text-center thead-dark">
						<tr>
							<th style="border-top-left-radius: 10px !important">No</th>
              <th>Id Res</th>
              <th>Tamu</th>
              <th>Email</th>
              <th>Checkin</th>
              <th>Checkout</th>
              <th>Malam</th>
              <th>T.Kamar</th>
              <th>Qty.Kam</th>
              <th>Dewasa</th>
              <th>Anak</th>
              <th style="border-top-right-radius: 10px">Status</th>
            </tr>
					</thead>
					<tbody>
						<?php
						if (count($sql) > 0) :
							$i = 1;
							foreach ($sql as $row): ?>
								<?php $jam_reservasi = date_format(new Datetime($row["jam_reservasi"]), "Y-m-d"); ?>
								<tr class="text-nowrap">
									<td class="text-center font-weight-bold"><?=$i; ?></td>
                  <td>RSV-0<?=$row['id_reservasi']; ?></td>
                  <td><?=$row['nama_tamu']; ?></td>
                  <td><?=$row['email_tamu'] ?></td>
                  <td><?=tgl_indo($row['tgl_checkin']); ?></td>
                  <td><?=tgl_indo($row['tgl_checkout']); ?></td>
                  <td class="text-center"><?=$row['jumlah_hari']; ?></td>
                  <td class="text-center"><?=$row['tipe_kamar'];?></td>
                  <td class="text-center"><?=$row['jumlah_kamar_perPilihan'];?></td>
                  <td class="text-center"><?=$row['jumlah_orang']; ?></td>
                  <td class="text-center"><?=$row['jumlah_anak']; ?></td>
                  <td class="text-center px-2 py-0">
                    <?php include '../staf/statusReservasi.php'; ?>
                  </td>
                </tr>
								<?php
							++$i;
							endforeach;?>
								<tr><td colspan="12" class="bg-dark foot" style="border-bottom-left-radius: 100px; border-bottom-right-radius: 100px; padding: 1px !important"></td></tr>
						<?php else: ?>
							<tr><td colspan="12">Tidak ada data untuk ditampilkan</td></tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
		<footer class="col-12 d-flex justify-content-end">
			<div class="d-flex flex-column pr-5 py-3">
				<span class="text-center pb-5"><?=tgl_indo2(date("Y-m-d"), true); ?></span>
				<span class="pt-3 text-center"><b><?=$_SESSION["loggedin_pengguna"]["nama_pengguna"]; ?></b></span>
			</div>
		</footer>
	</div>
	<script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
	<script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
	<script type="text/javascript">
		// window.print();
	</script>
</body>
</html>