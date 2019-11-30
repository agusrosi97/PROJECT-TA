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

  $hitungJmlTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu");
  $OutputTamu = mysqli_num_rows($hitungJmlTamu);

  $hitungJmlReservasi = mysqli_query($conn, "SELECT * FROM tbl_reservasi");
  $Outputreservasi = mysqli_num_rows($hitungJmlReservasi);

  $cekPemesanTerbaru = mysqli_query($conn, "
    SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
    FROM tbl_transaksi_pembayaran
    INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    WHERE jumlah_kamar >= '1' AND status = 'VALID' OR NULL AND tgl_checkout >= date('Y-m-d')
    ORDER BY id_transaksi DESC LIMIT 20");
  $jmlPemesanTerbaru = mysqli_num_rows($cekPemesanTerbaru);

  date_default_timezone_set('Asia/Singapore');
  // $aaa=now("Y-m-d");
  // echo $aaa;
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome Owner</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
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
              <a href="../index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-globe"></i></div>Kunjungi website</a>
            </li>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div>Dashboard</a>
            </li>
            <h3 class="menu-title">LAPORAN</h3>
            <li>
              <a href="laporan_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Laporan Data Tamu</a>
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
            <div class="card col-md-6 no-padding bg-flat-color-10 mr-lg-1 rounded shadow-sm" onclick="window.location.href='tabel_tamu.php'">
              <div class="card-body">
                a
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
            <div class="card col-md-6 no-padding bg-flat-color-8 mx-lg-1 rounded shadow-sm" onclick="window.location.href='tabel_tipeKamar.php'">
              <div class="card-body">
                <div class="h1 text-light text-right mb-4">
                  <i class="fas fa-home"></i>
                </div>
                <div class="h4 mb-0 text-light">
                  <span class="count">1</span>
                </div>
                <small class="text-light text-uppercase font-weight-bold">Jumlah kamar saat ini</small>
                <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
              </div>
            </div>
            <div class="card col-md-6 no-padding bg-flat-color-9 ml-lg-1 rounded shadow-sm" onclick="window.location.href='tabel_reservasi.php'">
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
          </div>
        </div>
      </div>
      <div class="content mb-5">
        <div class="col-lg-6 pr-lg-2 px-0">
          <div class="card rounded">
            <div class="card-body shadow-sm">
              <div class="row">
                <canvas id="myChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 pl-lg-2 px-0">
          <div class="card rounded">
            <div class="card-header shadow-sm text-secondary bg-white">
              <!-- <?=$jmlPemesanTerbaru ?> -->
              Pemesanan Terbaru
            </div>
            <div class="card-body shadow-sm pt-1" style="overflow-y: auto; height: 238px;">
              <?php while($hasilPemesanTerbaru = mysqli_fetch_assoc($cekPemesanTerbaru)) : ?>
                <div class="col-md-12 py-1 px-0">
                  <div class="row">
                    <div class="col-2 pr-0 AutoHilang">
                      <div class="data_foto2 rounded-circle" style="box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                        <?php if($hasilPemesanTerbaru['foto_tamu'] === '') :?>
                          <img src="../assets/images/user.png" class="img-fluid" alt="">
                        <?php else : ?>
                          <img src="../assets/foto_tamu/<?php echo $hasilPemesanTerbaru['foto_tamu'] ?>" alt="" class="img-fluid">
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col-10 pl-0 AotuLebar">
                      <div class="d-flex justify-content-between" style="height: 33px !important; padding-top: 3px">
                        <span class="text-wrap pl-2 font-weight-bold text-dark"><?=$hasilPemesanTerbaru['nama_tamu'] ?></span>
                        <p class="text-muted text-nowrap" style="font-size: 13px"><?=time_elapsed_string($hasilPemesanTerbaru['jam_reservasi']); ?></p>
                      </div>
                      <div id="scrool" class="d-flex text-nowrap" style="width: 100% !important; overflow-x: auto;">
                        <div class="pl-2 text-muted ">
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
            </div>
          </div>
        </div>
      </div>
      
      <!-- footer -->
      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modalUbah_DataDiriOwner.php'; ?>
    </div>
  </div>
  <script src="../vendors-2/jquery/dist/jquery.min.js"></script>
  <script src="../vendors-2/popper.js/dist/umd/popper.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/js/Chart.min.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <?php include 'confirmLogout.php'; ?>

  <script>
    var ctx = document.getElementById( "myChart" );
    ctx.height = 150;
    var myChart = new Chart( ctx, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Ma", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],
        datasets: [{
          label: "Reservasi tahun ini (<?php echo date('Y') ?>)",
          data: [ 
            <?php 
              $data =  grafikReservasi(date('Y'));
              for ($i=0; $i <count($data) ; ++$i) { 
                echo  $data[$i].',';
              }
            ?>
          ],
          borderColor: "rgba(0, 123, 255, 0.9)",
          borderWidth: "0.8",
          backgroundColor: "rgba(0, 123, 255, 0.5)",
          pointHighlightStroke: "rgba(26,179,148,1)"
          },
          {
            label: "Reservasi tahun lalu (<?php echo date('Y',strtotime("-1 year")); ?>)",
            data: [ 
              <?php 
                $data =  grafikReservasi(date('Y',strtotime("-1 year")));
                for ($i=0; $i <count($data) ; ++$i) { 
                  echo  $data[$i].',';
                }
              ?>
            ],
            borderColor: "rgba(0,0,0,.3)",
            borderWidth: "0.8",
            backgroundColor: "rgba(0,0,0,.2)",
            pointHighlightStroke: "rgba(26,179,148,1)"
          }
        ]
      },
      options: {
        tooltips: {
          mode: 'index',
          intersect: false,
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
