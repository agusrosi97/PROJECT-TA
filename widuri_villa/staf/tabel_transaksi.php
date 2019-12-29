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
    LEFT JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
    LEFT JOIN tbl_reservasi ON tbl_transaksi_pembayaran.id_reservasi = tbl_reservasi.id_reservasi
    WHERE CURDATE() <= tgl_checkout
    ORDER BY id_transaksi DESC
  ");
  date_default_timezone_set('Asia/Singapore');
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
  <title>Data Transaksi Pembayaran</title>
  <meta name="description" content="Sufee Admin - HTML5 Admin Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel='stylesheet' type="text/css" href='../assets/css/jquery-ui.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
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
          <ul class="nav navbar-nav mb-4">
            <li>
              <a href="../index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-globe"></i></div> Kunjungi website</a>
            </li>
            <li>
              <a href="index.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-tachometer-alt"></i></div> Dashboard</a>
            </li>
            <h3 class="menu-title">MASTER DATA</h3>
            <li>
              <a href="tabel_reservasi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-calendar-check"></i></div> Reservasi</a>
            </li>
            <li class="active">
              <a href=""><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div> Transaski Pembayaran</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-home"></i></div> Data Tipe Kamar</a>
            </li>
            <li>
              <a href="tabel_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div> Data Tamu</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
    <div id="right-panel" class="right-panel">
      <?php include '../header/headerStaf.php'; ?>
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
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm">
          <div>
            <button id="tombolKecil" class="btn btn-primary rounded mb-1"><i class="fas fa-search"></i> Tanggal transaksi</button>
            <div class="col-md-9 px-1">
              <div class="d-flex justify-content-start">
                <div id="tombolBesar" class="form-row align-items-center">
                  <div class="col-md-5">
                    <div class="input-group">
                      <input type="text" class="form-control pem" placeholder="Dari" id="tgl_awal" readonly style="font-size: 15px">
                    </div>
                  </div>
                  <div class="d-flex justify-content-center align-items-center col-sm-1 px-0 strip">
                    <i class="fas fa-minus text-secondary"></i>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <input type="text" class="form-control pem" placeholder="Sampai" id="tgl_akhir" readonly style="font-size: 15px" onchange="clickCari()">
                      <div class="input-group-append">
                        <button id="btnCariReservasi" class="btn btn-primary rounded-right" type="button" disabled><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive pt-2 px-2 rounded" id="load_HasilCari">
            <table id="StafTablesTransaksi" class="table rounded dt-responsive table-hover nowrap" width="100%">
              <thead class="thead-dark">
                <tr class="text-nowrap">
                  <th>ID Trans</th>
                  <th>Nama Tamu</th>
                  <th>Total Bayar</th>
                  <th>Tgl Transaksi</th>
                  <th class="text-center">Jam</th>
                  <th class="text-center">Qty. Kam</th>
                  <th class="text-left">Bukti</th>
                  <th class="text-center">Status</th>
                  <th>Ket</th>
                  <th>CheckIn</th>
                  <th>Checkout</th>
                  <th>Tipe Kamar</th>
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
                  $time12Hour = date_format(new Datetime($time), "h:i:s A");
                ?>
                  <tr>
                    <td>TRN-0<?=$row["id_transaksi"]; ?></td>
                    <td class="text-wrap"><?= $row["nama_tamu"]; ?></td>
                    <td>Rp.<?= number_format($row["total_pembayaran_kamar"],2,',','.'); ?>,-</td>
                    <td><?= tgl_indo($date); ?></td>
                    <td><?= $time12Hour; ?></td>
                    <td class="text-center"><?= $row["jumlah_kamar"]; ?></td>
                    <td class="p-1">
                      <?php if($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === NULL OR 'GAK VALID' AND $row['foto_bukti_transaksi'] === NULL):?>
                      <?php elseif($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === 'VALID'): ?>
                        <div class="data_foto" style="opacity: .8;">
                          <img src="../assets/images/payment.png" alt="">
                        </div>
                      <?php else : ?>
                        <div class="data_foto" style="cursor: pointer;">
                          <img src="../assets/foto_transaksi/<?php echo $row["foto_bukti_transaksi"] ?>" alt="" data-toggle="modal" data-target="#modalFoto_<?=$row["id_transaksi"];?>">
                        </div>
                      <?php endif; ?>
                    </td>
                    <td class="text-center p-1">
                      <?php if($row["status"] === "VALID") : ?>
                        <button type="button" class="btn btn-success rounded py-0 px-1"><i class="fas fa-check"></i> Diterima</button>
                      <?php elseif($row["status"] === null) : ?>
                        <button class="btn btn-outline-success rounded border-0" data-toggle="modal" data-target="#popUpReservasi_<?php echo $row["id_transaksi"] ?>"><i class="fas fa-check" style="font-size: 20px"></i></button>
                        <button class="btn btn-outline-danger rounded border-0" data-toggle="modal" data-target="#popUpReservasiGakvalid_<?php echo $row["id_transaksi"] ?>"><i class="fas fa-times" style="font-size: 20px"></i></button>
                      <?php elseif($row["status"] === "GAK VALID") : ?>
                        <button type="button" class="btn btn-danger rounded py-0" style="padding-left: 6px; padding-right: 6px;"><i class="fas fa-times"></i> Ditolak</button>
                      <?php endif; ?>
                    </td>
                    <td><?= $row["ket_transaksi"]; ?></td>
                    <td><?php echo tgl_indo($row['tgl_checkin']); ?></td>
                    <td><?php echo tgl_indo($row['tgl_checkout']); ?></td>
                    <td><?= $row["tipe_kamar"]; ?></td>
                  </tr>
                  <?php include 'modalFoto.php'; ?>
                  <?php include 'verifikasi_transaksi.php'; ?>
                  <?php include 'verifikasi_tidakValid.php'; ?>
                  <?php ++$i; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>    
      </div>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
    <!-- /#right-panel -->
    </div>
  <!-- Right Panel -->
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../assets/js/datepicker-id.js"></script>
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
    $('#StafTablesTransaksi').DataTable({
      "pagingType": "full_numbers",
      "processing": true,
      'language': {
        'emptyTable': 'Tidak ada data Transaksi ☹'
      },
      'columns': [
        null,
        null,
        null,
        null,
        null,
        null,
        { "orderable": false },
        { "orderable": false },
        null,
        null,
        null,
        null
      ],
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
      responsive: true,
      "order": []
    });
    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });
    // Cari transaksi
    $('#tgl_awal').datepicker({
      maxDate: '0',
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    });
    $('#tgl_akhir').datepicker({
      maxDate: '0',
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    });
    $('#tombolKecil').on('click', function () {
      $('#tombolBesar').toggleClass('d-block');
    });
    function clickCari() {
      if ($('#tombolBesar #tgl_akhir') == '') {
        $('#btnCariReservasi').prop('disabled', true);
      }else{
        $('#btnCariReservasi').prop('disabled', false);
      }
    };
    $(document).on('click','#btnCariReservasi', function () {
      $.ajax({
        type: 'POST',
        url: '../url_ajax/data_CariTransaksi.php',
        data: {tgl_awal : $('#tgl_awal').val(), tgl_akhir : $('#tgl_akhir').val()},
        success : function () {
          $('#load_HasilCari').load('../url_ajax/output_CariTransaksi.php');
        }
      })
    });
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
    };
    $n=1;
    foreach ($data_transaksi as $key) :
      if( isset($_POST["transaksiValid_".$n.""]) ) :
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
      ++$n;
    endforeach;
    $n=1;
    foreach ($data_transaksi as $key) :
      if( isset($_POST["transaksiGakValid_".$n.""]) ) :
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
      ++$n;
    endforeach;
  ?>
</body>
</html>