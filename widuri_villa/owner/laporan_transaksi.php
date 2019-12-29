<?php 
  session_start();
  date_default_timezone_set('Asia/Makassar');
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
    WHERE CURDATE() <= tgl_checkout AND `status` IS NOT NULL
    ORDER BY id_transaksi DESC
  ");
  include '../query/queryDataDiri_pengguna.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan Transaksi</title>
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
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css">
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
      <div class="breadcrumbs shadow-sm">
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
                <li class="active">Lap. Transaksi</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm">
          <div class="row">
            <div class="col-12">
              <div class="col px-1"> <!-- 1 -->
                <div class="col-sm-auto px-0">
                  <div class="input-group input-group-sm mb-2 peri_trans">
                    <input id="Awal_trans" type="text" class="form-control" placeholder="Periode awal" autocomplete="off">
                  </div>
                </div>
                <div class="col-sm-auto mt-1 px-2 d-none d-lg-block">
                  <span>s/d</span>
                </div>
                <div class="col-sm-auto px-0">
                  <div class="input-group input-group-sm mb-2 peri_trans">
                    <input id="Akhir_trans" type="text" class="form-control" placeholder="Periode akhir" autocomplete="off">
                    <div class="input-group-append">
                      <button class="btn btn-primary px-3" type="button" id="btnSearchTransaksi" disabled title="Cari tanggal"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-auto px-1 ml-sm-1" id="btnPrintTrans">
                <a href="print_laptransaksi.php" target="_blank" class="btn btn-secondary btn-sm shadow-sm rounded px-3">PRINT&nbsp;&nbsp;<i class="fas fa-external-link-alt"></i></a>
              </div>
            </div>
          </div>
          <div class="table-responsive pt-2 px-1 rounded" style="z-index: 9" id="load_HasilCari">
            <table id="OwnerTablesTransaksi" class="table rounded dt-responsive table-hover nowrap" width="100%">
              <thead class="thead-dark">
                <tr class="text-nowrap">
                  <th data-priority="1">ID Trans</th>
                  <th data-priority="2">Nama Tamu</th>
                  <th data-priority="3">Total Bayar</th>
                  <th data-priority="4">Tgl Transaksi</th>
                  <th data-priority="5" class="text-center">Jam</th>
                  <th data-priority="6" class="text-center">Qty. Kam</th>
                  <th data-priority="7" class="text-left">Bukti</th>
                  <th data-priority="8" class="text-center">Status</th>
                  <th data-priority="9">Ket</th>
                  <th data-priority="10">Aksi</th>
                  <th>CheckIn</th>
                  <th>Checkout</th>
                  <th>Tipe Kamar</th>
                  <th>Email</th>
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
                    <td>Rp.<?=number_format($row["total_pembayaran_kamar"],2,',','.'); ?>,-</td>
                    <td><?=tgl_indo($date); ?></td>
                    <td><?=$time12Hour; ?></td>
                    <td class="text-center"><?= $row["jumlah_kamar"]; ?></td>
                    <td class="p-1">
                      <?php if($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === NULL OR 'GAK VALID' AND $row['foto_bukti_transaksi'] === NULL):?>
                      <?php elseif($row['foto_bukti_transaksi'] === '-.png' AND $row['status'] === 'VALID'): ?>
                        <div class="data_foto" style="opacity: .8;">
                          <img src="../assets/images/payment.png" alt="">
                        </div>
                      <?php else : ?>
                        <div class="data_foto" style="cursor: pointer;">
                          <img src="../assets/foto_transaksi/<?=$row["foto_bukti_transaksi"] ?>" alt="" data-toggle="modal" data-target="#modalFoto_<?=$row["id_transaksi"];?>">
                        </div>
                      <?php endif; ?>
                    </td>
                    <td class="text-center p-1">
                      <?php if($row["status"] === "VALID") : ?>
                        <button type="button" class="btn btn-success rounded py-0 px-1"><i class="fas fa-check"></i> Diterima</button>
                      <?php elseif($row["status"] === null) : ?>
                        <button class="btn btn-outline-success rounded border-0" data-toggle="modal" data-target="#popUpReservasi_<?=$row["id_transaksi"] ?>"><i class="fas fa-check" style="font-size: 20px"></i></button>
                        <button class="btn btn-outline-danger rounded border-0" data-toggle="modal" data-target="#popUpReservasiGakvalid_<?=$row["id_transaksi"] ?>"><i class="fas fa-times" style="font-size: 20px"></i></button>
                      <?php elseif($row["status"] === "GAK VALID") : ?>
                        <button type="button" class="btn btn-danger rounded py-0" style="padding-left: 6px; padding-right: 6px;"><i class="fas fa-times"></i> Ditolak</button>
                      <?php endif; ?>
                    </td>
                    <td><?=$row["ket_transaksi"]; ?></td>
                    <td class="py-1"><a href="print_transaksiindv.php?id=<?=$row['id_transaksi']; ?>" target="_blank" class='btn btn-secondary px-2 py-1 rounded'><span><i class='fas fa-print'></i></span></a></td>
                    <td><?=tgl_indo($row['tgl_checkin']); ?></td>
                    <td><?=tgl_indo($row['tgl_checkout']); ?></td>
                    <td><?=$row['tipe_kamar'];?></td>
                    <td><?=$row['email_tamu'];?></td>
                  </tr>
                  <?php include '../staf/modalFoto.php'; ?>
                  <?php ++$i; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>    
      </div>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriOwner.php'; ?>
    </div>
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
  <script type="text/javascript" src='../assets/js/sweetalert2.min.js'></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    var laporan_transaksi = $('#OwnerTablesTransaksi').DataTable({
      "pagingType": "full_numbers",
      "processing": true,
      'language': {
        'emptyTable': 'Tidak ada untuk ditampilkan.'
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
    if ( ! laporan_transaksi.data().any() ) {
      $('#btnPrintTrans').fadeOut();
    }else{
      $('#btnPrintTrans').fadeIn();
    };
    // value cico
    $('.peri_trans input').on('change',function() {
      var empty = false;
      $('.peri_trans input').each(function() {
        if ($(this).val().length == 0) {
          empty = true;
        }
      });
      if (empty) {
        $('#btnSearchTransaksi').prop('disabled', true);
      } else {
        $('#btnSearchTransaksi').prop('disabled', false);
      }
    });
    // AJAX
    $('#btnSearchTransaksi').on('click', function () {
      $.ajax({
        type: 'POST',
        data: {awal_trans : $('#Awal_trans').val(), akhir_trans : $('#Akhir_trans').val()},
        url: '../url_ajax/data_LaporanTransaksi.php',
        success: function () {
          $('#load_HasilCari').load('../url_ajax/output_LaporanTransaksi.php');
        }
      })
    });
    $('#btnPrintTrans').on('click', function () {
      if ($('#Awal_trans').val() === '' || $('#Akhir_trans').val() === '') {
        <?php
          if(!empty($_SESSION['perioAwalTrans']) OR !empty($_SESSION['perioAkhirTrans'])){
            unset($_SESSION['perioAwalTrans'], $_SESSION['perioAkhirTrans']);
          }
        ?>
      }
    })
    $('#Awal_trans').datepicker({
      maxDate: '0',
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    });
    $('#Akhir_trans').datepicker({
      maxDate: '0',
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    });
    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });
  </script>
  <?php
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
              window.location.href = 'laporan_transaksi.php';
            });
          </script>
        ";
      }
    }
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
              window.location.href = 'laporan_transaksi.php';             
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
              window.location.href = 'laporan_transaksi.php';             
            });
          </script>
        ";
      }
    }
  ?>
</body>
</html>