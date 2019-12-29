<?php 
  session_start();
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
  date_default_timezone_set('Asia/Singapore');
  require '../koneksi/function_global.php';
  include '../query/queryDataDiri_pengguna.php';
  //== jmlTamu
  $hitungJmlTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu");
  $OutputTamu = mysqli_num_rows($hitungJmlTamu);
  //== jmlKamar
  $hitungJmlKamar = mysqli_query($conn, "SELECT sum(jumlah_kamar) AS sisaKamar FROM tbl_tipe_kamar");
  $jmlKamar = mysqli_fetch_assoc($hitungJmlKamar);
  $OutputKamar = $jmlKamar["sisaKamar"];
  //== jmlReservasi
  $hitungJmlReservasi = mysqli_query($conn, "SELECT * FROM tbl_reservasi");
  // SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
  //   FROM tbl_transaksi_pembayaran
  //   INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
  //   INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
  //   WHERE status = 'VALID'");
  $Outputreservasi = mysqli_num_rows($hitungJmlReservasi);
  //== PemesanTerbaru
  $cekPemesanTerbaru = mysqli_query($conn, "
    SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
    FROM tbl_transaksi_pembayaran
    INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    WHERE jumlah_kamar >= '1'
    ORDER BY id_transaksi DESC LIMIT 10");
  $jmlPemesanTerbaru = mysqli_num_rows($cekPemesanTerbaru);
  //== jmlTransaksi
  $cekTransaksi = mysqli_query($conn, "SELECT sum(total_pembayaran_kamar) AS total_bayar FROM tbl_transaksi_pembayaran WHERE status = 'VALID'");
  $hasilTransaksi = mysqli_fetch_assoc($cekTransaksi);
  $earliest_year = 2017;
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome <?php echo $namanya; ?></title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.min.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/Chart.min.css">
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
          <a class="navbar-brand hidden" href="./"><img src="../assets/images/logo-w.png" alt="Logo"></a>
        </div>
        <div id="main-menu" class="main-menu">
          <ul class="nav navbar-nav">
            <li>
              <a href="../index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-globe"></i></div> Kunjungi website</a>
            </li>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div> Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3>
            <li>
              <a href="tabel_reservasi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-calendar-check"></i></div> Reservasi</a>
            </li>
            <li>
              <a href="tabel_transaksi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div> Transaski Pembayaran</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-home"></i></div> Data Tipe Kamar</a>
            </li>
            <li>
              <a href="tabel_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div> Data Tamu</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
    <div id="right-panel" class="right-panel">
      <?php include '../header/headerStaf.php'; ?>
      <div class="breadcrumbs shadow-sm">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Dashboard</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
              <ol class="breadcrumb text-right">
                <li class="active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content mt-1">
        <div class="row px-2">
          <div class="col-sm-12 mb-2">
            <div class="card-group">
              <div class="card col-md-6 no-padding border-0 mb-2 bg-flat-color-10 mr-lg-1 rounded shadow-sm dash-card tam">
                <select id="selectTamu" class="selectpicker form-control show-tick sel rounded position-absolute" title="Pilih waktu" data-width="fit">
                  <option value="day">24 jam terakhir</option>
                  <option value="week">Seminggu terakhir</option>
                  <option value="month">Sebulan terakhir</option>
                  <option value="year">Setahun terakhir</option>
                </select>
                <div class="card-body" onclick="window.location.href='tabel_tamu.php'">
                  <div class="h1 text-light text-right mb-4">
                    <i class="fa fa-users"></i>
                  </div>
                  <div id="tampilHasilTamu">
                    <div class="h4 mb-0 text-light">
                      <span class="count"><?=$OutputTamu;?></span>
                    </div>
                    <small class="text-light text-uppercase font-weight-bold">Total tamu terdaftar</small>
                  </div>
                  <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
                </div>
              </div>
              <div class="card col-md-6 no-padding border-0 mb-2 bg-flat-color-7 mx-lg-1 rounded shadow-sm dash-card" onclick="window.location.href='tabel_tipeKamar.php'">
                <div class="card-body">
                  <div class="h1 text-light text-right mb-4">
                    <i class="fas fa-home"></i>
                  </div>
                  <div class="h4 mb-0 text-light">
                    <span class="count"><?=$OutputKamar;?></span>
                  </div>
                  <small class="text-light text-uppercase font-weight-bold">Jumlah kamar saat ini</small>
                  <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
                </div>
              </div>
              <div class="card col-md-6 no-padding border-0 mb-2 bg-flat-color-8 mx-lg-1 rounded shadow-sm dash-card resv">
                <select id="selectResv" class="selectpicker form-control show-tick sel rounded position-absolute" title="Pilih waktu" data-width="fit">
                  <option value="day">24 jam terakhir</option>
                  <option value="week">Seminggu terakhir</option>
                  <option value="month">Sebulan terakhir</option>
                  <option value="year">Setahun terakhir</option>
                </select>
                <div class="card-body" onclick="window.location.href='tabel_reservasi.php'">
                  <div class="h1 text-light text-right mb-4">
                    <i class="fas fa-concierge-bell"></i>
                  </div>
                  <div id="tampilHasilResv">
                    <div class="h4 mb-0 text-light">
                      <span class="count"><?=$Outputreservasi;?></span>
                    </div>
                    <small class="text-light text-uppercase font-weight-bold">Total reservasi</small>
                  </div>
                  <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
                </div>
              </div>
              <div class="card col-md-6 no-padding border-0 mb-2 bg-flat-color-9 ml-lg-1 rounded shadow-sm dash-card trans">
                <select id="selectTrans" class="selectpicker form-control show-tick sel rounded position-absolute" title="Pilih waktu" data-width="fit">
                  <option value="day">24 jam terakhir</option>
                  <option value="week">Seminggu terakhir</option>
                  <option value="month">Sebulan terakhir</option>
                  <option value="year">Setahun terakhir</option>
                </select>
                <div class="card-body" onclick="window.location.href='tabel_transaksi.php'">
                  <div class="h1 text-light text-right mb-4">
                    <i class="fas fa-cash-register"></i>
                  </div>
                  <div id="tampilHasilTrans" >
                    <div class="h4 mb-0 text-light">
                      <span class="">Rp.<?= number_format($hasilTransaksi['total_bayar'],2,',','.');?>,-</span>
                    </div>
                    <small class="text-light text-uppercase font-weight-bold">Total Transaksi</small>
                  </div>
                  <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content mb-4">
        <div class="row mb-4 px-2">
          <div class="col-lg-6 pr-lg-1">
            <div class="card shadow rounded border-light mb-3">
              <div class="card-header shadow-sm text-secondary bg-white">Pemesanan Terakhir</div>
              <div class="card-body pt-1" style="overflow-y: auto; height: 235px">
                <?php if(mysqli_num_rows($cekPemesanTerbaru) > 0) : ?>
                  <?php while($hasilPemesanTerbaru = mysqli_fetch_assoc($cekPemesanTerbaru)) : ?>
                    <div class="col-md-12 py-1 px-0">
                      <div class="row">
                        <div class="col-2 pr-0 AutoHilang" role="button" data-toggle="popover" data-content="<i class='fas fa-plane-arrival'></i> : <?=$hasilPemesanTerbaru['tgl_checkin'] ?></br><i class='fas fa-plane-departure'></i> : <?=$hasilPemesanTerbaru['tgl_checkout'] ?>" style="cursor: help;">
                          <div class="data_foto2 rounded-circle" style="box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                            <?php if($hasilPemesanTerbaru['foto_tamu'] === '') :?>
                              <img src="../assets/images/user.png" class="img-fluid" alt="">
                            <?php else : ?>
                              <img src="../assets/foto_tamu/<?php echo $hasilPemesanTerbaru['foto_tamu'] ?>" alt="" class="img-fluid">
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="col-10 px-sm-2 AotuLebar">
                          <div class="d-flex justify-content-between" style="height: 33px !important; padding-top: 3px">
                            <span class="text-wrap pl-0 font-weight-bold text-dark"><?=$hasilPemesanTerbaru['nama_tamu'] ?></span>
                            <p class="text-muted text-nowrap" style="font-size: 13px"><?=time_elapsed_string($hasilPemesanTerbaru['jam_reservasi']); ?></p>
                          </div>
                          <div id="scrool" class="d-flex text-nowrap" style="width: 100% !important; overflow-x: auto;">
                            <div class="pl-0 text-muted ">
                              <i class="fas fa-map-marker-alt"></i> <?=ucwords($hasilPemesanTerbaru['alamat_tamu']); ?>&nbsp;|
                            </div>
                            <div class="pl-2 text-muted">
                              <i class="fas fa-clock"></i> <?=$hasilPemesanTerbaru['jumlah_hari'] ?> Hari&nbsp;|
                            </div>
                            <div class="pl-2 text-muted">
                              <?php if($hasilPemesanTerbaru['jumlah_orang'] === '1') : ?><i class="fas fa-user"></i>
                              <?php elseif($hasilPemesanTerbaru['jumlah_orang'] > '1') : ?><i class="fas fa-users"></i>
                            <?php endif; ?> <?=$hasilPemesanTerbaru['jumlah_orang'] ?> Orang
                            </div>&nbsp;|
                            <div class="pl-2 text-muted">
                              <i class="fas fa-home"></i> <?=$hasilPemesanTerbaru['jumlah_kamar'] ?> Kamar
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="my-1 mb-1">
                    </div>
                  <?php endwhile; ?>
                  <?php else : ?>
                  <div class="d-flex justify-content-center align-items-center h-100 w-100">
                    <p>Belum ada pemesan, harap menunggu</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-6 pl-lg-1">
            <div class="card border-0 mb-3">
              <div class="card-body rounded border-light shadow">
                <div class="row">
                  <canvas id="chartResrvasi"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 pr-lg-1">
            <div class="card grafiktrans rounded shadow border-0">
              <select class="selectpicker form-control col-5 p-2" id="selectGrafikTrans" title="Pilih tahun">
                <?php foreach (range(date('Y'), $earliest_year) as $x) {
                  echo "<option value='".$x."'>".$x."</option>";
                } ?>
              </select>
              <div class="card-body shadow-sm pt-0" id="loadGrafikTrans">
                <div class="row">
                  <canvas id="chartTrans" width="600" height="260"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
      <?php include '../footer/footer.html'; ?>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/Chart.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <?php include '../chartJS/chart.php'; ?>
  <?php include 'confirmLogout.php'; ?>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#selectTrans').on('change', function () {
        $.ajax({
          type: 'POST',
          url: '../url_ajax/data_transaksi.php',
          data: {getValueTrans : $('#selectTrans').val()},
          success: function () {
            $('#tampilHasilTrans').load('../url_ajax/output_DataTransaksi.php');
          }
        })
      });
      $('#selectResv').on('change', function () {
        $.ajax({
          type: 'POST',
          url: '../url_ajax/data_reservasi.php',
          data: {getValueResv : $('#selectResv').val()},
          success: function () {
            $('#tampilHasilResv').load('../url_ajax/output_DataReservasi.php');
          }
        })
      });
      $('#selectTamu').on('change', function () {
        $.ajax({
          type: 'POST',
          url: '../url_ajax/data_tamu.php',
          data: {getValueTam : $('#selectTamu').val()},
          success: function () {
            $('#tampilHasilTamu').load('../url_ajax/output_DataTamu.php');
          }
        })
      });
      $('#selectGrafikTrans').on('change', function () {
        $.ajax({
          type: 'POST',
          url: '../url_ajax/data_grafikTrans.php',
          data: {tahun : $('#selectGrafikTrans').val()},
          success: function () {
            $('#loadGrafikTrans').load('../url_ajax/output_GrafikTrans.php');
          }
        })
      });
    });
  </script>
  <?php 
  // BTN UBAH PASSWORD
    if( isset($_POST["submit_ubah_password"]) ) {
      if( ubah_pass_pengguna($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Password berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'index.php';             
            });
          </script>
        ";
      }
    }

    // UBAH PROFILE
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
              window.location.href = 'index.php';             
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
              window.location.href = 'index.php';             
            });
          </script>
        ";
      }
    }
  ?>
</body>
</html>