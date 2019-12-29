<?php
  session_start();
  if(!isset($_SESSION['loggedin_pengguna'])):
    header("location: ../login/login.php");
    exit;
  endif;
  $tgl_awal = $_SESSION['tglawalCheckout'];
	$tgl_akhir = $_SESSION['tglakhirCheckout'];
  date_default_timezone_set('Asia/Jakarta');
  require_once '../koneksi/function_global.php';
  if (!empty($tgl_awal) AND !empty($tgl_akhir)) :
    $sql = query("SELECT tbl_tamu.*, tbl_reservasi.*, tbl_transaksi_pembayaran.* FROM tbl_transaksi_pembayaran INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi WHERE tgl_checkout BETWEEN DATE('".$tgl_awal."') AND DATE('".$tgl_akhir."') AND status = 'VALID' GROUP BY tbl_tamu.email_tamu ORDER BY nama_tamu ASC");
  elseif (empty($tgl_awal) AND !empty($tgl_akhir)) :
    $sql = query("SELECT tbl_tamu.*, tbl_reservasi.*, tbl_transaksi_pembayaran.* FROM tbl_transaksi_pembayaran INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi WHERE tgl_checkout <= '".$tgl_akhir."' AND status = 'VALID' GROUP BY tbl_tamu.email_tamu ORDER BY nama_tamu ASC");
  elseif (!empty($tgl_awal) AND empty($tgl_akhir)) :
    $sql = query("SELECT tbl_tamu.*, tbl_reservasi.*, tbl_transaksi_pembayaran.* FROM tbl_transaksi_pembayaran INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi WHERE tgl_checkout BETWEEN '".$tgl_awal."' AND NOW() AND status = 'VALID' GROUP BY tbl_tamu.email_tamu ORDER BY nama_tamu ASC");
  else :
    $sql = query("SELECT tbl_tamu.*, tbl_reservasi.*, tbl_transaksi_pembayaran.* FROM tbl_transaksi_pembayaran INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi WHERE tgl_checkout <= NOW() AND `status` = 'VALID' GROUP BY tbl_tamu.email_tamu ORDER BY nama_tamu ASC");
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
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
  <!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
</head>
<body>
	<div class="container position-relative">
		<header class="head_print mb-4">
			<img class="img-fluid" src="../assets/images/logo-title.png" width="140" height="95" alt="Logo">
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
				<h4>Laporan Tamu</h4>
				<?php if (!empty($tgl_awal) AND !empty($tgl_akhir) AND $tgl_awal !== $tgl_akhir) : ?>
					<span>Checkout pada tanggal <b><?=tgl_indo($tgl_awal); ?> s/d <?= tgl_indo($tgl_akhir) ?></b></span>
				<?php elseif (!empty($tgl_awal) AND !empty($tgl_akhir) AND $tgl_awal === $tgl_akhir): ?>
					<span>Checkout pada tanggal <b><?= tgl_indo($tgl_awal); ?></b></span>
				<?php elseif (empty($tgl_awal) AND !empty($tgl_akhir)) : ?>
					<span>Checkout pada tanggal <b><?=tgl_indo($tgl_akhir) ?> dan sebelumnya.</b></span>
				<?php elseif (!empty($tgl_awal) AND empty($tgl_akhir)) : ?>
					<span>Checkout pada tanggal <b><?=tgl_indo($tgl_awal); ?> s/d sekarang.</b></span>
				<?php else : ?>
					<span>Checkout pada tanggal <b><?=tgl_indo(date("Y-m-d")); ?> dan sebelumnya.</b></span>
				<?php endif; ?>
			</div>
			<div class="col-12">
				<table class="table lap table-hover rounded">
					<thead class="thead-dark">
						<tr>
							<th style="border-top-left-radius: 10px !important" class="text-center">No</th>
							<th>Nama</th>
							<th>No Tlp</th>
							<th>Email</th>
							<th>Alamat</th>
							<th>Tgl Lahir</th>
							<th style="border-top-right-radius: 10px">JK</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (count($sql) > 0) :
							$i = 1;
							foreach ($sql as $row): ?>
								<tr>
									<td class="text-center font-weight-bold"><?=$i ?></td>
									<td><?=$row['nama_tamu']; ?></td>
									<td><?=$row['no_telp_tamu'];  ?></td>
									<td><?=$row['email_tamu']; ?></td>
									<td><?=$row['alamat_tamu']; ?></td>
									<td><?=tgl_indo2($row['tgl_lahir_tamu']); ?></td>
									<td><?=$row['jk_tamu'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
								</tr>
							<?php
							++$i;
							endforeach;?>
							<tr><td colspan="8" class="bg-dark foot" style="border-bottom-left-radius: 100px; border-bottom-right-radius: 100px; padding: 1px !important"></td></tr>
						<?php else: ?>
							<tr><td colspan="8">Tidak ada data untuk ditampilkan</td></tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
		<footer class="col-12 d-flex justify-content-end">
			<div class="d-flex flex-column pr-5 py-3">
				<span class="text-center pb-5"><?= tgl_indo2(date("Y-m-d"), true); ?></span>
				<span class="pt-3 text-center"><b><?=$_SESSION["loggedin_pengguna"]["nama_pengguna"]; ?></b></span>
			</div>
		</footer>
	</div>
	<script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
	<script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>