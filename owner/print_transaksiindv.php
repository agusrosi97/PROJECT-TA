<?php 
	session_start();
	date_default_timezone_set('Asia/Jakarta');
  require_once '../koneksi/function_global.php';
	if (isset($_GET['id'])) {
		$idTrans = $_GET['id'];
		$data_transaksi = mysqli_query($conn, "SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
	  FROM tbl_transaksi_pembayaran
	  LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
	  LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
	  LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
	  WHERE id_transaksi = '".$idTrans."'
	  ORDER BY id_transaksi DESC");
	  $row = mysqli_fetch_assoc($data_transaksi);
	  $kamar = explode(", ", $row['tipe_kamar']);
	  $qty_kamar = explode(", ", $row['jumlah_kamar_perPilihan']);
	}else{
		header('Location: laporan_transaksi.php');
	}
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
<body>
	<div class="d-flex justify-content-center flex-column pb-3 mb-5">
		<header class="my-2 head_print" class="d-flex justify-content-center">
			<div class="text-center">
				<h2 class="text-center mt-4 font-weight-bold">Widuri Villa</h2>
				<h5 class="font-weight-normal text-secondary">Jln. Raya Kerobokan Kelod, No: 101, Br. Taman, Kuta Utara,</br> Badung, Bali - Indonesia</h5>
				<div class="d-flex justify-content-center text-secondary align-items-center">
					<i class="fas fa-phone"></i>&nbsp;+62 8179 719 692&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-envelope"></i>&nbsp;widuri@gmail.com
				</div>
			</div>
		</header>
		<div class="position-relative">
			<div style="margin: 0 auto; width: 530px">
				<hr class="py-0 mb-4 hr_print">
				<span class="d-flex justify-content-end">
					<div class="d-flex flex-column">
						<span class="text-center"><?=tgl_indo2(date("Y-m-d"), true); ?></span>
					</div>
				</span>
				<span class="text-muted h5 border-bottom pr-5">Reservasi</span>
				<table class="print_indv mb-2">
					<tr>
						<th class="pr-4">Nama Tamu</th>
						<td class="pr-3">:</td>
						<td class="font-weight-bold h5"><?=$row['nama_tamu'] ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td>:</td>
						<td><?=$row['email_tamu'] ?></td>
					</tr>
					<tr>
						<th>Telepon</th>
						<td>:</td>
						<td><?=$row['no_telp_tamu'] ?></td>
					</tr>
					<tr>
						<th>Alamat</th>
						<td>:</td>
						<td><?=$row['alamat_tamu'] ?></td>
					</tr>
					<tr>
						<th>Checkin</th>
						<td>:</td>
						<td><?=tgl_indo2($row['tgl_checkin']) ?></td>
					</tr>
					<tr>
						<th>Checkout</th>
						<td>:</td>
						<td><?=tgl_indo2($row['tgl_checkout']) ?></td>
					</tr>
					<tr>
						<th>J. Dewasa</th>
						<td>:</td>
						<td><?=$row['jumlah_orang'] ?></td>
					</tr>
					<tr>
						<th>J. Anak</th>
						<td>:</td>
						<td><?=$row['jumlah_anak'] ?></td>
					</tr>
				</table>
				<span class="text-muted h5">Pesanan</span>
				<table class="table print_indv">
					<tr>
						<th>Kamar</th>
						<th>Jml. Kamar</th>
						<th>Malam</th>
						<th>Total bayar</th>
						<th>Status</th>
					</tr>
					<tr>
						<td>
							<?php foreach (array_combine($kamar, $qty_kamar) as $key => $JmlKamarTerpilih): ?>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE id_tipe_kamar = ".$key."");
                $rowkam = mysqli_fetch_assoc($query);
              	?>
              	<span class="mb-2"><?=$rowkam["nama_tipe_kamar"]; ?></span><br>
              <?php endforeach; ?>
						</td>
						<td>
							<?php foreach (array_combine($kamar, $qty_kamar) as $key => $JmlKamarTerpilih):?>
              	<span class="mb-2"><?=$JmlKamarTerpilih;?></span><br>
              <?php endforeach; ?>
						</td>
						<td style="vertical-align: middle;"><?=$row["jumlah_hari"] ?> malam</td>
						<td style="vertical-align: middle;" class="font-weight-bold">Rp.<?=number_format($row['total_pembayaran_kamar'],2,',','.') ?></td>
						<td style="vertical-align: middle;" class="font-weight-bold">
							<?php if($row['status'] === 'VALID'): ?>
								<i class="fas fa-check text-success"></i>
							<?php else: ?>
								<i class="fas fa-times text-danger"></i>
							<?php endif; ?>
						</td>
					</tr>
				</table>
				<span class="text-muted h5 border-bottom pr-5">Staf</span>
				<table class="mt-2">
					<tr>
						<th class="pr-4">Nama Staf</th>
						<td class="pr-3">:</td>
						<td class="font-weight-bold"><?=$row['username_pengguna'] ?></td>
					</tr>
				</table>
				<hr class="py-0 mb-4 hr_print">
				<div class="text-center">
					<span><i class="far fa-copyright"></i> <script type="text/javascript">document.write(new Date().getFullYear());</script> Widuri VIlla</span>
				</div>
			</div>
		</div>
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