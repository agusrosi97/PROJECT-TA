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

  include '../query/queryDataDiri_pengguna.php';
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

  <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../vendors-2/themify-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors-2/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../vendors-2/selectFX/css/cs-skin-elastic.css">
  <link rel="stylesheet" href="../vendors-2/jqvmap/dist/jqvmap.min.css">
  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>


  <link rel="stylesheet" href="../assets-2/css/style.css">

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
              <a href="../index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-globe"></i></div>Kunjungi website</a>
            </li>
            <li>
              <a href="index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div>Dashboard</a>
            </li>
            <h3 class="menu-title">LAPORAN</h3>
            <li>
              <a href="laporan_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Laporan Data Tamu</a>
            </li>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-luggage-cart"></i></div>Laporan Reservasi</a>
            </li>
            <li>
              <a href="laporan_transaksi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div>Laporan Transaksi</a>
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
              <h1>Laporan Reservasi</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="index.php">Dashboard</a></li>
                  <li class="active">Laporan Reservasi</li>
                </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 mb-2" >
        <div class="p-2 bg-light border rounded mb-5">
          <div class="row">
            <div class="col">
              <form action="print_dataReservasi.php" class="col-12 px-0" method="POST">
                <div class="form-group">
                  <div class="col-md-5 pl-0 d-flex">
                    <select class="form-control mb-3">
                      <option value="Januari">Januari</option>
                      <option value="Februari">Februari</option>
                      <option value="Maret">Maret</option>
                      <option value="April">April</option>
                      <option value="Mei">Mei</option>
                      <option value="Juni">Juni</option>
                      <option value="Juli">Juli</option>
                      <option value="Agustus">Agustus</option>
                      <option value="September">September</option>
                      <option value="Oktober">Oktober</option>
                      <option value="Nopember">Nopember</option>
                      <option value="Desember">Desember</option>
                    </select>
                    <select class="form-control ml-2">
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                    </select>
                  </div>
                  <div class="col-md-3 px-0 mb-2">
                    <button type="submit" class="btn btn-primary rounded shadow-sm">PRINT</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <table id="StafTablesReservasi" class="table table-striped table-responsive" width="100%">
            <thead>
              <tr class="text-nowrap">
                <th>No</th>
                <th>Id</th>
                <th>Nama Tamu</th>
                <th>Nama Staf</th>
                <th>Checkin</th>
                <th>Checkout</th>
                <th>J. Kamar</th>
                <th>J. Hari</th>
                <th>J. Dewasa</th>
                <th>J. Anak</th>
                <th>Tangal Reservasi</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = query("SELECT tbl_reservasi.*, tbl_tamu.*, tbl_pengguna.*
                          FROM tbl_reservasi
                          LEFT JOIN tbl_pengguna ON tbl_reservasi.id_pengguna = tbl_pengguna.id_pengguna
                          LEFT JOIN tbl_tamu ON tbl_reservasi.id_tamu = tbl_tamu.id_tamu 
                          ORDER BY id_reservasi DESC
                ");
                $no=1;
                  foreach ($sql as $row) {
                  ?>
                  <tr class="text-nowrap">
                    <td><?php echo $no; ?></td>
                    <!-- <td><?php echo $row["id_tamu"]; ?></td> -->
                    <td>RSV-0<?php echo $row['id_reservasi']; ?></td>
                    <td><?php echo $row['nama_tamu']; ?></td>
                    <td><?php echo $row['username_pengguna']; ?></td>
                    <td class="text-nowrap"><?php echo $row['tgl_checkin']; ?></td>
                    <td class="text-nowrap"><?php echo $row['tgl_checkout']; ?></td>
                    <td class="text-center"><?php echo $row['jumlah_kamar']; ?></td>
                    <td class="text-center"><?php echo $row['jumlah_hari']; ?></td>
                    <td class="text-center"><?php echo $row['jumlah_orang']; ?></td>
                    <td class="text-center"><?php echo $row['jumlah_anak']; ?></td>
                    <td><?php echo date_format(new Datetime($row["jam_reservasi"]), "Y M d  H:i:s"); ?></td>
                    <td class="text-center">
                      <?php $cekstatus = mysqli_query($conn, "SELECT status FROM tbl_transaksi_pembayaran WHERE id_tamu ='$row[id_tamu]'");
                        if (mysqli_num_rows($cekstatus) >= 1) {
                          $baris = mysqli_fetch_assoc($cekstatus);
                          $statusRes = $baris["status"];
                          if ($statusRes === "VALID") : ?><div class="btn btn-success py-0 px-1 rounded-circle"><i class="fas fa-check"></i></div><?php elseif ($statusRes === null) : ?>Menunggu<?php elseif ($statusRes === "GAK VALID") : ?>BBB<?php endif;
                        }
                      ?>
                     </td>
                  </tr>
                  <?php
                  $no++;
                }
              ?>
            </tbody> 
          </table>
        </div>    
      </div>

      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriOwner.php'; ?>
    <!-- /#right-panel -->
    </div>
  <!-- Right Panel -->
  </div>

  <!-- PENTING PENTING PENTING PENTING PENTING PENTING PENTING PENTING -->
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <!-- PENTING PENTING PENTING PENTING PENTING PENTING PENTING PENTING -->


  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>

  <script>
    (function($) {
      $('.custom-select1').click(function() {
        $('.custom-select1').addClass('black');
      });

      $('#StafTablesReservasi').DataTable({
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
          null,
          null,
          { 'orderable': false }
        ]
      });
    } )(jQuery);
  </script>
  <script type="text/javascript">
    (function($) {
      $('#menuToggle').click(function() {
        $('.menu-admin').toggleClass('hide');
      });

    } )(jQuery);
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
              window.location.href = 'tabel_reservasi.php';             
            });
          </script>
        ";
      }
    }

    // Ubah Profile
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
              window.location.href = 'tabel_reservasi.php';             
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
              window.location.href = 'tabel_reservasi.php';             
            });
          </script>
        ";
      }
    }
    if( isset($_POST["simpan_reservasi"]) ) {
      // if( ubah_pass_pengguna($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil ditambahkan!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'tabel_reservasi.php';             
            });
          </script>
        ";
      // }
    }
    if( isset($_POST["ubah_reservasi"]) ) {
      // if( ubah_pass_pengguna($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'tabel_reservasi.php';             
            });
          </script>
        ";
      // }
    }
  ?>

</body>

</html>
