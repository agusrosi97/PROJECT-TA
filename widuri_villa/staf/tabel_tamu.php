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
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Tamu</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/jquery-ui.min.css'>
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
              <a href="tabel_reservasi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-calendar-check"></i></div>Reservasi</a>
            </li>
            <li>
              <a href="tabel_transaksi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div>Transaski Pembayaran</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-home"></i></div>Data Tipe Kamar</a>
            </li>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Data Tamu</a>
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
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm">
          <!-- <button type="button" class="btn btn-primary mb-3 shadow-sm px-1 py-0 btn-tmbh" data-toggle="modal" data-target="#popup_tambah_tamu" style="font-size: 20px"><i class="fas fa-plus"></i></button> -->
          <div class="table-responsive pt-1 px-1">
            <table id="StafTablesTamu" class="table rounded dt-responsive table-hover nowrap" width="100%">
              <thead class="thead-dark">
                <tr class="text-nowrap">
                  <th>#</th>
                  <th>Aksi</th>
                  <th>Foto</th>
                  <th>Nama Tamu</th>
                  <th>Tgl Lahir</th>
                  <th>Email</th>
                  <th>No Telp</th>
                  <th>Alamat</th>
                  <th>JK</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach( $data_tamu as $row ) : ?>
                  <tr class="text-nowrap">
                    <td><?=$i;?></td>
                    <td>
                      <button title="Ubah data" class="btn btn-primary px-2 py-1 rounded" data-toggle="modal" data-target="#popup_ubah_tamu_<?php echo $row["id_tamu"] ?>" style="font-size: 13px"><i class="fas fa-edit"></i></button>
                    </td>
                    <td class="p-1"><div class="data_foto"><img src="../assets/foto_tamu/<?php echo $row["foto_tamu"] ?>" alt=""></div></td>
                    <td><?= $row["nama_tamu"]; ?></td>
                    <td><?= date_format(new Datetime($row["tgl_lahir_tamu"]), "d F Y"); ?></td>
                    <td><?= $row["email_tamu"]; ?></td>
                    <td><?= $row["no_telp_tamu"]; ?></td>
                    <td><?= $row["alamat_tamu"]; ?></td>
                    <td><?= $row["jk_tamu"]; ?></td>
                  </tr>
                  <?php include 'modal_ubah_tamu.php'; ?>
                  <?php $i++; ?>
                <?php endforeach; ?>
              </tbody> 
            </table>
          </div>
        </div>    
      </div>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_tambah_tamu.php'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/responsive.bootstrap4.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    $('#StafTablesTamu').DataTable({
      'language': {
        'emptyTable': 'Tidak ada data Tamu ☹'
      },
      'columns': [
        null,
        { "orderable": false },
        { "orderable": false },
        null,
        null,
        null,
        null,
        null,
        null
      ],
      "processing": true,
      "pagingType": "full_numbers",
      "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
      responsive: true,
      "order": []
    });
    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });
    <?php
      $q=1;
      foreach ($data_tamu as $p): ?>
        $('#tgllhir-<?=$q;?>').datepicker({
          dateFormat: 'yy-mm-dd',
          changeMonth: true,
          changeYear: true
        });
      <?php
      $q++;
      endforeach;
    ?>
  </script>
  <?php 
    // if( isset($_POST["submit"]) ) {
    //   if( stafTambahTamu($_POST) > 0 ) {
    //     echo "
    //       <script>
    //         Swal.fire({
    //           type: 'success',
    //           title: 'Data telah ditambahkan.',
    //           showConfirmButton: false,
    //           timer: 2000
    //         }).then(function() {
    //           window.location.href = 'tabel_tamu.php';
    //         });
    //       </script>
    //     ";
    //   } else {
    //     echo "
    //       <script>
    //         Swal.fire({
    //           type: 'error',
    //           title: 'Gagal menambah data!',
    //           showConfirmButton: false,
    //           timer: 2000
    //         }).then(function() {
    //           window.location.href = 'tabel_tamu.php';
    //         });
    //       </script>
    //     ";
    //   }
    // }

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