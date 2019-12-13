<?php 
session_start();
$valueLaporanTamu = $_POST['laporanTamuSelect'];
switch ($valueLaporanTamu) {
	case 'digunakan':
		$_SESSION['LaporanTamu'] = "SELECT tbl_tamu.*, tbl_reservasi.*, tbl_transaksi_pembayaran.* FROM tbl_transaksi_pembayaran INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi WHERE tgl_checkin <= date(now()) AND tgl_checkout >= date(now()) AND `status` = 'VALID' GROUP BY tbl_tamu.id_tamu";
	break;
	case 'tidak_memesan':
		$_SESSION['LaporanTamu'] = "SELECT * FROM tbl_tamu WHERE tbl_tamu.id_tamu NOT IN (SELECT id_tamu FROM tbl_reservasi)";
	break;
	case 'rentang':
		$_SESSION['LaporanTamu'] = "SELECT * FROM tbl_tamu WHERE date_sub(now(), interval 5 day) <= `date_create` ORDER BY id_tamu DESC";
	break;
}
?>