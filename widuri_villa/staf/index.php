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

  require '../koneksi/function_global.php';

  include '../query/queryDataDiri_pengguna.php';

  $hitungJmlTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu");
  $OutputTamu = mysqli_num_rows($hitungJmlTamu);

  $hitungJmlKamar = mysqli_query($conn, "SELECT sum(jumlah_kamar) AS sisaKamar FROM tbl_tipe_kamar");
  $jmlKamar = mysqli_fetch_assoc($hitungJmlKamar);
  $OutputKamar = $jmlKamar["sisaKamar"];

  $hitungJmlReservasi = mysqli_query($conn, "SELECT * FROM tbl_reservasi");
  $Outputreservasi = mysqli_num_rows($hitungJmlReservasi);

  $hitung
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
  <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link rel="stylesheet" href="../assets-2/css/Chart.min.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
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
              <a href="../index.php"> <i class="menu-icon fas fa-globe"></i>Kunjungi website</a>
            </li>
            <li class="active">
              <a href=""> <i class="menu-icon fas fa-tachometer-alt"></i>Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3><!-- /.menu-title -->
            <li>
              <a href="tabel_tamu.php"> <i class="menu-icon fas fa-address-card"></i>Data Tamu</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"> <i class="menu-icon fas fa-home"></i>Data Tipe Kamar</a>
            </li>
            <li>
              <a href="tabel_reservasi.php"> <i class="menu-icon fas fa-calendar-check"></i>Reservasi</a>
            </li>
            <li>
              <a href="tabel_transaksi.php"> <i class="menu-icon fas fa-credit-card"></i>Transaski Pembayaran</a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
    </aside><!-- /#left-panel -->

    <div id="right-panel" class="right-panel">

      <!-- HEADER -->
      <?php include '../header/headerStaf.php'; ?>
      <!-- /HEADER -->

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
        <div class="col-sm-12 mb-4 px-0">
          <div class="card-group">
            <div class="card col-md-6 no-padding bg-flat-color-10 mr-lg-1 rounded shadow-sm dash-card" onclick="window.location.href='tabel_tamu.php'">
              <div class="card-body">
                <div class="h1 text-light text-right mb-4">
                  <i class="fa fa-users"></i>
                </div>
                <div class="h4 mb-0 text-light">
                  <span class="count"><?=$OutputTamu;?></span>
                </div>
                <small class="text-light text-uppercase font-weight-bold">Pengunjung</small>
                <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
              </div>
            </div>
            <div class="card col-md-6 no-padding bg-flat-color-8 mx-lg-1 rounded shadow-sm dash-card" onclick="window.location.href='tabel_tipeKamar.php'">
              <div class="card-body">
                <div class="h1 text-light text-right mb-4">
                  <i class="fas fa-home"></i>
                </div>
                <div class="h4 mb-0 text-light">
                  <span class="count"><?=$OutputKamar;?></span>
                </div>
                <small class="text-light text-uppercase font-weight-bold">Jumlah kamar terkini</small>
                <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
              </div>
            </div>
            <div class="card col-md-6 no-padding bg-flat-color-9 mx-lg-1 rounded shadow-sm dash-card" onclick="window.location.href='tabel_reservasi.php'">
              <div class="card-body">
                <div class="h1 text-light text-right mb-4">
                  <i class="fas fa-luggage-cart"></i>
                </div>
                <div class="h4 mb-0 text-light">
                  <span class="count"><?=$Outputreservasi;?></span>
                </div>
                <small class="text-light text-uppercase font-weight-bold">Total reservasi</small>
                <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
              </div>
            </div>
            <div class="card col-md-6 no-padding bg-flat-color-7 ml-lg-1 rounded shadow-sm dash-card">
              <div class="card-body">
                <div class="h1 text-light text-right mb-4">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="h4 mb-0 text-light">5:34:11</div>
                <small class="text-light text-uppercase font-weight-bold">Avg. Time</small>
                <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
              </div>
            </div>
          </div>
        </div>

        <!--/.col-->
        <div class="row mb-5">
          <div class="col-md-6 pr-xl-1">
            <div class="card">
              <div class="card-body shadow-sm">
                <div class="row">
                  <canvas id="chartResrvasi"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-xl-1">
            <div class="card">
              <div class="card-body shadow-sm">
                <div class="row">
                  <canvas id="chartTransaksi"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- .content -->
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
      <?php include '../footer/footer.html'; ?>
    </div>
  </div>
    
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type="text/javascript" src="../assets-2/js/Chart.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <?php include 'confirmLogout.php'; ?>
  <?php include 'chartJs/chart.php'; ?>
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
