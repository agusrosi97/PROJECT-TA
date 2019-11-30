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

  $data_transaksi = mysqli_query($conn,
        "SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
        FROM tbl_transaksi_pembayaran
        LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
        LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
        ORDER BY id_transaksi DESC");
  
  include '../query/queryDataDiri_pengguna.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan Transaksi Pembayaran</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="../assets/images/logo-w.png">

  <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <!-- <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css"> -->
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
              <a href="laporan_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Laporan Tamu</a>
            </li>
            <li>
              <a href="laporan_Reservasi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-luggage-cart"></i></div>Laporan Reservasi</a>
            </li>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div>Laporan Transaksi</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>

    <div id="right-panel" class="right-panel">
      <!-- HEADER -->
      <?php include '../header/headerOwner.php'; ?>
      <!-- /HEADER -->

      <div class="breadcrumbs">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Laporan Transaksi</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
              <ol class="breadcrumb text-right">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Laporan Transaksi</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 mb-2" >

        <div class="p-2 bg-light border rounded mb-5 shadow-sm">
          <div class="row">
            <div class="col">
              <form action="print_Transaksi.php" class="col-12 px-0" method="POST">
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

          <table id="StafTablesTamu" class="table table-striped rounded" width="100%">
            <thead class="thead-dark">
              <tr class="text-nowrap">
                <th class="d-none"></th>
                <th>Foto</th>
                <th>Nama Tamu</th>
                <th>CheckIn</th>
                <th>Checkout</th>
                <th>J. Hari</th>
                <th>Total Bayar</th>
                <th>Tanggal Transaksi</th>
                <th>Jam</th>
                <th>Ket</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach( $data_transaksi as $row ) : ?>
              <?php
                $timestamp = $row["jam_transaksi"];
                $datetime = explode(" ",$timestamp);
                $date = $datetime[0];
                $time = $datetime[1];
              ?>
                <tr class="text-nowrap">
                  <td class="d-none"></td>
                  <td class="p-1"><div class="data_foto"><img src="../assets/foto_transaksi/<?php echo $row["foto_bukti_transaksi"] ?>" alt=""></div></td>
                  <td><?= $row["nama_tamu"]; ?></td>
                  <td><?= date_format(new Datetime($row["tgl_checkin"]), "d M Y"); ?></td>
                  <td><?= date_format(new Datetime($row["tgl_checkout"]), "d M Y"); ?></td>
                  <td><?php echo $row["jumlah_hari"]; ?></td>
                  <td>Rp.<?= number_format($row["total_pembayaran_kamar"],2,',','.'); ?>,-</td>
                  <td><?= $date; ?></td>
                  <td><?= $time; ?></td>
                  <td><?= $row["ket_transaksi"]; ?></td>
                  <td>
                    <?php if($row["status"] === "VALID"): ?>
                      <div class="btn btn-success py-0 px-1 rounded-circle"><i class="fas fa-check"></i></div>
                    <?php elseif ($row["status"] === "GAK VALID") : ?>
                      <div class="btn btn-danger rounded-circle py-0" style="padding-left: 6px; padding-right: 6px;"><i class="fas fa-times"></i></div>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody> 
          </table>
        </div>    
      </div>

      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
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
    $('.custom-select1').click(function() {
      $('.custom-select1').addClass('black');
    });

    $('#StafTablesTamu').DataTable({
      'language': {
        'emptyTable': 'Tidak ada data Tamu ☹'
      },
      'columns': [
        null,
        { "orderable": false },
        null,
        { "orderable": false },
        null,
        null,
        null,
        null,
        null,
        null,
        null
      ]
    });

    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });

    <?php if(mysqli_num_rows($data_transaksi) >= 1) : ?>
      $('#StafTablesTamu').addClass('table-responsive');
    <?php endif; ?>
  </script>

  <!-- /////// BTN UBAH - TAMBAH /////// -->
  <?php 
    if( isset($_POST["submit"]) ) {
      if( stafTambahTamu($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data telah ditambahkan.',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_tamu.php';
            });
          </script>
        ";
      } else {
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Gagal menambah data!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_tamu.php';
            });
          </script>
        ";
      }
    }

    // EDIT FORM
    if( isset($_POST["submit_ubah"]) ) {  
      if( stafUbahTamu($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_tamu.php';
            });
          </script>
        ";
      } else {
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Data gagal diubah!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_tamu.php';
            });
          </script>
        ";
      }
    }

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
              window.location.href = 'tabel_tamu.php';             
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
              window.location.href = 'tabel_tamu.php';             
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
              window.location.href = 'tabel_tamu.php';             
            });
          </script>
        ";
      }
    }



    if( isset($_POST["transaksiValid"]) ) {
      // if( ubah_pass_pengguna($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil divalidasi!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'tabel_transaksi.php';             
            });
          </script>
        ";
      // }
    }
    if( isset($_POST["transaksiGakValid"]) ) {
      // if( ubah_pass_pengguna($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Data tidak tervalidasi!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'tabel_transaksi.php';             
            });
          </script>
        ";
      // }
    }
  ?>

</body>

</html>
