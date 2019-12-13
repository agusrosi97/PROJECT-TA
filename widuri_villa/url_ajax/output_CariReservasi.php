<?php
// BELUM IF JIKA KOSONG
session_start();
date_default_timezone_set('Asia/Singapore');
$id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
$emailnya = $_SESSION["loggedin_pengguna"]["email"];
$levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
require '../koneksi/function_global.php';
$input = "SELECT * FROM tbl_tamu";
$hasil = mysqli_query($conn, $input);
$queKamar = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE jumlah_kamar > 0");
include '../query/queryDataDiri_pengguna.php';
?>
<style type="text/css">
	div.dataTables_wrapper div.dataTables_filter label {
    font-weight: normal;
    white-space: nowrap;
    text-align: unset;
	}
</style>
<table id="StafTablesReservasi" class="table rounded dt-responsive table-hover nowrap" width="100%">
  <thead class="thead-dark">
    <tr class="text-nowrap text-center">
      <th>Id Res</th>
      <th>Nama Tamu</th>
      <th>Status</th>
      <th>Nama staf</th>
      <th>Checkin</th>
      <th>Checkout</th>
      <th>J. Hari</th>
      <th>Tipe Kamar</th>
      <th>Qty. Kam</th>
      <th>Aksi</th>
      <th>J. Dewasa</th>
      <th>J. Anak</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $sql = query("SELECT tbl_reservasi.*, tbl_tamu.*, tbl_pengguna.*
        FROM tbl_reservasi
        LEFT JOIN tbl_pengguna ON tbl_reservasi.id_pengguna = tbl_pengguna.id_pengguna
        LEFT JOIN tbl_tamu ON tbl_reservasi.id_tamu = tbl_tamu.id_tamu
        WHERE tgl_checkin >= '".$_SESSION['tgl_awalRes']."' AND tgl_checkout <= '".$_SESSION['tgl_akhirRes']."'
        ORDER BY id_reservasi DESC
      ");
      $no=1;
        foreach ($sql as $row) {
          $jam_reservasi = date_format(new Datetime($row["jam_reservasi"]), "Y-m-d");
        ?>
        <tr class="text-nowrap text-center">
          <td>RSV-0<?php echo $row['id_reservasi']; ?></td>
          <td><?php echo $row['nama_tamu']; ?></td>
          <td class="text-center">
            <?php include '../staf/statusReservasi.php'; ?>
          </td>
          <td><?php echo $row["username_pengguna"]; ?></td>
          <td class="text-nowrap"><?php echo tgl_indo($row['tgl_checkin']); ?></td>
          <td class="text-nowrap"><?php echo tgl_indo($row['tgl_checkout']); ?></td>
          <td><?php echo $row['jumlah_hari']; ?></td>
          <td><?=$row['tipe_kamar'];?></td>
          <td><?=$row['jumlah_kamar_perPilihan'];?></td>
          <td class="text-nowrap p-1" align="center">
            <?php if($statusRes === "GAK VALID" OR date("Y-m-d") > $row['tgl_checkout']) : ?>
              <button style="cursor: not-allowed;" disabled class='btn btn-primary px-2 py-1 rounded' ><span><i class='fas fa-edit'></i></span></button>
            <?php else : ?>
              <div class="px-1 py-0 rounded" data-toggle="popover" title="PERHATIAN!" data-content="Dengan menekan tombol <span class='btn btn-primary py-0 px-1 rounded'><i class='fas fa-edit'></i></span>, maka jumlah kamar akan kembali sesuai dengan data terpilih, atau bahkan bisa berkurang!" tabindex="0" data-trigger="focus hover">
                <form method="POST" action="">
                  <input type="hidden" name="id_reservasi" value="<?=$row['id_reservasi'] ?>">
                  <input type="hidden" name="id_kamar" value="<?=$row['tipe_kamar'] ?>">
                  <input type="hidden" name="jumlahKamarTerpilih" value="<?=$row['jumlah_kamar_perPilihan'] ?>">
                  <button type="submit" name="tabelEditKamar_<?=$no?>" class='btn btn-primary px-2 py-1 rounded' ><span><i class='fas fa-edit'></i></span>
                  </button>
                </form>
                <?php
                  if(isset($_POST["tabelEditKamar_".$no.""])) {
                    if (UbahReservasi($_POST) >= 0) {
                      echo "
                      <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
                      <script type='text/javascript' src='../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js'></script>
                      <script>
                        $(window).on('load', function(){
                          $('#popupUbah_Reservasi_".$row['id_reservasi']."').modal({backdrop: 'static', keyboard: false});
                        });
                      </script>";
                    }
                  }
                ?>
              </div>
            <?php endif; ?>
          </td>
          <td><?php echo $row['jumlah_orang']; ?></td>
          <td><?php echo $row['jumlah_anak']; ?></td>
        </tr>
        <?php
        $no++;
        include '../staf/modal_Ubah_PilihKamar.php';
      }
    ?>
  </tbody> 
</table>
<script type="text/javascript">
	$('#StafTablesReservasi').DataTable({
    "columnDefs": [ {
      "targets": 3,
      "visible" : false,
      "searchable": true
    } ],
    'language': {
      'emptyTable': 'Tidak ada data Reservasi ☹'
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
      { 'orderable': false },
      null,
      { 'orderable': false }
    ],
    "processing": true,
    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    responsive: true,
    "pagingType": "full_numbers",
    "order": []
  });
	$('[data-toggle="popover"]').popover({
	  html: true,
	  trigger: 'focus hover'
	});
</script>