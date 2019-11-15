<?php 
  session_start();

  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }  
  if ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "staf") ) {
    header('location: ../staf/index.php');
    exit;
  }

  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];

  require '../koneksi/function_global.php';

  include '../query/queryDataDiri_pengguna.php';

  // GET DATA PENGGUNA
  $TotalDataPengguna = mysqli_query($conn, "SELECT * FROM tbl_pengguna");
  $HasilDataPengguna = mysqli_num_rows($TotalDataPengguna);

?>

<!doctype html>
<html class="no-js" lang="en">
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
          <a class="navbar-brand hidden" href=""><img src="../assets/images/logo-w.png" alt="Logo"></a>
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
              <a href="tabel_pengguna.php"> <i class="menu-icon fas fa-users"></i>Data Pengguna</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"> <i class="menu-icon fas fa-home"></i>Data Tipe Kamar</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside><!-- /#left-panel -->

    <div id="right-panel" class="right-panel">

      <!-- HEADER -->
      <?php include '../header/headerAdmin.php'; ?>
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
                  <span class="count"><?php echo $HasilDataPengguna; ?></span>
                </h4>
                <p class="text-light">Penguna</p>
                <i class="fas fa-users" style="position: absolute; font-size: 70px; opacity: .7; right: 20px; top: 40px"></i>
                <div class="chart-wrapper px-0" style="height:70px;" height="70"> 
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-1">
              <div class="card-body pb-0">
                <div class="dropdown float-right">
                  <i class="fa fa-cog"></i>
                </div>
                <h4 class="mb-0">
                  <span class="count">25</span>
                </h4>
                <p class="text-light">Jumlah Pengunjung</p>
                <!-- <i class="fas fa-users" style="position: absolute; font-size: 70px; opacity: .7; right: 20px; top: 40px"></i> -->

                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                    
                </div>

              </div>

            </div>
          </div>
        </div><!--/.col-->

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
      </div>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modalUbah_DataDiriAdmin.php'; ?>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type="text/javascript" src="../assets-2/js/Chart.min.js"></script>
  <script type="text/javascript" src="../assets/js/sweetalert2.min.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    //chart Transaksi
  var ctx = document.getElementById("chartResrvasi").getContext('2d');
  ctx.height = 150;
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Ma", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],
      datasets: [{
        label: "Transaksi valid (<?php echo date('Y') ?>)",
        data: [ 
          <?php 
            $data =  grafikValid(date('Y'));
            for ($i=0; $i <count($data) ; ++$i) { 
              echo  $data[$i].',';
            }
          ?>
        ],
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: "1",
        backgroundColor: "rgba(54, 162, 235, 0.2)" }, {
          label: "Transaksi Ditolak (<?php echo date('Y') ?>)",
          data: [ 
            <?php 
              $data =  grafikGakValid(date('Y'));
              for ($i=0; $i <count($data) ; ++$i) { 
                echo  $data[$i].',';
              }
            ?>
          ],
          borderColor: "rgba(255,99,132,1)",
          borderWidth: "1",
          backgroundColor: "rgba(255, 99, 132, 0.2)"
        }
      ]
    },
    options: {
      responsive: true,
      tooltips: {
        mode: 'index',
        intersect: false
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(value) {if (value % 1 === 0) {return value;}}
          }
        }]
      }
    }
  });
    var ctx = document.getElementById("chartTransaksi").getContext('2d');
  ctx.height = 150;
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Ma", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],
      datasets: [{
        label: "Transaksi valid (<?php echo date('Y') ?>)",
        data: [ 
          <?php 
            $data =  grafikValid(date('Y'));
            for ($i=0; $i <count($data) ; ++$i) { 
              echo  $data[$i].',';
            }
          ?>
        ],
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: "1",
        backgroundColor: "rgba(54, 162, 235, 0.2)" }, {
          label: "Transaksi Ditolak (<?php echo date('Y') ?>)",
          data: [ 
            <?php 
              $data =  grafikGakValid(date('Y'));
              for ($i=0; $i <count($data) ; ++$i) { 
                echo  $data[$i].',';
              }
            ?>
          ],
          borderColor: "rgba(255,99,132,1)",
          borderWidth: "1",
          backgroundColor: "rgba(255, 99, 132, 0.2)"
        }
      ]
    },
    options: {
      responsive: true,
      tooltips: {
        mode: 'index',
        intersect: false
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(value) {if (value % 1 === 0) {return value;}}
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
