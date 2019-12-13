<?php 
session_start();
require '../koneksi/function_global.php';
$tgl_awal = $_SESSION['tglawalCheckout'];
$tgl_akhir = $_SESSION['tglakhirCheckout'];
$data_tamuRntg = mysqli_query($conn, "SELECT tbl_tamu.*, tbl_reservasi.*, tbl_transaksi_pembayaran.*
FROM tbl_transaksi_pembayaran
INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
WHERE tgl_checkout BETWEEN DATE('".$tgl_awal."') AND DATE('".$tgl_akhir."') AND `status` = 'VALID' GROUP BY tbl_tamu.email_tamu");
?>
<table id="OwnerLaporanTamu" class="table rounded dt-responsive table-hover nowrap" width="100%">
  <thead class="thead-dark">
    <tr class="text-nowrap">
      <th>#</th>
      <th>Foto</th>
      <th>Nama Tamu</th>
      <th>Tgl Lahir</th>
      <th>Email</th>
      <th>No Telp</th>
      <th>Alamat</th>
      <th>JK</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach( $data_tamuRntg as $row ) : ?>
      <tr class="text-nowrap">
        <td><?=$i;?></td>
        <td class="p-1"><div class="data_foto"><img src="../assets/foto_tamu/<?php echo $row["foto_tamu"] ?>" alt=""></div></td>
        <td><?= $row["nama_tamu"]; ?></td>
        <td><?= date_format(new Datetime($row["tgl_lahir_tamu"]), "d F Y"); ?></td>
        <td><?= $row["email_tamu"]; ?></td>
        <td><?= $row["no_telp_tamu"]; ?></td>
        <td><?= $row["alamat_tamu"]; ?></td>
        <td><?= $row["jk_tamu"]; ?></td>
      </tr>
      <?php $i++; ?>
    <?php endforeach; ?>
  </tbody> 
</table>
<script>
  $('#OwnerLaporanTamu').DataTable({
    'language': {
      'emptyTable':
      <?php if (empty($tgl_awal && $tgl_akhir)): ?>
        '<p class=text-muted>Tidak ada tamu chekout hari ini</p>'
      <?php elseif ($tgl_awal === $tgl_akhir): ?>
        '<p class=text-muted>Tidak ada tamu chekout pada tanggal <?=tgl_indo($tgl_awal) ?></p>'
      <?php else: ?>
        '<p class=text-muted>Tidak ada tamu ckeout pada tanggal <?=tgl_indo($tgl_awal) ?> sampai <?=tgl_indo($tgl_akhir) ?></p>'
      <?php endif ?>
    },
    'columns': [
      null,
      { "orderable": false },
      null,
      null,
      null,
      null,
      null,
      null
    ],
    "processing": true,
    "pagingType": "full_numbers",
    "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
    responsive: true,
    "order": []
  });
  $('#menuToggle').click(function() {
    $('.menu-admin').toggleClass('hide');
  });
</script>