<?php
  session_start();

  $inactive = 7200;
  if( !isset($_SESSION['timeout']) )
  $_SESSION['timeout'] = time() + $inactive; 
  $session_life = time() - $_SESSION['timeout'];
  if($session_life > $inactive)
  {  session_destroy(); header("Location:../index.php"); }
  $_SESSION['timeout']=time();

  if (empty($_SESSION["pilihanKamar"])) :
    header("location:../index.php");
  endif;
  // Set TimeZone
  date_default_timezone_set('Asia/Singapore');
  $jamSekarang = date('Y-m-d H:i:s a', time());

  $tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
  $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
  $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
  $adlt = $_SESSION["pilihanKamar"]["adt"];
  $cild = $_SESSION["pilihanKamar"]["cld"];
  $total_harga = $_SESSION["pilihanKamar"]["total_harga"];
  $jumlah_kamar = $_SESSION["pilihanKamar"]["jumlah_kamar"];
  $bank = $_SESSION["bank"]["pilih"];

  require '../koneksi/function_global.php';

  if (!empty($_SESSION["loggedin"])) :
    $id = $_SESSION["loggedin"]["id_tamu"];
    $cekTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE id_tamu = '$id'");
    if (mysqli_num_rows($cekTamu) === 1 ) :
      $rowT = mysqli_fetch_assoc($cekTamu);
      $fotoT = $rowT["foto_tamu"];
    endif;
  else:
    header('location:verify/login.php');
  endif;

  $dataTipeKamar = query("SELECT * FROM tbl_tipe_kamar WHERE jumlah_kamar > 0");

  $cekKamar = mysqli_query($conn,"SELECT * FROM tbl_tipe_kamar");
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Widuri Villa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/logo-w.png">
    <link rel="stylesheet" href="../assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../assets/css/lightgallery.min.css">
    <link rel="stylesheet" href="../assets/css/lg-transitions.css">
    <link rel="stylesheet" href="../assets/css/aos.css">
    <link rel="stylesheet" href="../assets/css/ionicons.min.css">
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <link rel="stylesheet" href="../assets/css/icomoon.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome-free-5.10.2-web/css/all.css">
    <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">  
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  </head>
  <body>  
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light pembayaran-header" id="ftco-navbar">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"><img src="../assets/images/logo.png" alt="widuri" width="79.5px" height="50px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="../index.php#home" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="../index.php#about" class="nav-link">About</a></li>
            <li class="nav-item"><a href="../index.php#features" class="nav-link">Features</a></li>
            <li class="nav-item"><a href="../index.php#gallery" class="nav-link">Gallery</a></li>
            <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
          </ul>
          <?php
            if(empty($_SESSION["loggedin"])) : ?>
              <div class='d-flex align-items-center justify-content-center logis'>
                <a href='login.php'><h6 class='mb-0 btn btn-primary'>Login</h6></a>
                <a href='register.php'><h6 class='mb-0 btn btn-primary' style='padding-left: 10px;'>Register</h6></a>
              </div>
            <?php else :  ?>
              <div class='dropdown tamu-user'>
                <div class='wrapper-avatar--2 dropdown-toggle' data-toggle='dropdown' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                  <?php if($fotoT === "") : ?><img src='../assets/images/user.png' alt=''><?php else : ?><img src='../assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
                </div>
                <div class='dropdown-menu dropdown-menu-right shadow' aria-labelledby='navbarDropdown'>
                  <a href='user_ubah.php?id=<?=$id?>' class='dropdown-item'><i class='fas fa-cog'></i> Ubah akun</a>
                  <a href='user_ubah_password.php?id=<?=$id?>' class='dropdown-item'><i class='fas fa-key'></i> Ganti password</a>
                  <a href='logout.php' class='dropdown-item'><i class='fas fa-sign-out-alt'></i> Logout</a>
                </div>
              </div>
            <?php endif;
          ?>
        </div>
      </div>
    </nav>
    <!-- END nav -->
    <!-- pilihan kamar -->
    <section class="page-section ftco-section ftco-no-pb">
      <div class="container container-pembayaran">
        <div class="row">
          <div class="col-md-12 heading-section ftco-animate">
            <h2 class="mb-1">Pesanan</h2>
            <a class="text-primary" href="metodePembayaran.php" style="font-size: 20px"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 ftco-animate mb-3">
            <div id="contentOne" class="card border rounded p-3 b-top-content" tabindex="-1">
              <div class="row">
                <div class="col">
                  <h3>Informasi</h3>
                  <div class="d-flex justify-content-between border-bottom">
                    <h5><i class="fas fa-info-circle text-danger"></i> Harap upload bukti transaksi dalam waktu <span class="text-danger">dua jam</span> !</h5>
                  </div>
                  <div class="d-flex justify-content-between align-items-center py-2 border-bottom bg-light px-2">
                    <?php if ($bank ==="bca"): ?>
                      <h5 class="pt-2">Bank Central Asia</h5>
                    <?php elseif($bank ==="mandiri") : ?>
                      <h5 class="pt-2">Bank Mandiri</h5>
                    <?php elseif($bank ==="bri") : ?>
                      <h5 class="pt-2">BRI</h5>
                    <?php elseif($bank ==="bni") : ?>
                      <h5 class="pt-2">BNI</h5>
                    <?php endif ?>
                    <img src="../assets/images/<?=$bank?>.png" alt="">
                  </div>
                  <table>
                    <tr>
                      <th class="p-3">Nomor Rekening</th>
                      <td class="p-3">:</td>
                      <td class="p-3">--- --- ----</td>
                    </tr>
                    <tr>
                      <th class="p-3">Pemilik</th>
                      <td class="p-3">:</td>
                      <td class="p-3">Widuri Villa</td>
                    </tr>
                  </table>
                  <div class="col-md-12 d-flex justify-content-center rounded">
                    <label id="BungkusFoto" for="img1" class="img-fluid col-sm-7 wrapper-transaksi border d-flex  justify-content-center align-items-center rounded uploadGambar shadow-sm" style="height: 400px; cursor: pointer;" title="Anda dapat mengunggah gambar sampai dengan 3MB" data-toggle="tooltip" data-placement="top">
                      <div class="position-absolute" id="UlangInputFotoBukti" style="z-index: 9; right: 5px; top: 5px; display: none;">
                        <button onclick="Eraser();" type="button" title="Ulangi input foto?" data-toggle="tooltip" data-placement="top" class="btn btn-light py-0 px-2" style="font-size: 20px; background-color: rgba(255,255,255,.7);">
                          <i class="fas fa-times text-danger"></i>
                        </button>
                      </div>
                      <div>
                        <p id="titlePanduan" class="text-center">Tekan tombol "UPLOAD BUKTI" / Klik di sini untuk upload. <span class="font-weight-bold text-secondary">Foto diharapkan <a href="https://translate.google.com/translate?u=https://en.wikipedia.org/wiki/Page_orientation&hl=id&sl=en&tl=id&client=srp" class="text-secondary">berorientasi potrait!</a></span></p>
                      </div>
                      <img id="preview-img1" height="300px" width="auto" alt=" " style="display: none" />
                    </label>
                  </div>
                  <div class="col text-center mt-2">
                    <label for="img1" class="btn btn-primary mb-0" style="cursor: pointer;"><i class="fas fa-file-upload"></i> UPLOAD BUKTI</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- your reservation -->
          <div class="col-lg-4 ftco-animate">
            <div id="contentTwo" class="card border p-4 mb-2 b-top-content" tabindex="-1">
              <button class="btn btn-light text-primary position-absolute px-2 py-1 shadow-sm" onclick="ConfirmEditReservasi();" data-toggle="tooltip" data-placement="top" title="Ubah data reservasi" style="right: 5px; top: 5px; font-size: 20px"><i class="fas fa-pen"></i></button>
              <h2 class="text-center border-bottom pb-4">Reservasi Anda</h2>



              
              <!--/////////////////////////////////////////-->
              <!--             FORM RESERVASI              -->
              <!--/////////////////////////////////////////-->
              
              <form action="" method="POST" id="FORM_INPUT_RESERVASI" enctype="multipart/form-data">
                <input type="hidden" name="tipe_kamar" value="1">
                <input type="hidden" value="<?php echo $id ?>" name="id_tamu">
                <input type="hidden" name="ketRes_Tamu" value="Online">
                <input type="file" onchange="hideTitle(); UnDisable();" id="img1" class="FotoUpload d-none" name="inp_bukti_pembayaran">

                <div class="form-group">
                  <label for="total_harga" style="font-size: 20px">Total</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-light">Rp</span>
                    </div>
                    <input type="text" name="inp_totalHarga" class="form-control pem" id="total_harga" readonly style="font-weight: bold; font-size: 20px" name="total_harga" <?php if (!empty($_SESSION["pilihanKamar"]["total_harga"])) :?> value="<?php echo $total_harga ?>"<?php else: ?><?php endif; ?>>
                  </div>
                </div>

                <div class="form-group">
                  <label for="tgl_c1" class="mb-0">Checkin</label>
                  <input type="text" id="TM" class="form-control pem inputangka inputangka border-top-0 border-right-0 pt-0 border-left-0" value="<?php echo $tglCI ?>" onchange="hitungHari()" name="inp_CekIn" readonly>
                </div>

                <div class="form-group">
                  <label for="tgl_co" class="mb-0">Checkout</label>
                  <input type="text" id="TK" class="form-control pem inputangka border-top-0 border-right-0 border-left-0" value="<?php echo $tglCO ?>" onchange="hitungHari()" name="inp_CekOut" readonly>
                </div>

                <div class="form-group">
                  <label for="jml_adlt" class="mb-0">Dewasa</label>
                  <input type="text" value="<?php echo $adlt ?>" id="jml_adlt" name="inp_orgDewasa" class="form-control pem border-top-0 border-right-0 border-left-0" readonly>
                </div>

                <div class="form-group">
                  <label for="jml_ank" class="mb-0">Anak-anak</label>
                  <input type="text" value="<?php echo $cild ?>" id="jml_ank" name="inp_Anak" class="form-control pem border-top-0 border-right-0 border-left-0" readonly>
                </div>

                <div class="form-group">
                  <label for="jmlKamar">Jumlah kamar</label>
                  <input type="text" id="jmlKamar" class="form-control pem border-top-0 border-right-0 border-left-0"  value="<?php echo $jumlah_kamar ?>" name="jumlah_kamar" readonly>
                </div>

                <div class="form-group">
                  <label class="mb-0">Jumlah hari</label>
                  <input type="text" id="jumlahHari" name="inp_totalTtanggal" value="<?php echo "$jmlHari" ?>" class="form-control pem inputangka border-top-0 border-right-0 border-left-0" readonly>
                </div>
                <button type="submit" id="BTN_PESANRESERVASI" name="BTN_PESANRESERVASI" class="btn btn-primary col px-0 py-2 mt-3 font-weight-bold" disabled>PROSES PESANAN</button>
              </form>

              <!--/////////////////////////////////////////-->
              <!--            /FORM RESERVASI              -->
              <!--/////////////////////////////////////////-->




            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Fasility -->
    <?php include '../footer/footer-tamu.php'; ?>
    <?php include 'modal_gallery.php'; ?>
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
    <script type="text/javascript" src="../assets/js/parallax.js"></script>
    <script src="../assets/js/jquery.waypoints.min.js"></script>
    <script src="../assets/js/jquery.stellar.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/fontawesome-free-5.10.2-web/js/all.js"></script>
    <script src="../assets/js/lightgallery-all.min.js"></script>
    <script src="../assets/js/aos.js"></script>
    <script src="../assets/js/scrollax.min.js"></script>
    <script src="../assets/js/jquery.easing.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script type="text/javascript" src="../assets/js/sweetalert2.min.js"></script>
    <script type="text/javascript">
      setTimeout(batasWaktu, 7200000);
      function batasWaktu() {
        Swal.fire({
          type: 'warning',
          title: '<h2>Sesi Anda sudah berakhir</h2>',
          text: 'Anda akan kembali ke halaman Utama!',
          showConfirmButton: true
        }).then(function() {
          window.location.href = '../index.php';
        })
      };
      function hideTitle() {
        if($('#img1').val() == ""){
          $('#titlePanduan').css('display', 'block');
        }
        else{
          $('#titlePanduan').css('display', 'none');
        }
      };
      function Eraser() {
        $('#preview-img1').css('display','none');
        document.getElementById('img1').value = "";
        $('#titlePanduan').css('display', 'block');
        $('#BTN_PESANRESERVASI').prop('disabled', true);
        $('#UlangInputFotoBukti').css('display', 'none');
        $('#BungkusFoto').tooltip("enable");
      };
      function ConfirmEditReservasi() {
        Swal.fire({
          title: 'Yakin ingin mengubah data pesanan Anda?',
          type: 'question',
          showCancelButton: true,
          confirmButtonText: 'Iya',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.value) {
            Swal.fire({
              title:'Baik kami akan mengarahkan Anda!',
              text: "Tunggu...",
              imageUrl: "../assets/images/loading.svg",
              imageSize: '800x800',
              showConfirmButton: false,
              timer: 2500
            }).then(function() {
              window.location.href = 'Kamar_pilihan_BARU2.php';
            })
          }
        })
      };
      function UnDisable() {
        if (document.getElementById('img1').value !== "") {
          document.getElementById('BTN_PESANRESERVASI').disabled = false;
          $('#UlangInputFotoBukti').css('display', 'block');
          $('#preview-img1').css('display','block');
        }
      };
      $('#UlangInputFotoBukti').hover(function () {
        $('#BungkusFoto').tooltip('disable');
      });
    </script>

    <?php 
      if( isset($_POST["BTN_PESANRESERVASI"]) ) {
        if( ProsesReservasi($_POST) > 0 ) {
          echo "
            <script>
              Swal.fire({
                type: 'success',
                title: 'Pesanan Anda akan kami verifikasi secepatnya.',
                text: 'Terimakasih 🙂',
                showConfirmButton: false,
                timer: 3000
              }).then(function() {
                window.location.href = '../index.php';
              });
            </script>
          ";
        } else {
          echo "
            <script>
              Swal.fire({
                type: 'error',
                title: 'Mohon untuk isi data dengan benar!',
                text: 'Silahkan ulangi pengisian data!',
                showConfirmButton: false,
                timer: 3000
              }).then(function() {
                window.location.href = 'pesanan.php';
              });
            </script>
          ";
        }
      }
    ?>
    
  </body>
</html>
