<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
$id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
$emailnya = $_SESSION["loggedin_pengguna"]["email"];
$levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
require '../koneksi/function_global.php';
include '../query/queryDataDiri_pengguna.php';
$data_transaksi = mysqli_query($conn,"
SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
FROM tbl_transaksi_pembayaran
INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
WHERE (jam_transaksi BETWEEN '".$_SESSION['tgl_awalTrans']."' AND '".$_SESSION['tgl_akhirTrans']."' + INTERVAL 24 HOUR)
ORDER BY id_transaksi DESC
");
// Transaksi valid
$data_bayarVAL = mysqli_query($conn, "SELECT sum(total_pembayaran_kamar) AS total_bayar FROM tbl_transaksi_pembayaran WHERE jam_transaksi BETWEEN '".$_SESSION['tgl_awalTrans']."' AND '".$_SESSION['tgl_akhirTrans']."' + INTERVAL 24 HOUR AND status = 'VALID'");
$output_totalVAL = mysqli_fetch_assoc($data_bayarVAL);
// transaksi ditolak
$data_bayarGAK = mysqli_query($conn, "SELECT sum(total_pembayaran_kamar) AS total_bayar FROM tbl_transaksi_pembayaran WHERE jam_transaksi BETWEEN '".$_SESSION['tgl_awalTrans']."' AND '".$_SESSION['tgl_akhirTrans']."' + INTERVAL 24 HOUR AND status = 'GAK VALID'");
$output_totalGAK = mysqli_fetch_assoc($data_bayarGAK);
?>
<style type="text/css">
	div.dataTables_wrapper div.dataTables_filter label {
    font-weight: normal;
    white-space: nowrap;
    text-align: unset;
	}
</style>
<table id="StafTablesTransaksi" class="table rounded dt-responsive table-hover nowrap" width="100%">
  <thead class="thead-dark">
    <tr class="text-nowrap">
      <th>ID Trans</th>
      <th>Nama Tamu</th>
      <th>Total Bayar</th>
      <th>Tgl Transaksi</th>
      <th class="text-center">Jam</th>
      <th class="text-center">Qty. Kam</th>
      <th class="text-left">Bukti</th>
      <th class="text-center">Status</th>
      <th>Ket</th>
      <th>CheckIn</th>
      <th>Checkout</th>
      <th>Tipe Kamar</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach( $data_transaksi as $row ) : ?>
    <?php
      $timestamp = $row["jam_transaksi"];
      $datetime = explode(" ",$timestamp);
      $date = $datetime[0];
      $time = $datetime[1];
      $time12Hour = date_format(new Datetime($time), "h:i:s A");
    ?>
      <tr>
        <td>TRN-0<?=$row["id_transaksi"]; ?></td>
        <td class="text-wrap"><?= $row["nama_tamu"]; ?></td>
        <td>Rp.<?=number_format($row["total_pembayaran_kamar"],2,',','.'); ?>,-</td>
        <td><?=tgl_indo($date); ?></td>
        <td><?=$time12Hour; ?></td>
        <td class="text-center"><?= $row["jumlah_kamar"]; ?></td>
        <td class="p-1">
          <?php if($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === NULL OR 'GAK VALID' AND $row['foto_bukti_transaksi'] === NULL):?>
          <?php elseif($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === 'VALID'): ?>
            <div class="data_foto" style="opacity: .8;">
              <img src="../assets/images/payment.png" alt="">
            </div>
          <?php else : ?>
            <div class="data_foto" style="cursor: pointer;">
              <img src="../assets/foto_transaksi/<?php echo $row["foto_bukti_transaksi"] ?>" alt="" data-toggle="modal" data-target="#modalFoto_<?=$row["id_transaksi"];?>">
            </div>
          <?php endif; ?>
        </td>
        <td class="text-center p-1">
          <?php if($row["status"] === "VALID") : ?>
            <button type="button" class="btn btn-success rounded py-0 px-1"><i class="fas fa-check"></i> Diterima</button>
          <?php elseif($row["status"] === null) : ?>
            <button class="btn btn-outline-success rounded border-0" data-toggle="modal" data-target="#popUpReservasi_<?php echo $row["id_transaksi"] ?>"><i class="fas fa-check" style="font-size: 20px"></i></button>
            <button class="btn btn-outline-danger rounded border-0" data-toggle="modal" data-target="#popUpReservasiGakvalid_<?php echo $row["id_transaksi"] ?>"><i class="fas fa-times" style="font-size: 20px"></i></button>
          <?php elseif($row["status"] === "GAK VALID") : ?>
            <button type="button" class="btn btn-danger rounded py-0" style="padding-left: 6px; padding-right: 6px;"><i class="fas fa-times"></i> Ditolak</button>
          <?php endif; ?>
        </td>
        <td><?= $row["ket_transaksi"]; ?></td>
        <td><?php echo tgl_indo($row['tgl_checkin']); ?></td>
        <td><?php echo tgl_indo($row['tgl_checkout']); ?></td>
        <td><?= $row["tipe_kamar"]; ?></td>
      </tr>
      <?php include '../staf/modalFoto.php'; ?>
      <?php include '../staf/verifikasi_transaksi.php'; ?>
      <?php include '../staf/verifikasi_tidakValid.php'; ?>
      <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="d-flex flex-wrap px-0">
  <h6 class="text-muted py-2 text-nowrap font-weight-bold mr-2">
    <span class="border border-success d-flex align-items-center pr-1 rounded">
      <span class="btn btn-success mr-1 py-0 px-1" style="cursor: default;">
        <i class="fas fa-check"></i> Diterima
      </span> Rp.<?=number_format($output_totalVAL['total_bayar'],2,',','.'); ?>,-
    </span>
  </h6>
  <h6 class="text-muted py-2 text-nowrap font-weight-bold">
    <span class="border border-danger d-flex align-items-center pr-1 rounded">
      <span class="btn btn-danger mr-1 py-0 px-1" style="cursor: default;">
        <i class="fas fa-times"></i> Ditolak
      </span> Rp.<?=number_format($output_totalGAK['total_bayar'],2,',','.'); ?>,-
    </span>
  </h6>
</div>
<script type="text/javascript">
  $('#StafTablesTransaksi').DataTable({
    "pagingType": "full_numbers",
    'language': {
      'emptyTable': 'Tidak ada data Transaksi ☹'
    },
    'columns': [
      null,
      null,
      null,
      null,
      null,
      null,
      { "orderable": false },
      { "orderable": false },
      null,
      null,
      null,
      null
    ],
    "processing": true,
    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    responsive: true,
    "order": []
  });
</script>