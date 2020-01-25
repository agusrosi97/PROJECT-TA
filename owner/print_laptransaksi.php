<?php
  session_start();
  if(!isset($_SESSION['loggedin_pengguna'])):
    header("location: ../login/login.php");
    exit;
  endif;
  date_default_timezone_set('Asia/Jakarta');
  require_once '../koneksi/function_global.php';
	if (!empty($_SESSION['perioAwalTrans']) OR !empty($_SESSION['perioAkhirTrans'])) :
		$awal_trans = $_SESSION['perioAwalTrans'];
  	$akhir_trans = $_SESSION['perioAkhirTrans'];
		$data_transaksi = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
    FROM tbl_transaksi_pembayaran
    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    WHERE jam_transaksi BETWEEN DATE('".$awal_trans."') AND DATE('".$akhir_trans."') + INTERVAL 24 HOUR AND `status` IS NOT NULL ORDER BY id_transaksi DESC
	  ");
 else:
	  $data_transaksi = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
    FROM tbl_transaksi_pembayaran
    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    WHERE CURDATE() <= tgl_checkout AND `status` IS NOT NULL
    ORDER BY id_transaksi DESC");
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
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
  <!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
</head>
<body class="pirntLap">
	<div class="position-relative" style="width: 90%; margin: 0 auto;">
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
		<div class="">
			<div class="col-12 text-center mb-3">
				<h4>Laporan Transaksi</h4>
				<?php if(!empty($_SESSION['perioAwalTrans']) AND !empty($_SESSION['perioAkhirTrans']) AND $_SESSION['perioAwalTrans'] === $_SESSION['perioAkhirTrans']): ?>
					<span>Periode <b><?=tgl_indo2($_SESSION['perioAwalTrans']);?></b></span>
				<?php elseif(!empty($_SESSION['perioAwalTrans']) AND !empty($_SESSION['perioAkhirTrans']) AND $_SESSION['perioAwalTrans'] !== $_SESSION['perioAkhirTrans']): ?>
					<span>Periode <b><?=tgl_indo2($_SESSION['perioAwalTrans']);?></b> sampai <b><?=tgl_indo2($_SESSION['perioAkhirTrans']);?></b></span>
				<?php else: ?>
					<span>Saat ini <b><?=tgl_indo2(date("Y-m-d")) ?></b></span>
				<?php endif; ?>
			</div>
			<div style="margin: 0 auto;">
				<table class="table lap table-hover rounded">
					<thead class="text-center thead-dark">
						<tr class="text-nowrap text-center">
              <th style="border-top-left-radius: 10px !important">No</th>
              <th>Tamu</th>
              <th>Total</th>
              <th>Tgl Transaksi</th>
              <th>Jam</th>
              <th>Qty.Kam</th>
              <th>Ket</th>
              <th>CheckIn</th>
              <th>Checkout</th>
              <th>Tp.Kamar</th>
              <th>Bukti</th>
              <th style="border-top-right-radius: 10px" class="text-center">Status</th>
            </tr>
					</thead>
					<tbody>
						<?php $i = 1; ?>
						<?php if(count($data_transaksi) > 0): ?>
	            <?php foreach( $data_transaksi as $row ) : ?>
	            	<?php
	              $timestamp = $row["jam_transaksi"];
	              $datetime = explode(" ",$timestamp);
	              $date = $datetime[0];
	              $time = $datetime[1];
	              $time12Hour = date_format(new Datetime($time), "h:i:s A"); ?>
	              <tr class="text-nowrap">
	                <td class="text-center font-weight-bold"><?=$i; ?></td>
	                <td class="text-wrap"><?=$row["nama_tamu"]; ?></td>
	                <td>Rp.<?= number_format($row["total_pembayaran_kamar"],2,',','.'); ?>,-</td>
	                <td class="text-center"><?=tgl_indo($date); ?></td>
	                <td class="text-center"><?=$time12Hour; ?></td>
	                <td class="text-center"><?=$row["jumlah_kamar"]; ?></td>
	                <td class="text-center"><?=$row["ket_transaksi"]; ?></td>
	                <td class="text-center"><?=tgl_indo($row['tgl_checkin']); ?></td>
	                <td class="text-center"><?=tgl_indo($row['tgl_checkout']); ?></td>
	                <td class="text-center"><?=$row["tipe_kamar"]; ?></td>
	                <td class="p-1 text-center">
	                  <?php if($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === NULL OR 'GAK VALID' AND $row['foto_bukti_transaksi'] === NULL):?>
	                  <?php elseif($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === 'VALID'): ?>
	                    <!-- <div class="data_foto" style="opacity: .8;">
	                      <img src="../assets/images/payment.png" alt="">
	                    </div> -->
	                    CASH
	                  <?php else : ?>
	                    <!-- <div class="data_foto" style="cursor: pointer;">
	                      <img src="../assets/foto_transaksi/<?=$row["foto_bukti_transaksi"] ?>" alt="" data-toggle="modal" data-target="#modalFoto_<?=$row["id_transaksi"];?>">
	                    </div> -->
	                    TRANSF
	                  <?php endif; ?>
	                </td>
	                <td class="text-center p-1">
	                  <?php if($row["status"] === "VALID") : ?>
	                    <i class="fas fa-check text-success"></i>
	                  <?php elseif($row["status"] === null) : ?>
	                    <button class="btn btn-outline-success rounded border-0" data-toggle="modal" data-target="#popUpReservasi_<?=$row["id_transaksi"] ?>"><i class="fas fa-check" style="font-size: 20px"></i></button>
	                    <button class="btn btn-outline-danger rounded border-0" data-toggle="modal" data-target="#popUpReservasiGakvalid_<?=$row["id_transaksi"] ?>"><i class="fas fa-times" style="font-size: 20px"></i></button>
	                  <?php elseif($row["status"] === "GAK VALID") : ?>
	                    <i class="fas fa-times text-danger"></i>
	                  <?php endif; ?>
	                </td>
	              </tr>
							<?php
							++$i;
							endforeach;?>
							<tr><td colspan="12" class="bg-dark foot" style="border-bottom-left-radius: 100px; border-bottom-right-radius: 100px; padding: 1px !important"></td></tr>
						<?php else: ?>
							<tr><td colspan="8">Tidak ada data untuk ditampilkan</td></tr>
						<?php
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
		<footer class="d-flex justify-content-end">
			<div class="d-flex flex-column py-3 pr-5 mr-5">
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
		window.print();
	</script>
</body>
</html>