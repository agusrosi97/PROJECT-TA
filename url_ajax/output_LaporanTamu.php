<?php 
session_start();
date_default_timezone_set('Asia/Singapore');
require '../koneksi/function_global.php';
$data_tamu = query("".$_SESSION['LaporanTamu']."");
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
    <?php foreach( $data_tamu as $row ) : ?>
      <tr class="text-nowrap">
        <td><?=$i;?></td>
        <td class="p-1"><div class="data_foto"><img src="../assets/foto_tamu/<?=$row["foto_tamu"] ?>" alt=""></div></td>
        <td><?= $row["nama_tamu"]; ?></td>
        <td><?= tgl_indo2($row["tgl_lahir_tamu"]); ?></td>
        <td><?= $row["email_tamu"]; ?></td>
        <td><?= $row["no_telp_tamu"]; ?></td>
        <td><?= $row["alamat_tamu"]; ?></td>
        <td><?=$row['jk_tamu'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
      </tr>
      <?php $i++; ?>
    <?php endforeach; ?>
  </tbody> 
</table>
<script>
  var lap_tamu = $('#OwnerLaporanTamu').DataTable({
    'language': {
      'emptyTable': '<p class=text-muted>Tidak ada data tamu untuk ditampilkan.</p>'
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
    "lengthMenu": [[6, 10, 25, 50, -1], [6, 10, 25, 50, "All"]],
    responsive: true,
    "order": [],
    "bPaginate": true,
    "bLengthChange": false,
    "bFilter": false,
    "bInfo": true,
  });
  if ( ! lap_tamu.data().any() ) {
    $('#btn-PrintLapTam').fadeOut();
  }else{
    $('#btn-PrintLapTam').fadeIn();
  }
  $('#btn-PrintDtTamuSaatIni').fadeOut();
</script>