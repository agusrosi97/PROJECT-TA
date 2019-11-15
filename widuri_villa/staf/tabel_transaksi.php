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

  $data_transaksi = mysqli_query($conn,"
    SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*, tbl_reservasi.*
    FROM tbl_transaksi_pembayaran
    INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    INNER JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    ORDER BY id_transaksi DESC
  ");
  
  include '../query/queryDataDiri_pengguna.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Transaksi Pembayaran</title>
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
              <a href="../index.php"> <i class="menu-icon fas fa-globe"></i>Kunjungi website</a>
            </li>
            <li>
              <a href="index.php"> <i class="menu-icon fas fa-tachometer-alt"></i>Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3><!-- /.menu-title -->
            <li>
              <a href="tabel_tamu.php"> <i class="menu-icon far fa-address-card"></i>Data Tamu</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"> <i class="menu-icon fas fa-home"></i>Data Tipe Kamar</a>
            </li>
            <li >
              <a href="tabel_reservasi.php"> <i class="menu-icon fas fa-calendar-check"></i>Reservasi</a>
            </li>
            <li class="active">
              <a href=""> <i class="menu-icon fas fa-credit-card"></i>Transaski Pembayaran</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>

    <div id="right-panel" class="right-panel">
      <!-- HEADER -->
      <?php include '../header/headerStaf.php'; ?>
      <!-- /HEADER -->

      <div class="breadcrumbs shadow-sm">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Data Transaksi</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
              <ol class="breadcrumb text-right">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Data Transaksi</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 mb-2">

        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm">

          <table id="StafTablesTamu" class="table rounded table-responsive table-hover" width="100%">
            <thead class="thead-dark">
              <tr class="text-nowrap text-center">
                <th class="d-none"></th>
                <th>Status</th>
                <th>ID Trans</th>
                <th>Foto</th>
                <th>Nama Tamu</th>
                <th>CheckIn</th>
                <th>Checkout</th>
                <th>Total Bayar</th>
                <th>Tanggal Transaksi</th>
                <th>Jam</th>
                <th>Ket</th>
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
                <tr class="text-nowrap text-center">
                  <td class="d-none"></td>
                  <td class="d-flex justify-content-center">
                    <?php if($row["status"] === "VALID") : ?>
                      <button type="button" class="btn btn-success rounded py-0 px-1"><i class="fas fa-check"></i> Diterima</button>
                    <?php elseif($row["status"] === null) : ?>
                      <button class="btn btn-outline-success rounded border-0" data-toggle="modal" data-target="#popUpReservasi_<?php echo $row["id_transaksi"] ?>"><i class="fas fa-check" style="font-size: 20px"></i></button>
                      <button class="btn btn-outline-danger rounded border-0" data-toggle="modal" data-target="#popUpReservasiGakvalid_<?php echo $row["id_transaksi"] ?>"><i class="fas fa-times" style="font-size: 20px"></i></button>
                    <?php elseif($row["status"] === "GAK VALID") : ?>
                      <button type="button" class="btn btn-danger rounded py-0" style="padding-left: 6px; padding-right: 6px;"><i class="fas fa-times"></i> Ditolak</button>
                    <?php endif; ?>
                  </td>
                  <!-- <td><?php //echo $row["id_transaksi"]; ?></td> -->
                  <td>TRN-0<?=$row["id_transaksi"]; ?></td>

                  <td class="p-1" style="cursor: pointer;">
                    <div class="data_foto">
                      <img src="../assets/foto_transaksi/<?php echo $row["foto_bukti_transaksi"] ?>" alt="" data-toggle="modal" data-target="#modalFoto_<?=$row["id_transaksi"];?>">
                    </div>
                  </td>

                  <td><?= $row["nama_tamu"]; ?></td>
                  <td><?= date_format(new Datetime($row["tgl_checkin"]), "d M Y"); ?></td>
                  <td><?= date_format(new Datetime($row["tgl_checkout"]), "d M Y"); ?></td>
                  <td>Rp.<?= number_format($row["total_pembayaran_kamar"],2,',','.'); ?>,-</td>
                  <td><?= date_format(new Datetime($date), "d M, Y"); ?></td>
                  <td><?= $time; ?></td>
                  <td><?= $row["ket_transaksi"]; ?></td>
                </tr>
                <?php include 'modalFoto.php'; ?>
                <?php include 'verifikasi_transaksi.php'; ?>
                <?php include 'verifikasi_tidakValid.php'; ?>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody> 
          </table>
        </div>    
      </div>

      <div id="notif"></div>

      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
    <!-- /#right-panel -->
    </div>
  <!-- Right Panel -->
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>

  <script>
    $('#StafTablesTamu').DataTable({
      'language': {
        'emptyTable': 'Tidak ada data Transaksi ☹'
      },
      'columns': [
        null,
        null,
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
    <?php else : ?>
      $('#StafTablesTamu').removeClass('table-responsive');
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

    if( isset($_POST["transaksiValid"]) ) :
      if( VerifikasiValid($_POST) > 0 ) {
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
      }
    endif;
    if( isset($_POST["transaksiGakValid"]) ) :
      if( VerifikasiTidakValid($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Data tertolak!',
              text: 'Data Resevasi tidak valid.',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.href = 'tabel_transaksi.php';             
            });
          </script>
        ";
      }
    endif;
  ?>

</body>

</html>
