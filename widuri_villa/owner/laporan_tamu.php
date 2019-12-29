<?php 
  session_start();
  date_default_timezone_set('Asia/Singapore');
  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }
  elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "admin") ) {
    header('location: ../admin/index.php');
    exit;
  }
  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
  require '../koneksi/function_global.php';
  $data_tamu = query("SELECT * FROM tbl_tamu WHERE date_sub(now(), interval 5 day) <= `date_create` ORDER BY nama_tamu ASC");
  include '../query/queryDataDiri_pengguna.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan Tamu</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/jquery-ui.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="bungkus">
    <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
        <div class="navbar-header d-flex justify-content-center mt-1 mb-4">
          <a class="navbar-brand "><img src="../assets/images/logo.png" width="79.5" height="60" alt="Logo">
          </a>
          <a class="navbar-brand hidden" href=""><img src="../assets/images/logo-w.png" alt="Logo"></a>
        </div>
        <div id="main-menu" class="main-menu">
          <ul class="nav navbar-nav">
            <li>
              <a href="../index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-globe"></i></div>Kunjungi website</a>
            </li>
            <li>
              <a href="index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div>Dashboard</a>
            </li>
            <h3 class="menu-title">LAPORAN</h3>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Laporan Tamu</a>
            </li>
            <li>
              <a href="laporan_Reservasi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-luggage-cart"></i></div>Laporan Reservasi</a>
            </li>
            <li>
              <a href="laporan_transaksi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div>Laporan Transaksi</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
    <div id="right-panel" class="right-panel">
      <!-- HEADER -->
      <?php include '../header/headerOwner.php'; ?>
      <!-- /HEADER -->
      <div class="breadcrumbs shadow-sm">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Laporan Tamu</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
              <ol class="breadcrumb text-right">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Lap. Tamu</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm">
          <div class="row">
            <div class="d-flex flex-wrap">
              <div class="pl-3 pr-0 mb-2 selectCari_tamu">
                <select class="selectpicker show-tick form-control form-control-sm shadow-sm" data-style="btn-primary" title="CARI TAMU" data-width="fit" id="selectLaporanTamu" data-actions-box="true">
                  <option value="digunakan">Sedang menggunakan kamar</option>
                  <option value="tidak_memesan">Tidak memesan kamar</option>
                  <option data-divider="true"></option>
                  <option value="rentang">Rentang tanggal checkout</option>
                </select>
              </div>
              <!-- tmbl print laporan -->
              <div id="btn-PrintLapTam" class="pr-1 pl-3"><a href="print_laptamu.php" target="_blank" class="btn btn-secondary btn-sm rounded shadow-sm">PRINT&nbsp;&nbsp;<i class="fas fa-external-link-alt"></i></a></div>
              <div id="btn-PrintRntg" class="pr-1 pl-3"><a href="print_laptamu2.php" target="_blank" class="btn btn-secondary btn-sm rounded shadow-sm">PRINT&nbsp;&nbsp;<i class="fas fa-external-link-alt"></i></a></div>
              <div id="btn-PrintDtTamuSaatIni" class="pr-1 pl-3"><a href="print_laptamu.php" target="_blank" class="btn btn-secondary btn-sm rounded shadow-sm">PRINT&nbsp;&nbsp;<i class="fas fa-external-link-alt"></i></a></div>
            </div>
          </div>
          <div class="table-responsive p-1" id="loadhasilCariLaporanTamu">
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
          </div>
        </div>    
      </div>
      <?php include '../footer/footer.html'; ?>
      <?php include '../owner/modal_ubah_password.php'; ?>
      <?php include '../owner/modalUbah_DataDiriOwner.php'; ?>
    </div>
  </div>
  <div class="modal" id="rntg_khusus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content shadow border-light">
        <div class="modal-header">
          <h6 class="modal-title">Tanggal tamu yang sudah chekout</h6>
          <button type="button" class="close cls-popup" data-dismiss="modal" aria-label="Close" onClick="history.go(0);">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label for="awal_checkout" class="col-lg-3 col-form-label">Dari</label>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="awal_checkout" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label for="akhir_checkout" class="col-lg-3 col-form-label">Sampai</label>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="akhir_checkout" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="modal-footer py-1">
          <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" id="submitRntg">MULAI</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../assets/js/datepicker-id.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/responsive.bootstrap4.min.js"></script>
  <script type="text/javascript" src='../assets/js/sweetalert2.min.js'></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    var laporan_tamu = $('#OwnerLaporanTamu').DataTable({
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
      "lengthMenu": [[6, 10, 25, 50, -1], [6, 10, 25, 50, "All"]],
      responsive: true,
      "order": [],
      "bPaginate": true,
      "bLengthChange": false,
      "bFilter": false,
      "bInfo": true,
    });
    if ( ! laporan_tamu.data().any() ) {
      $('#btn-PrintDtTamuSaatIni').fadeOut();
    }else{
      $('#btn-PrintDtTamuSaatIni').fadeIn();
    }
    // ajax select
    $('#selectLaporanTamu').on('change', function () {
      if ($(this).val() === 'rentang') {
        $('#rntg_khusus').modal({'backdrop': 'static', 'keyboard': false});
      }
      $.ajax({
        type: 'POST',
        data: {laporanTamuSelect : $('#selectLaporanTamu').val()},
        url: '../url_ajax/data_LaporanTamu.php',
        success: function () {
          $('#loadhasilCariLaporanTamu').load('../url_ajax/output_LaporanTamu.php');
          if ($('#selectLaporanTamu').val() !== 'rentang') {
            $('#btn-PrintRntg').fadeOut();
            $('#btn-PrintDtTamuSaatIni').fadeOut();
          }else{
            $('#btn-PrintLapTam').fadeOut();
          }
        }
      })
      $('#btn-PrintRntg').fadeOut();
    });
    // ajax submit
    $('#submitRntg').on('click', function () {
      $('#rntg_khusus').modal('hide');
      $.ajax({
        type: 'POST',
        data: {tgl_awal : $('#awal_checkout').val(), tgl_akhir : $('#akhir_checkout').val()},
        url: '../url_ajax/data_RntgLaporanTamu.php',
        success: function () {
          $('#loadhasilCariLaporanTamu').load('../url_ajax/output_RntgLaporanTamu.php');
          clearSelect();
          $('#btn-PrintDtTamuSaatIni').fadeOut();
          $('#btn-PrintLapTam').fadeOut();
        }
      })
    });
    $('#btn-PrintDtTamuSaatIni').on('click', function () {
      <?php unset($_SESSION['LaporanTamu']); ?>
    });
    $('#awal_checkout').datepicker({
      maxDate: '0',
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    });
    $('#akhir_checkout').datepicker({
      maxDate: '0',
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    });
    $('#rntg_khusus').on('hidden.bs.modal', function () {
      clearSelect();
    });
    function clearSelect() {
      $('#selectLaporanTamu').val('zzz');
    };
    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });
  </script>
  <?php
    if( isset($_POST["submit_ubah_password"]) ) {
      if( ubah_pass_pengguna($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Password berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'laporan_tamu.php';
            });
          </script>
        ";
      }
    }
    if ( isset($_POST["submitUbahDataDiri_Pengguna"]) ) {
      if(UbahDataDiri_Pengguna($_POST) > 0){
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Profile Anda berhasil diubah.',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'laporan_tamu.php';             
            });
          </script>
        ";
      }else{
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Profile Anda gagal diubah!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'laporan_tamu.php';             
            });
          </script>
        ";
      }
    }
  ?>
</body>
</html>