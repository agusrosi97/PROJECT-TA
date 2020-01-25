<?php 
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
	require '../koneksi/function_global.php';
	include '../query/queryDataDiri_pengguna.php';
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
  elseif ($_SESSION['compar'] === 'C'):
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
<table id="OwnerTablesReservasi" class="table rounded dt-responsive table-hover nowrap" width="100%">
  <thead class="thead-dark">
    <tr class="text-nowrap text-center">
      <th>Id Res</th>
      <th>Nama Tamu</th>
      <th>Email Tamu</th>
      <th>Status</th>
      <th>Nama staf</th>
      <th>Checkin</th>
      <th>Checkout</th>
      <th>Malam</th>
      <th>Tipe Kamar</th>
      <th>Qty /Kam</th>
      <th>J. Dewasa</th>
      <th>J. Anak</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $no=1;
        foreach ($sql as $row):
          $jam_reservasi = date_format(new Datetime($row["jam_reservasi"]), "Y-m-d");
        ?>
        <tr class="text-nowrap text-center">
          <td>RSV-0<?=$row['id_reservasi']; ?></td>
          <td><?=$row['nama_tamu']; ?></td>
          <td><?=$row['email_tamu'] ?></td>
          <td class="text-center">
            <?php include '../staf/statusReservasi.php'; ?>
          </td>
          <td><?=$row["username_pengguna"]; ?></td>
          <td class="text-nowrap"><?=tgl_indo($row['tgl_checkin']); ?></td>
          <td class="text-nowrap"><?=tgl_indo($row['tgl_checkout']); ?></td>
          <td><?=$row['jumlah_hari']; ?></td>
          <td><?=$row['tipe_kamar'];?></td>
          <td><?=$row['jumlah_kamar_perPilihan'];?></td>
          <td><?=$row['jumlah_orang']; ?></td>
          <td><?=$row['jumlah_anak']; ?></td>
        </tr>
        <?php
        ++$no;
      endforeach;
    ?>
  </tbody> 
</table>
<script type="text/javascript">
	$(document).ready(function () {
		var lap_Resv = $('#OwnerTablesReservasi').DataTable({
      "columnDefs": [ {
        "targets": [2, 4],
        "visible" : false,
        "searchable": true
      } ],
      'language': {
        'emptyTable':
        <?php
      	if (!empty($tglrsvcn) AND !empty($tglrsvct)) :
      		if(($_SESSION['compar'] === 'A') AND ($tglrsvcn === $tglrsvct) AND (count($sql) <= 0)): ?>
        		'<div class="text-center text-muted text-wrap">Tidak menemukan data checkin & checkout pada tanggal <b><?=tgl_indo($tglrsvcn) ?></b>.</div>'
        	<?php else: ?>
        		'<div class="text-center text-muted text-wrap">Tidak menemukan data checkin & checkout dari tanggal <b><?=tgl_indo($tglrsvcn) ?></b> sampai <b><?=tgl_indo($tglrsvct) ?></b>.</div>'
        	<?php endif; ?>
      	<?php endif; ?>
      	<?php 
      	if (!empty($periode_awal) AND !empty($periode_akhir)) :
      		if(($_SESSION['compar'] === 'B') AND ($periode_awal === $periode_akhir) AND (count($sql) <= 0)): ?>
        		'<div class="text-center text-muted text-wrap">Tidak ada hasil pada tanggal <b><?=tgl_indo($periode_awal) ?></b>.</div>'
        	<?php else: ?>
        		'<div class="text-center text-muted text-wrap">Tidak ada hasil pada periode <b><?=tgl_indo($periode_awal) ?></b> sampai <b><?=tgl_indo($periode_akhir) ?></b>.</div>'
        	<?php endif; ?>
      	<?php endif; ?>
      	<?php 
      	if (empty($periode_awal) AND empty($periode_akhir) AND empty($tglrsvcn) AND empty($tglrsvct)):
      		if($_SESSION['compar'] === 'C'): ?>
        		'<div class="text-center text-muted text-wrap">Tidak ada data untuk ditampilkan.</div>'
        	<?php endif; ?>
      	<?php endif; ?>
      },
      'columns': [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null
      ],
      "processing": true,
      "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
      responsive: true,
      "pagingType": "full_numbers",
      "order": [],
      "bPaginate": true,
      "bLengthChange": false,
      "bFilter": false,
      "bInfo": true,
    });
    if ( ! lap_Resv.data().any() ) {
      $('#btnPrintResv').fadeOut();
    }else{
      $('#btnPrintResv').fadeIn();
    };
	});
</script>