<?php
  session_start();
  if ( empty($_SESSION["loggedin_pengguna"]) ) {
    header('location: ../login/login.php');
  }
  elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "admin") ) {
    header('location: ../admin/index.php');
    exit;
  }
  date_default_timezone_set('Asia/Singapore');
  $id = $_SESSION["loggedin_pengguna"]["id_pengguna"];
  $emailnya = $_SESSION["loggedin_pengguna"]["email"];
  $levelnya = $_SESSION["loggedin_pengguna"]["level_pengguna"];
  require '../koneksi/function_global.php';
  include '../query/queryDataDiri_pengguna.php';
  $input = "SELECT * FROM tbl_tamu";
  $hasil = mysqli_query($conn, $input);
  $queKamar = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE jumlah_kamar > 0");
  setlocale (LC_TIME, "ID_id");
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
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.min.css">
  <link rel='stylesheet' type="text/css" href='../assets/css/sweetalert2.min.css'>
  <link rel='stylesheet' type="text/css" href='../assets/css/jquery-ui.min.css'>
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body onload="disableButtonPesan(); disableButtonPesan2(); disableCheck(); disableCheck2();" onchange="disableButtonPesan(); disableButtonPesan2(); disableCheck2();">
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
            <h3 class="menu-title">MASTER DATA</h3>
            <li class="active">
              <a href="tabel_reservasi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-calendar-check"></i></div>Reservasi</a>
            </li>
            <li>
              <a href="tabel_transaksi.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-credit-card"></i></div>Transaski Pembayaran</a>
            </li>
            <li>
              <a href="tabel_tipeKamar.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-home"></i></div>Data Tipe Kamar</a>
            </li>
            <li>
              <a href="tabel_tamu.php"><div class="d-flex justify-content-center"><i class="menu-icon fas fa-address-card"></i></div>Data Tamu</a>
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
      <div class="col-sm-12 mb-2 mt-1">
        <div class="p-2 bg-white border rounded mb-5 overflow-hidden wrapper-table shadow-sm position-relative">
          <div>
            <div class="col-md-3 px-1">
              <button class="btn btn-primary mb-1 shadow-sm btn-tmbh" data-toggle="modal" data-target="#popup_tambahReservasi"><i class="fas fa-plus"></i></button>
              <button id="tombolKecil" class="btn btn-primary rounded mb-1"><i class="fas fa-search"></i> Reservasi</button>
            </div>
            <div class="col-md-9 px-1">
              <div class="d-flex justify-content-end">
                <div id="tombolBesar" class="form-row align-items-center">
                  <div class="col-md-5">
                    <div class="input-group">
                      <input type="text" class="form-control pem" placeholder="Checkin" id="tgl_awal" readonly style="font-size: 15px">
                    </div>
                  </div>
                  <div class="d-flex justify-content-center align-items-center col-sm-1 px-0 strip">
                    <i class="fas fa-minus text-secondary"></i>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <input type="text" class="form-control pem" placeholder="Checkout" id="tgl_akhir" readonly style="font-size: 15px" onchange="clickCari()">
                      <div class="input-group-append">
                        <button id="btnCariReservasi" class="btn btn-primary rounded-right" type="button" disabled><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive py-1 px-1" id="load_HasilCari">
            <table id="StafTablesReservasi" class="table rounded dt-responsive table-hover nowrap" width="100%">
              <thead class="thead-dark">
                <tr class="text-nowrap text-center">
                  <th>Id Res</th>
                  <th>Nama Tamu</th>
                  <th>Email Tamu</th>
                  <th>Status</th>
                  <th>Nama staf</th>
                  <th>Checkin</th>
                  <th>Checkout</th>
                  <th>J. Hari</th>
                  <th>Tipe Kamar</th>
                  <th>Qty /Kam</th>
                  <th>Aksi</th>
                  <th>J. Dewasa</th>
                  <th>J. Anak</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql = query("SELECT tbl_reservasi.*, tbl_tamu.*, tbl_pengguna.*
                    FROM tbl_reservasi
                    LEFT JOIN tbl_pengguna ON tbl_reservasi.id_pengguna = tbl_pengguna.id_pengguna
                    LEFT JOIN tbl_tamu ON tbl_reservasi.id_tamu = tbl_tamu.id_tamu
                    WHERE CURDATE() <= tgl_checkout
                    ORDER BY id_reservasi DESC
                  ");
                  // $qq = query("SELECT * FROM tbl_transaksi_pembayaran");
                  $no=1;
                    foreach ($sql as $row) :
                      $jam_reservasi = date_format(new Datetime($row["jam_reservasi"]), "Y-m-d");
                    ?>
                    <tr class="text-nowrap text-center">
                      <td>RSV-0<?php echo $row['id_reservasi']; ?></td>
                      <td><?php echo $row['nama_tamu']; ?></td>
                      <td><?=$row['email_tamu'] ?></td>
                      <td class="text-center">
                        <?php include 'statusReservasi.php'; ?>
                      </td>
                      <td><?php echo $row["username_pengguna"]; ?></td>
                      <td class="text-nowrap"><?php echo tgl_indo($row['tgl_checkin']); ?></td>
                      <td class="text-nowrap"><?php echo tgl_indo($row['tgl_checkout']); ?></td>
                      <td><?php echo $row['jumlah_hari']; ?></td>
                      <td><?=$row['tipe_kamar'];?></td>
                      <td><?=$row['jumlah_kamar_perPilihan'];?></td>
                      <td class="text-nowrap p-1" align="center">
                        <?php if($statusRes === "GAK VALID" OR date("Y-m-d") > $row['tgl_checkout']) : ?>
                          <button style="cursor: not-allowed;" disabled class='btn btn-primary px-2 py-1 rounded' ><span><i class='fas fa-edit'></i></span></button>
                        <?php else : ?>
                          <div class="px-1 py-0 rounded" data-toggle="popover" title="PERHATIAN!" data-content="Dengan menekan tombol <span class='btn btn-primary py-0 px-1 rounded'><i class='fas fa-edit'></i></span>, maka jumlah kamar akan kembali sesuai dengan data terpilih, atau bahkan bisa berkurang!" tabindex="0" data-trigger="focus hover">
                            <form method="POST" action="">
                              <input type="hidden" name="id_reservasi" value="<?=$row['id_reservasi'] ?>">
                              <input type="hidden" name="id_kamar" value="<?=$row['tipe_kamar'] ?>">
                              <input type="hidden" name="jumlahKamarTerpilih" value="<?=$row['jumlah_kamar_perPilihan'] ?>">
                              <button type="submit" name="tabelEditKamar_<?=$no?>" class='btn btn-primary px-2 py-1 rounded' ><span><i class='fas fa-edit'></i></span>
                              </button>
                            </form>
                            <?php
                              if(isset($_POST["tabelEditKamar_".$no.""])) {
                                if (UbahReservasi($_POST) >= 0) {
                                  echo "
                                  <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
                                  <script type='text/javascript' src='../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js'></script>
                                  <script>
                                    $(window).on('load', function(){
                                      $('#popupUbah_Reservasi_".$row['id_reservasi']."').modal({backdrop: 'static', keyboard: false});
                                    });
                                  </script>";
                                }
                              }
                            ?>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td><?php echo $row['jumlah_orang']; ?></td>
                      <td><?php echo $row['jumlah_anak']; ?></td>
                    </tr>
                    <?php
                    include 'modal_Ubah_PilihKamar.php';
                    ++$no;
                  endforeach;
                ?>
              </tbody> 
            </table>
          </div>
        </div>    
      </div>
      <?php
        if (isset($_POST["submitCreateSessionTamu"]) && $_POST["nama_tamu"] !== '') {
          $aa = $_POST["nama_tamu"];
          echo "
          <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
          <script type='text/javascript' src='../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js'></script>
          <script>
            $(window).on('load', function(){
              $('#popupTambah_Reservasi').modal({backdrop: 'static', keyboard: false});
            });
          </script>";
        }
        if( isset($_POST["submit"]) ) {
          if( stafTambahTamu($_POST) > 0 ) {
            $aa = $_SESSION["getIDTAMU"];
            echo "
            <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
            <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
            <script type='text/javascript' src='../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js'></script>
            <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
            <script>
              $(window).on('load', function(){
                $('#popupTambah_Reservasi').modal({backdrop: 'static', keyboard: false});
              });
            </script>";
          } else {
            echo "
              <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
              <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
              <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
              <script>
                Swal.fire({
                  type: 'error',
                  title: 'Gagal menambah data!',
                  showConfirmButton: false,
                  timer: 2000
                }).then(function() {
                  window.location.replace('tabel_reservasi.php');
                });
              </script>
            ";
          }
        }
      ?>
      <?php include '../footer/footer.html'; ?>
      <?php include 'modal_tambah_reservasi2.php'; ?>
      <?php include 'modal_ubah_password.php'; ?>
      <?php include 'modalUbah_DataDiriStaf.php'; ?>
      <?php include 'modal_PilihKamar.php'; ?>
      <?php include 'modal_tambah_tamu.php'; ?>
    </div>
  </div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../assets/js/datepicker-id.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="../assets-2/js/responsive.bootstrap4.min.js"></script>
  <script type="text/javascript" src="../assets/js/jquery.waypoints.min.js"></script>
  <script type="text/javascript" src='../assets/js/sweetalert2.min.js'></script>
  <script type="text/javascript" src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.min.js"></script>
  <?php include 'confirmLogout.php'; ?>
  <script>
    $('.btnClose').on('click', function() {
      $('#popupTambah_Reservasi').on('hidden.bs.modal', function () {
        window.location.replace('tabel_reservasi.php');
      });
      <?php foreach ($sql as $row): ?>
        $('#popupUbah_Reservasi_<?=$row['id_reservasi']?>').on('hidden.bs.modal', function () {
          window.location.replace('tabel_reservasi.php');
        });
      <?php endforeach ?>
    });
    $('#StafTablesReservasi').DataTable({
      "columnDefs": [ {
        "targets": [2, 4],
        "visible" : false,
        "searchable": true
      } ],
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
        { 'orderable': false },
        null,
        { 'orderable': false }
      ],
      "processing": true,
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
      responsive: true,
      "pagingType": "full_numbers",
      "order": []
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
      $('#total_harga_duplicate').val(formatRupiah(total_Harga,' '));
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
      if (ttHarga.value <= 0) {
        $('#btnPesan_reservasi').attr("disabled","disabled");
      }else{
        $('#btnPesan_reservasi').removeAttr("disabled","disabled");
      }
    };
    function disableCheck() {
      var ttHargacheck = document.getElementById('total_harga');
      <?php $i=1; ?>
      <?php foreach ($queKamar as $key): ?>
        if(ttHargacheck <= 0){
          $('#btnKamar_<?=$i;?>').attr("disabled",true);
        }else{
          $('#btnKamar_<?=$i;?>').removeAttr("disabled");
        }
        <?php $i++; ?>
      <?php endforeach; ?>
    };
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
    $('#TambahTamu').on('click',function () {
      $('#popup_tambahReservasi').modal('hide');
      $('#popup_tambah_tamu').modal({backdrop: 'static', keyboard: false});
    });
    $('#tgllahir').datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "-150:+0",
    });
    // Cari reservasi
    $('#tgl_awal').datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    });
    $('#tgl_akhir').datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
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
    $(document).ready(function () {
      $('#btnCariReservasi').on('click', function () {
        $.ajax({
          type: 'POST',
          url: '../url_ajax/data_CariReservasi.php',
          data: {tgl_awal : $('#tgl_awal').val(), tgl_akhir : $('#tgl_akhir').val()},
          success : function () {
            $('#load_HasilCari').load('../url_ajax/output_CariReservasi.php');
          }
        })
      })
    });
  </script>
  <?php include '../assets/js/ubahReservasi.php'; ?>
  <?php
    if (isset($_POST["submitTambahReservasi"])) {
      if (ReservasiTambah($_POST) > 0) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil ditambahkan!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              window.location.replace('tabel_reservasi.php');
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
              window.location.href = 'tabel_reservasi.php';
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
    $n=1;
    foreach ($sql as $key) {
      if (isset($_POST["submitEditReservasi_".$n.""])) {
        if (ReservasiUbah($_POST) > 0) {
          echo "
            <script>
              Swal.fire({
                type: 'success',
                title: 'Data reservasi berhasi diubah.',
                showConfirmButton: false,
                timer: 2000
                }).then(function() {
                window.location.replace('tabel_reservasi.php');
              });
            </script>
          ";
        }else{
          echo "
            <script>
              Swal.fire({
                type: 'error',
                title: 'Data reservasi gagal diubah!',
                showConfirmButton: false,
                timer: 2000
                }).then(function() {
                window.location.replace('tabel_reservasi.php');
              });
            </script>
          ";
        }
      }
      $n++;
    }
  ?>
</body>

</html>