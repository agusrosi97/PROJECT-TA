<?php 
session_start();
require '../koneksi/function_global.php';
$data_tamu = mysqli_query($conn, "".$_SESSION['LaporanTamu']."");
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
      'emptyTable': 'Belum ada tamu mendaftar dalam lima hari terakhir'
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