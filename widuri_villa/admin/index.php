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
  $TotalDataPengguna = mysqli_query($conn, "SELECT * FROM tbl_pengguna WHERE hak_akses_pengguna != 'owner' AND status_pengguna != 'Tidak Aktif'");
  $HasilDataPengguna = mysqli_num_rows($TotalDataPengguna);
  // GET JML KAMAR
  $gettotalKamar = mysqli_query($conn, "SELECT sum(jumlah_kamar) AS jmlKamarTerkini FROM tbl_tipe_kamar");
  $OutputKamar = mysqli_fetch_assoc($gettotalKamar);
  $kamarSaatini = $OutputKamar['jmlKamarTerkini'];
  //== jmlTransaksi
  $cekTransaksi = mysqli_query($conn, "SELECT sum(total_pembayaran_kamar) AS total_bayar FROM tbl_transaksi_pembayaran WHERE status = 'VALID'");
  $hasilTransaksi = mysqli_fetch_assoc($cekTransaksi);
  // // CARI KAMAR TERLARIS
  // $Kam = mysqli_query($conn, "SELECT max(tipe_kamar) as tipe_kamar FROM tbl_transaksi_pembayaran WHERE tipe_kamar != '-'");
  // while ($hasKam = mysqli_fetch_assoc($Kam)) {
  //   $pp = explode(", ", $hasKam['tipe_kamar']);
  //   $max = getMax($pp);
  //   echo $max;
  // }
  // $already_selected_value = 2019;
  $earliest_year = 2017;
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
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/Chart.min.css">
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
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div>Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3><!-- /.menu-title -->
            <li>
              <a href="tabel_pengguna.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-users"></i></div>Data Pengguna</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-home"></i></div>Data Tipe Kamar</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
    <div id="right-panel" class="right-panel">
      <?php include '../header/headerAdmin.php'; ?>
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
        <div class="col-sm-12 mb-2 px-2">
          <div class="card-group">
            <div class="card col-md-6 no-padding border-0 mb-2 bg-flat-color-10 mr-lg-1 rounded shadow-sm dash-card">
              <div class="card-body" onclick="window.location.href='tabel_pengguna.php'">
                <div class="h1 text-light text-right mb-4">
                  <i class="fa fa-users"></i>
                </div>
                <div id="tampilHasilTamu">
                  <div class="h4 mb-0 text-light">
                    <span class="count"><?=$HasilDataPengguna;?></span>
                  </div>
                  <small class="text-light text-uppercase font-weight-bold">Total Pengguna</small>
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
                  <span class="count"><?=$kamarSaatini;?></span>
                </div>
                <small class="text-light text-uppercase font-weight-bold">Jumlah kamar saat ini</small>
                <div class="progress progress-xs mt-3 mb-0" style="width: 40%; height: 5px;"></div>
              </div>
            </div>
            <div class="card col-md-6 no-padding border-0 mb-2 bg-flat-color-8 ml-lg-1 rounded shadow-sm dash-card trans">
              <select id="selectTrans" class="selectpicker form-control show-tick sel rounded position-absolute" title="Pilih waktu" data-width="fit">
                <option value="day">24 jam terakhir</option>
                <option value="week">Seminggu terakhir</option>
                <option value="month">Sebulan terakhir</option>
                <option value="year">Setahun terakhir</option>
              </select>
              <div class="card-body" onclick="window.location.href='tabel_transaksi.php'">
                <div class="h1 text-light text-right mb-4">
                  <i class="fas fa-luggage-cart"></i>
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
      <div class="content mb-4">
        <div class="row mb-4 px-2">
          <div class="col-lg-6 pr-xl-1">
            <div class="card shadow rounded border-light">
              <div class="card-body shadow-sm pt-0">
                <div class="row">
                  <canvas id="chartResrvasi"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-6 pl-xl-1">
            <div class="card">
              <div class="card-body shadow-sm">
                <div class="row">
                  <canvas id="chartTransaksi"></canvas>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modalUbah_DataDiriAdmin.php'; ?>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type="text/javascript" src="../assets-2/js/Chart.min.js"></script>
  <script type="text/javascript" src="../assets/js/sweetalert2.min.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    // chart Resrvasi
    var ctx = document.getElementById( "chartResrvasi" );
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