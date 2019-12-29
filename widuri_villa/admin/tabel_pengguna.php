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
  // $namanya = $_SESSION["loggedin_pengguna"]["nama_pengguna"];
  // $fotonya = $_SESSION["loggedin_pengguna"]["foto_pengguna"];
  require '../koneksi/function_global.php';
  $TableData_pengguna = query("SELECT * FROM tbl_pengguna ORDER BY id_pengguna DESC");
  $AdaOwner = query("SELECT * FROM tbl_pengguna WHERE hak_akses_pengguna = 'owner' AND status_pengguna = 'Aktif'");
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
  <link rel="stylesheet" type="text/css" href="../assets-2/css/rowReorder.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
  <link rel="stylesheet" href="../assets-2/css/style.css">
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
            <li>
              <a href="index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div>Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3><!-- /.menu-title -->
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-users"></i></div>Data Pengguna</a>
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
              <h1>Data Pengguna</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="index.php">Dashboard</a></li>
                  <li class="active">Data Pengguna</li>
                </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-2 mt-1" >
        <div class="p-2 bg-white border rounded mb-5 shadow-sm wrapper-table">
          <button class="btn btn-primary mb-1 shadow-sm btn-tmbh" data-toggle="modal" data-target="#popup_tambah_pengguna"><i class="fas fa-plus"></i></button>
          <div class="table-responsive">
            <table id="OwnerTabelPengguna" class="table rounded dt-responsive table-hover nowrap" width="100%">
              <thead class="thead-dark">
                <tr>
                  <!-- <th>Id</th> -->
                  <th>Nama</th>
                  <th>Foto</th>
                  <th>Akses</th>
                  <th>Email</th>
                  <th>Tgl Lahir</th>
                  <th>No Telp</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                  <th>Status</th>
                  <th>JK</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach( $TableData_pengguna as $row ) : ?>
                <tr>
                  <!-- <td <?php #if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php #else : ?><?php #endif; ?>>P-<?php #echo $row["id_pengguna"]; ?></td> -->
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= $row["username_pengguna"]; ?></td>
                  <td class="py-1 pl-2 <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>statusPengguna<?php else : ?><?php endif; ?>">
                    <div class="data_foto"><img src="../assets/foto_pengguna/<?php echo $row["foto_pengguna"] ?>" alt="">
                    </div>
                  </td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= $row["hak_akses_pengguna"]; ?></td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= $row["email_pengguna"]; ?></td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= date_format(new Datetime($row["tgl_lahir_pengguna"]), "d F Y"); ?></td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= $row["no_telp_pengguna"]; ?></td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= $row["alamat_pengguna"]; ?></td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>>
                    <button title="Ubah data" class="btn btn-primary px-2 py-1 rounded" data-toggle="modal" data-target="#popup_ubah_pengguna_<?php echo $row["id_pengguna"] ?>" style="font-size: 13px"><i class="fas fa-edit"></i></button>
                  </td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna" style="color: rgba(255,99,132,1);"<?php else : ?><?php endif; ?>><?= $row["status_pengguna"]; ?></td>
                  <td <?php if($row["status_pengguna"] == 'Tidak Aktif') :?>class="statusPengguna"<?php else : ?><?php endif; ?>><?= $row["jk_pengguna"]; ?></td>
                </tr>
                <?php include 'modal_ubah_pengguna.php'; ?>
                <?php $i++; ?>
                <?php endforeach;
                ?>
              </tbody> 
            </table>
          </div>
        </div>    
      </div>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modal_tambah_pengguna.php'; ?>
      <?php include 'modalUbah_DataDiriAdmin.php'; ?>
    </div>
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
    (function($) {
      $('.custom-select1').click(function() {
        $('.custom-select1').addClass('black');
      });
      $('#OwnerTabelPengguna').DataTable({
        'language': {
          'emptyTable': 'Tidak ada data Penggua :('
        },
        'columns': [
          // null,
          { 'orderable': false },
          null,
          { 'orderable': false },
          null,
          null,
          null,
          null,
          null,
          null,
          null
        ],
        "processing" : true,
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
      if( AdminUbahPengguna($_POST) >= 0 ) {
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
              window.location.href = 'tabel_pengguna.php';             
            });
          </script>
        ";
      }
    }
    // Ubah Profile
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