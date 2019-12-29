<?php
  session_start();
  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }
  elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "admin") ) {
    header('location: ../admin/index.php');
    exit;
  }
  date_default_timezone_set('Asia/Singapore');
  setlocale (LC_TIME, "IND");
  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
  require '../koneksi/function_global.php';
  include '../query/queryDataDiri_pengguna.php';
  $sql = query("SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*, tbl_pengguna.*
    FROM tbl_transaksi_pembayaran
    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    LEFT JOIN tbl_pengguna ON tbl_transaksi_pembayaran.id_pengguna = tbl_pengguna.id_pengguna
    WHERE CURDATE() <= tbl_reservasi.tgl_checkout AND tbl_transaksi_pembayaran.status = 'VALID'
    ORDER BY tbl_transaksi_pembayaran.id_reservasi DESC
  ");
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Reservasi</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.min.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel='stylesheet' type="text/css" href='../assets/css/jquery-ui.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
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
            <li>
              <a href="laporan_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Laporan Tamu</a>
            </li>
            <li class="active">
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
      <?php include '../header/headerOwner.php'; ?>
      <div class="breadcrumbs shadow-sm">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Laporan Reservasi</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="index.php">Dashboard</a></li>
                  <li class="active">Lap. Reservasi</li>
                </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm position-relative">
          <div class="row">
            <div class="col-12">
              <div class="col-sm-auto pl-1 pr-sm-2 selectCari_reservasi mb-2">
                <select class="selectpicker form-control form-control-sm show-tick" title="Data Reservasi Berdasarkan" data-width="fit" data-style="btn-primary" id="selectCari_reservasi">
                  <option value="cico">Tanggal checkin dan checkout</option>
                  <option value="periode">Periode Tanggal reservasi</option>
                  <option data-divider="true"></option>
                  <option value="ulang" style="color: red">Ulangi pilihan</option>
                </select>
              </div>
              <div class="col px-1" id="wrap-chek"> <!-- 1 -->
                <div class="col-sm-auto px-0">
                  <div class="input-group input-group-sm mb-2 cico">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                    </div>
                    <input id="tglci" type="text" class="form-control" placeholder="Checkin" autocomplete="off">
                  </div>
                </div>
                <div class="col-sm-auto mt-1 px-2 d-none d-lg-block">
                  <span>s/d</span>
                </div>
                <div class="col-sm-auto px-0">
                  <div class="input-group input-group-sm mb-2 cico">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-plane-departure"></i></span>
                    </div>
                    <input id="tglco" type="text" class="form-control" placeholder="Checkout" autocomplete="off">
                    <div class="input-group-append">
                      <button class="btn btn-primary px-3" type="button" id="btnSearch-cico" disabled title="Cari tanggal"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col px-1" id="wrap-prio"> <!-- 2 -->
                <div class="col-sm-auto px-0">
                  <div class="input-group input-group-sm mb-2 prio">
                    <input id="periode-awal" type="text" class="form-control" placeholder="Periode awal" autocomplete="off">
                  </div>
                </div>
                <div class="col-sm-auto mt-1 px-2 d-none d-lg-block">
                  <span>s/d</span>
                </div>
                <div class="col-sm-auto px-0">
                  <div class="input-group input-group-sm mb-2 prio">
                    <input id="periode-akhir" type="text" class="form-control" placeholder="Periode akhir" autocomplete="off">
                    <div class="input-group-append">
                      <button class="btn btn-primary px-3" type="button" id="btnSearch-prio" disabled title="Cari tanggal"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-auto px-1 ml-sm-1" id="btnPrintResv">
                <a href="print_lapreservasi.php" target="_blank" class="btn btn-secondary btn-sm shadow-sm rounded px-3">PRINT&nbsp;&nbsp;<i class="fas fa-external-link-alt"></i></a>
              </div>
            </div>
          </div>
          <div class="table-responsive py-1 px-1" id="load_HasilCari">
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
                    foreach ($sql as $row) :
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
          </div>
        </div>    
      </div>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriOwner.php'; ?>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../assets/js/datepicker-id.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/responsive.bootstrap4.min.js"></script>
  <script type="text/javascript" src='../assets/js/sweetalert2.min.js'></script>
  <script type="text/javascript" src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.min.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    $(document).ready(function () {
      var lap_Resv = $('#OwnerTablesReservasi').DataTable({
        "columnDefs": [ {
          "targets": [2, 4],
          "visible" : false,
          "searchable": true
        } ],
        'language': {
          'emptyTable': '<div class="text-center text-muted text-wrap">Tidak ada hasil untuk ditampilkan.</div>'
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
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
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
      $('#menuToggle').click(function() {
        $('.menu-admin').toggleClass('hide');
      });
      // select
      var wrap1 = $('#wrap-chek'), wrap2 = $('#wrap-prio');
      $('#selectCari_reservasi').on('change', function () {
        if ($('#selectCari_reservasi').val() === 'cico') {
          wrap2.fadeOut(function () {
            wrap1.fadeIn();
          });
          $('#btnPrintResv').fadeOut();
        }
        else if($('#selectCari_reservasi').val() === 'periode'){
          wrap1.fadeOut(function () {
            wrap2.fadeIn();
          });
          $('#btnPrintResv').fadeOut();
        }
        else{
          $('#selectCari_reservasi').val('default');
          $('#selectCari_reservasi').selectpicker("refresh");
          wrap1.fadeOut();
          wrap2.fadeOut();
          <?php unset($_SESSION['periode_awal'], $_SESSION['periode_akhir'], $_SESSION['tglrsvcn'], $_SESSION['tglrsvct']); ?>
          $.ajax({
            type: 'POST',
            data: {default : $('#selectCari_reservasi').val()},
            url: '../url_ajax/data_LaporanReservasi.php',
            success : function () {
              $('#load_HasilCari').load('../url_ajax/output_LaporanReservasi.php');
            }
          });
        }
      });
      // ----------------------------------- ajax
      $('#btnSearch-cico').on('click', function () {
        $.ajax({
          type: 'POST',
          data: {tglci : $('#tglci').val(), tglco : $('#tglco').val()},
          url: '../url_ajax/data_LaporanReservasi.php',
          success : function () {
            $('#load_HasilCari').load('../url_ajax/output_LaporanReservasi.php');
          }
        });
      });
      $('#btnSearch-prio').on('click', function () {
        $.ajax({
          type: 'POST',
          data: {periode_awal : $('#periode-awal').val(), periode_akhir : $('#periode-akhir').val()},
          url: '../url_ajax/data_LaporanReservasi.php',
          success : function () {
            $('#load_HasilCari').load('../url_ajax/output_LaporanReservasi.php');
          }
        });
      });
      // unset session
      $('#btnSearch-cico').on('click', function () {
        <?php unset($_SESSION['tglprioaw'], $_SESSION['tglprioak']); ?>
      });
      $('#btnSearch-prio').on('click', function () {
        <?php unset($_SESSION['tglrsvcn'], $_SESSION['tglrsvct']); ?>
      });
      // datepicker
      $('#tglci').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
      });
      $('#tglco').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
      });
      $('#periode-awal').datepicker({
        maxDate: '0',
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
      });
      $('#periode-akhir').datepicker({
        maxDate: '0',
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
      });
      // cari cico
      $('.cico input').on('change',function() {
        var empty = false;
        $('.cico input').each(function() {
          if ($(this).val().length == 0) {
            empty = true;
          }
        });
        if (empty) {
          $('#btnSearch-cico').prop('disabled', true);
        } else {
          $('#btnSearch-cico').prop('disabled', false);
        }
      });
      // cari perio
      $('.prio input').on('change',function() {
        var empty = false;
        $('.prio input').each(function() {
          if ($(this).val().length == 0) {
            empty = true;
          }
        });
        if (empty) {
          $('#btnSearch-prio').prop('disabled', true);
        } else {
          $('#btnSearch-prio').prop('disabled', false);
        }
      });
    });
  </script>
  <?php
    // UBAH PASSOWRD
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
              window.location.href = 'laporan_Reservasi.php';
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
              window.location.href = 'laporan_Reservasi.php';             
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
              window.location.href = 'laporan_Reservasi.php';             
            });
          </script>
        ";
      }
    }
  ?>
</body>
</html>