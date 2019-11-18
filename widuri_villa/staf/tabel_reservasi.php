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
  include '../query/queryDataDiri_pengguna.php';
  $input = "SELECT * FROM tbl_tamu";
  $hasil = mysqli_query($conn, $input);
  date_default_timezone_set('Asia/Singapore');
  $queKamar = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE jumlah_kamar > 0");
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
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="../vendors-2/selectFX/css/cs-skin-elastic.css">
  <link rel="stylesheet" href="../vendors-2/jqvmap/dist/jqvmap.min.css">
  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
    <link rel='stylesheet' href='../assets/css/jquery-ui.min.css'>
  <link rel="stylesheet" href="../assets-2/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css">


  <link rel="stylesheet" href="../assets-2/css/style.css">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body onload="disableButtonPesan(); disableCheck();" onchange="disableButtonPesan();">
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
              <a href="tabel_reservasi.php"> <i class="menu-icon fas fa-calendar-check"></i>Reservasi</a>
            </li>
            <li>
              <a href="tabel_tamu.php"> <i class="menu-icon fas fa-address-card"></i>Data Tamu</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"> <i class="menu-icon fas fa-home"></i>Data Tipe Kamar</a>
            </li>
            <li>
              <a href="tabel_transaksi.php"> <i class="menu-icon fas fa-credit-card"></i>Transaski Pembayaran</a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
    </aside><!-- /#left-panel -->

    <div id="right-panel" class="right-panel">

      <!-- HEADER -->
      <?php include '../header/headerStaf.php'; ?>
      <!-- /HEADER -->

      <div class="breadcrumbs shadow-sm">
        <div class="col-sm-4">
          <div class="page-header float-left">
            <div class="page-title">
              <h1>Reservasi</h1>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="index.php">Dashboard</a></li>
                  <li class="active">Reservasi</li>
                </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 mb-3">

        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm">
          <button class="btn btn-primary mb-3 shadow-sm btn-tmbh" data-toggle="modal" data-target="#popup_tambahReservasi"><i class="fas fa-plus"></i></button>
          <!-- data-backdrop="static" data-keyboard="false" -->
          <table id="StafTablesReservasi" class="table table-hover table-responsive" width="100%">
            <thead class="thead-dark">
              <tr class="text-nowrap text-center">
                <th class="d-none"></th>
                <th>Id Res</th>
                <th>Status</th>
                <th>Nama staf</th>
                <th>Nama Tamu</th>
                <th>Checkin</th>
                <th>Checkout</th>
                <th>J. Hari</th>
                <th>J. Dewasa</th>
                <th>J. Anak</th>
                <th>Aksi</th>
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
                    $jam_reservasi = date_format(new Datetime($row["jam_reservasi"]), "Y-m-d");
                  ?>
                  <tr class="text-nowrap text-center">
                    <td class="d-none"></td>
                    <td>RSV-0<?php echo $row['id_reservasi']; ?></td>
                    <td class="text-center">
                      <?php include 'statusReservasi.php'; ?>
                    </td>
                    <td><?php echo $row["username_pengguna"]; ?></td>
                    <td><?php echo $row['nama_tamu']; ?></td>
                    <td class="text-nowrap"><?php echo $row['tgl_checkin']; ?></td>
                    <td class="text-nowrap"><?php echo $row['tgl_checkout']; ?></td>
                    <td><?php echo $row['jumlah_hari']; ?></td>
                    <td><?php echo $row['jumlah_orang']; ?></td>
                    <td><?php echo $row['jumlah_anak']; ?></td>
                    <td class="text-nowrap" align="center">
                      <?php if($statusRes === "VALID" OR $statusRes === "GAK VALID") : ?>
                      <?php else : ?>
                        <button class='btn btn-light px-1 py-0 rounded' data-toggle='modal' data-target='#popup_ubah_<?=$row["id_reservasi"]?>'><span data-toggle="tooltip" title="Ubah data reservasi"><i class='fas fa-edit text-primary'></i></span>
                        </button>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php
                  $no++;
                  // include 'modal_ubah_reservasi.php';
                }
              ?>
            </tbody> 
          </table>
        </div>    
      </div>
      <!-- Gak pake ajax -->
      <?php if (isset($_POST["submitCreateSessionTamu"]) && $_POST["nama_tamu"] !== '') {
        $aa = $_POST["nama_tamu"];
        echo "
        <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
        <script type='text/javascript' src='../assets-2/bootstrap_4.3.1/js/bootstrap.js'></script>
        <script>
          $(window).on('load', function(){
            $('#popupTambah_Reservasi').modal({backdrop: 'static', keyboard: false});
            $('#popup_tambah_tamu').modal('show');
          });
        </script>";
      } ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_tambah_reservasi2.php'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
      <?php include 'modal_PilihKamar.php'; ?>
    </div>
  </div>

  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script src="../assets/js/jquery.waypoints.min.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    $('.btnClose').click(function() {
      window.location.replace("tabel_reservasi.php");
    });
    $('#StafTablesReservasi').DataTable({
      "columnDefs": [ {
        "targets": 3,
        "visible" : false,
        "searchable": true
      } ],
      "pagingType": "full_numbers",
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
        { 'orderable': false }
      ]
    });
    $('#menuToggle').click(function() {
      $('.menu-admin').toggleClass('hide');
    });
    function makeSession() {
      if ($('#selectIDtamu').val() !== '') {
        $('#submitCreateSessionTamu').removeClass('d-none');
      }else{
        $('#submitCreateSessionTamu').addClass('d-none');
      }
    };
    function hitung(){
      var JmlHari = Number($('#jumlahHari').val());
      var TotHarga=0;
      var TotKamar=0;
      <?php $i = 1; ?>
      <?php foreach ($queKamar as $key): ?>
        var JmlKamar<?=$i;?> = Number($('#Kamar<?=$i;?>').val());
        var hargaKamar_tipe<?=$i;?> = Number($('#hargaPerKamar<?=$i;?>').val());
        TotHarga = TotHarga+(JmlKamar<?=$i;?> * hargaKamar_tipe<?=$i;?>);
        TotKamar = TotKamar+JmlKamar<?=$i;?>;
        if ($('#Kamar<?=$i?>').val() == 0) {
          document.getElementById("btnKamar_<?=$i?>").checked = false;
          document.getElementById("Kamar<?=$i?>").disabled = true;
        };
      <?php ++$i; ?>
      <?php endforeach; ?>
      var total_Harga = TotHarga * JmlHari;
      $('#total_harga').val(formatRupiah(total_Harga,' '));
      $('#jmlKamar').val(TotKamar);
    };
    <?php $i = 1; ?>
    <?php foreach ($queKamar as $key): ?>          
      var checkboxes<?=$i;?> = $("#btnKamar_<?=$i;?>"),
      submitButt<?=$i;?> = $("#Kamar<?=$i;?>");
      checkboxes<?=$i;?>.click(function() {
        submitButt<?=$i;?>.attr("disabled", !checkboxes<?=$i;?>.is(":checked"));
      });
      checkboxes<?=$i;?>.change(function() {
        if (checkboxes<?=$i;?>.is(":checked")) {
          document.getElementById('Kamar<?=$i?>').value = 1;
        } else 
          document.getElementById('Kamar<?=$i?>').value = 0;
      });
    <?php ++$i; ?>
    <?php endforeach; ?>
    function disableButtonPesan() {
      var ttHarga = document.getElementById('total_harga');
      if (ttHarga.value === "0") {
        $('#btnPesan_reservasi').attr("disabled","disabled");
      }else{
        $('#btnPesan_reservasi').removeAttr("disabled","disabled");
      }
    };
    function disableCheck() {
      if($('#TM').val()==='' || $('#TK').val()===''){
        $('.checkbox-custom input[type=checkbox]').prop('disabled', true);
      }else{
        $('.checkbox-custom input[type=checkbox]').prop('disabled', false);
      }
    }
    // DatePick
    $('#TM').datepicker({
      minDate : 0,
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
    });
    $('#TK').datepicker({
      minDate : 0,
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
    });
    $('#TM').datepicker().bind("change", function () {
      var minValue = $(this).val();
      minValue = $.datepicker.parseDate("dd-mm-yy", minValue);
      $('#TK').datepicker("option", "minDate", minValue);
      calculate();
    });
    $('#TK').datepicker().bind("change", function () {
      var maxValue = $(this).val();
      maxValue = $.datepicker.parseDate("dd-mm-yy", maxValue);
      $('#TM').datepicker("option", "maxDate", maxValue);
      calculate();
    });
    function calculate() {
      var d1 = $('#TM').datepicker('getDate');
      var d2 = $('#TK').datepicker('getDate');
      var oneDay = 24*60*60*1000;
      var diff = 0;
      if (d1 && d2) {
        diff = Math.round(Math.abs((d2.getTime() - d1.getTime())/(oneDay)));
      }
      $('#jumlahHari').val(diff);
    };
    function formatRupiah(angka, prefix){
      var number_string = angka.toString().replace(/[^,\d]/g, ''),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah      = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    };
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
    if (isset($_POST["submitTambahReservasi"])) {
      if () {
        # code...
      }
    }
  ?>

</body>

</html>