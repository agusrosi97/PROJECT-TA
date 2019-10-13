<?php 
  session_start();

  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "staf") ) {
    header('location: ../staf/indexstaf.php');
    exit;
  }

  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
  // $namanya = $_SESSION["loggedin_pengguna"]["nama_pengguna"];
  // $fotonya = $_SESSION["loggedin_pengguna"]["foto_pengguna"];

  require '../koneksi/function_global.php';

  $TableData_pengguna = query("SELECT * FROM tbl_pengguna ORDER BY id_pengguna DESC");
  $AdaOwner = query("SELECT * FROM tbl_pengguna WHERE hak_akses_pengguna = 'owner'");

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
  <title>Data Pengguna</title>
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
              <a href="indexadmin.php"> <i class="menu-icon fas fa-tachometer-alt"></i>Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3><!-- /.menu-title -->
            <li class="active">
              <a href=""> <i class="menu-icon fas fa-users"></i>Data Pengguna</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"> <i class="menu-icon fas fa-home"></i>Data Tipe Kamar</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>

    <div id="right-panel" class="right-panel">
      <!-- HEADER -->
      <?php include '../header/headerAdmin.php'; ?>
      <!-- /HEADER -->

      <div class="breadcrumbs">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Data Pengguna</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="indexadmin.php">Dashboard</a></li>
                  <li class="active">Data Pengguna</li>
                </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 mb-2" >

        <div class="p-2 bg-light border rounded mb-5 shadow-sm">

          <button class="btn btn-success rounded mb-3 shadow" data-toggle="modal" data-target="#popup_tambah_pengguna">Tambah</button>

          <table id="OwnerTabelPengguna" class="table table-striped rounded table-responsive" width="100%">
            <thead class="thead-dark">
              <tr class="text-nowrap">
                <th style="display: none;"></th>
                <th>Aksi</th>
                <th>Id</th>
                <th>Foto</th>
                <th>Nama Pengguna</th>
                <th>Akses</th>
                <th>Email</th>
                <th>Tgl Lahir</th>
                <th>No Telp</th>
                <th>JK</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach( $TableData_pengguna as $row ) : ?>
              <tr class="text-nowrap">
                <td style="display: none;"></td>
                <td>
                  <button title="Ubah data" class="btn btn-primary px-2 py-1 rounded" data-toggle="modal" data-target="#popup_ubah_pengguna_<?php echo $row["id_pengguna"] ?>" style="font-size: 13px"><i class="fas fa-edit"></i></button>
                </td>
                <td>P-<?php echo $row["id_pengguna"]; ?></td>
                <td class="py-2 pl-2"><div class="data_foto"><img src="../assets/foto_pengguna/<?php echo $row["foto_pengguna"] ?>" alt=""></div></td>
                <td><?= $row["username_pengguna"]; ?></td>
                <td><?= $row["hak_akses_pengguna"]; ?></td>
                <td><?= $row["email_pengguna"]; ?></td>
                <td><?= date_format(new Datetime($row["tgl_lahir_pengguna"]), "d F Y"); ?></td>
                <td><?= $row["no_telp_pengguna"]; ?></td>
                <td><?= $row["jk_pengguna"]; ?></td>
                <td><?= $row["alamat_pengguna"]; ?></td>
              </tr>
              <?php include 'modal_ubah_pengguna.php'; ?>
              <?php endforeach;
              ?>
            </tbody> 
          </table>
        </div>    
      </div>

      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modal_tambah_pengguna.php'; ?>
      <?php include 'modalUbah_DataDiriAdmin.php'; ?>
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

      $('#OwnerTabelPengguna').DataTable({
        'language': {
          'emptyTable': 'Tidak ada data Penggua :('
        },
        'columns': [
          null,
          { 'orderable': false },
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null,
          null
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


  <!-- /////// BTN UBAH TAMBAH /////// -->
  <?php 
    if( isset($_POST["submit"]) ) {
      if( AdminTambahPengguna($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data telah ditambahkan.',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_pengguna.php';
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
              window.location.href = 'tabel_pengguna.php';
            });
          </script>
        ";
      }
    }

    // EDIT FORM
    if( isset($_POST["submit_ubah"]) ) {  
      if( AdminUbahPengguna($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_pengguna.php';
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
              window.location.href = 'tabel_pengguna.php';
            });
          </script>
        ";
      }
    }

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
              window.location.href = 'indexadmin.php';             
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
              window.location.href = 'tabel_pengguna.php';             
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
              window.location.href = 'tabel_pengguna.php';             
            });
          </script>
        ";
      }
    }

  ?>

</body>

</html>
