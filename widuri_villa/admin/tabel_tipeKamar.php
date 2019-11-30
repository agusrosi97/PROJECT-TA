<?php 
  session_start();
  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "staf") ) {
    header('location: ../staf/index.php');
    exit;
  }
  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
  require '../koneksi/function_global.php';
  $TableData_tipeKamar = query("SELECT * FROM tbl_tipe_kamar");
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
  <title>Data Tipe Kamar</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/rowReorder.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
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
            <h3 class="menu-title">MASTER DATA</h3><!-- /.menu-title -->
            <li>
              <a href="tabel_pengguna.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-users"></i></div>Data Pengguna</a>
            </li>
            <li class="active">
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
              <h1>Data Tipe Kamar</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="index.php">Dashboard</a></li>
                  <li class="active">Tipe Kamar</li>
                </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 shadow-sm wrapper-table">
          <div class="d-flex">
            <button class="btn btn-primary btn-tmbh mb-1 shadow-sm" id="aa"><i class="fas fa-plus"></i></button>
          </div>
          <table id="TableTipeKamar" class="table rounded dt-responsive table-hover nowrap" width="100%">
            <thead class="thead-dark">
              <tr class="text-nowrap">
                <th>Aksi</th>
                <th>Foto</th>
                <th>Nama Kamar</th>
                <th>Jumlah Kamar</th>
                <th>Harga Kamar</th>
                <th>Fasilitas</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 3; ?>
              <?php foreach( $TableData_tipeKamar as $row ) : ?>
              <?php $centangArray = explode(", ",$row['fasilitas']); ?>
                <tr>
                  <td>
                    <button title="Ubah data" class="btn btn-primary px-2 py-1 rounded" data-toggle="modal" data-target="#popup_Ubah_TipeKam_<?=$row["id_tipe_kamar"];?>" style="font-size: 13px"><i class="fas fa-edit"></i></button>
                  </td>
                  <td class="py-1"><div class="data_foto"><img src="../assets/foto_tipe_kamar/<?php echo $row["foto_tipe_kamar"] ?>" alt=""></div></td>
                  <td class="text-nowrap"><?= $row["nama_tipe_kamar"]; ?></td>
                  <td><?= $row["jumlah_kamar"]; ?></td>
                  <td class="text-nowrap"><?= "Rp. ".number_format($row["harga_kamar"], 2, ",", ".").",-"; ?></td>
                  <td><?= $row["fasilitas"]; ?></td>
                </tr>
                <?php include 'modal_ubah_tipeKamar.php'; ?>
              <?php $i++; ?>
              <?php endforeach;?>
            </tbody> 
          </table>
        </div>    
      </div>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modal_tambah_tipeKamar.php'; ?>
      <?php include 'modalUbah_DataDiriAdmin.php'; ?>
    <!-- /#right-panel -->
    </div>
  <!-- Right Panel -->
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/responsive.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.rowReorder.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    $('#aa').on('click', function() {
      Swal.fire({
        type: 'question',
        title: 'Ada kamar baru?',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
      }).then(result => {
      if (result.value) {
        $('#popup_tambah_TipeKam').modal('show');
      }
      })
    });

    (function($) {
      $('.custom-select1').click(function() {
        $('.custom-select1').addClass('black');
      });
      $('#TableTipeKamar').DataTable({
        'language': {
          'emptyTable': 'Belum ada data Tipe Kamar ☹'
        },
        'columns': [
          { 'orderable': false },
          { 'orderable': false },
          null,
          null,
          null,
          { 'orderable': false }
        ],
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        responsive: true,
        "pagingType": "full_numbers",
        "order": []
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
  <!-- TAMBAH TIPE KAMAR -->
  <?php 
    if( isset($_POST["submit_tambahTPKamar"]) ) {
      if( PenggunaTambahTipeKamar($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data telah ditambahkan.',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_tipeKamar.php';
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
              window.location.href = 'tabel_tipeKamar.php';
            });
          </script>
        ";
      }
    }
    // EDIT TIPE KAMAR
    if( isset($_POST["submit_ubahTPKamar"]) ) {  
      if( PenggunaUbahTipeKamar($_POST) >= 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = 'tabel_tipeKamar.php';
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
              window.location.href = 'tabel_tipeKamar.php';
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
              window.location.href = 'tabel_tipeKamar.php';             
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
              window.location.href = 'tabel_tipeKamar.php';             
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
              window.location.href = 'tabel_tipeKamar.php';             
            });
          </script>
        ";
      }
    }
  ?>
</body>
</html>