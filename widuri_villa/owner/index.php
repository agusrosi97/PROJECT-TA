<?php 
  session_start();

  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }  
  if ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "staf") ) {
    header('location: ../staf/index.php');
    exit;
  }elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "admin") ) {
    header('location: ../admin/index.php');
    exit;
  }

  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];

  require '../koneksi/function_global.php';

  include '../query/queryDataDiri_pengguna.php';

  $queryJmlTransaksi = mysqli_query($conn, "SELECT sum(total_pembayaran_kamar) FROM tbl_transaksi_pembayaran");
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
  <title>Welcome Owner</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" href="../vendors-2/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../vendors-2/themify-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors-2/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../vendors-2/selectFX/css/cs-skin-elastic.css">
  <link rel="stylesheet" href="../vendors-2/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
    
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
            <h3 class="menu-title">LAPORAN</h3>
            <li>
              <a href="laporan_tamu.php"> <i class="menu-icon fas fa-address-card"></i>Laporan Data Tamu</a>
            </li>
            <li>
              <a href="laporan_Reservasi.php"> <i class="menu-icon fas fa-luggage-cart"></i>Laporan Reservasi</a>
            </li>
            <li>
              <a href="laporan_transaksi.php"> <i class="menu-icon fas fa-credit-card"></i>Laporan Transaksi</a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
    </aside><!-- /#left-panel -->

    <div id="right-panel" class="right-panel">
      <!-- HEADER -->
      <?php include '../header/headerOwner.php'; ?>
      <!-- /HEADER -->

      <div class="breadcrumbs">
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

      <div class="content mt-3">
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-1">
              <div class="card-body pb-0">
                <div class="dropdown float-right">
                  <i class="fa fa-cog"></i>
                </div>
                <h4 class="mb-0">
                  <span class="count">25</span>
                </h4>
                <p class="text-light">Jumlah pengunjung</p>

                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                    
                </div>

              </div>

            </div>
          </div>
          <!--/.col-->

          <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-2">
              <div class="card-body pb-0">
                <div class="dropdown float-right">
                  <i class="fa fa-cog"></i>                            
                </div>
                <h4 class="mb-0">
                  <span class="count">
                    <?php 
                      while ($rows1 = mysqli_fetch_array($queryJmlTransaksi)){
                        echo "Rp.".number_format($rows1["sum(total_pembayaran_kamar)"],2,',','.').",-";
                      }
                    ?>
                  </span>
                </h4>
                <p class="text-light">Jumlah Pendapatan</p>

                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                    
                </div>
              </div>
            </div>
          </div>
          <!--/.col-->

          <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-3">
              <div class="card-body pb-0">
                <div class="dropdown float-right">
                 <i class="fa fa-cog"></i>
                </div>
                <h4 class="mb-0">
                  <span class="count">25</span>
                </h4>
                <p class="text-light">Jumlah reservasi</p>

              </div>

              <div class="chart-wrapper px-0" style="height:70px;" height="70">
                  
              </div>
            </div>
          </div>
        </div><!--/.col-->

        <!--/.col-->
        <!-- <div class="row">
          <div class="col-md-6 px-0">
            <form action="" method="POST">
              <div class="col-md-5">
                <div class="form-group">
                  <input type="date" class="form-control" name="tgl_awal">
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <input type="date" class="form-control" name="tgl_akhir">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary rounded shadow-sm">CARI</button>
                </div>
              </div>
            </form>
          </div>
        </div> -->



        <div class="row mb-5">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <canvas id="myChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- .content -->

      <!-- footer -->
      
      <!-- footer -->
      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modalUbah_DataDiriOwner.php'; ?>
    </div>
  </div>
  

  <script src="../vendors-2/jquery/dist/jquery.min.js"></script>
  <script src="../vendors-2/popper.js/dist/umd/popper.min.js"></script>
  <script src="../vendors-2/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="../assets-2/js/main.js"></script>

  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/Chart.min.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <?php include 'confirmLogout.php'; ?>

  <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober","Nopember","Desember"],
            datasets: [{
                label: 'Reservasi',
                data: [12, 19, 3, 23, 2, 3],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
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
      if(UbahDataDiri_Pengguna($_POST) >= 0){
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
