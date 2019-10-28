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

  $data_tamu = mysqli_query($conn, "SELECT * FROM tbl_tamu ORDER BY id_tamu DESC");
  
  include '../query/queryDataDiri_pengguna.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Tamu</title>
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
            <li class="active">
              <a href=""> <i class="menu-icon far fa-address-card"></i>Data Tamu</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"> <i class="menu-icon fas fa-home"></i>Data Tipe Kamar</a>
            </li>
            <li >
              <a href="tabel_reservasi.php"> <i class="menu-icon fas fa-calendar-check"></i>Reservasi</a>
            </li>
            <li>
              <a href="#"> <i class="menu-icon fas fa-credit-card"></i>Transaski Pembayaran</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>

    <div id="right-panel" class="right-panel">
      <!-- HEADER -->
      <?php include '../header/headerStaf.php'; ?>
      <!-- /HEADER -->

      <div class="breadcrumbs">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Data Tamu</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
              <ol class="breadcrumb text-right">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Data Tamu</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 mb-2" >

        <div class="p-2 bg-light border rounded mb-5 shadow-sm">

          <button class="btn btn-success rounded mb-3 shadow" data-toggle="modal" data-target="#popup_tambah_tamu">Tambah</button>

          <table id="StafTablesTamu" class="table table-striped rounded" width="100%">
            <thead class="thead-dark">
              <tr class="text-nowrap">
                <td class="d-none"></td>
                <th class="text-center">Aksi</th>
                <th>#</th>
                <th>Foto</th>
                <th>Nama Tamu</th>
                <th>Tgl Lahir</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>JK</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach( $data_tamu as $row ) : ?>
                <tr class="text-nowrap">
                  <td class="d-none"></td>
                  <td>
                    <button title="Ubah data" class="btn btn-primary px-2 py-1 rounded" data-toggle="modal" data-target="#popup_ubah_tamu_<?php echo $row["id_tamu"] ?>" style="font-size: 13px"><i class="fas fa-edit"></i></button>
                  </td>
                  <td><?php echo $row["id_tamu"]; ?></td>
                  <td class="p-1"><div class="data_foto"><img src="../assets/foto_tamu/<?php echo $row["foto_tamu"] ?>" alt=""></div></td>
                  <td><?= $row["nama_tamu"]; ?></td>
                  <td><?= date_format(new Datetime($row["tgl_lahir_tamu"]), "d F Y"); ?></td>
                  <td><?= $row["email_tamu"]; ?></td>
                  <td><?= $row["no_telp_tamu"]; ?></td>
                  <td><?= $row["jk_tamu"]; ?></td>
                  <td><?= $row["alamat_tamu"]; ?></td>
                </tr>
                <?php include 'modal_ubah_tamu.php'; ?>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody> 
          </table>
        </div>    
      </div>

      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_tambah_tamu.php'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
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
        null
      ]
    });

    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });

    <?php if(mysqli_num_rows($data_tamu) >= 1) : ?>
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
  ?>

</body>

</html>
