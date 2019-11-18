<?php
  session_start();
  if (empty($_SESSION["pilihanKamar"])) :
    header("location:../index.php");
  elseif (empty($_SESSION["lastID_Transaksi"])) :
    header("location:../index.php");
  endif;
  require '../koneksi/function_global.php';
  if (!empty($_SESSION["loggedin"])) :
    $id = $_SESSION["loggedin"]["id_tamu"];
    $cekTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE id_tamu = '$id'");
    if (mysqli_num_rows($cekTamu) === 1 ) :
      $rowT = mysqli_fetch_assoc($cekTamu);
      $fotoT = $rowT["foto_tamu"];
    endif;
  endif;
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
    <link rel='stylesheet' href='../assets/css/jquery-ui.min.css'>
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <link rel="stylesheet" href="../assets/css/icomoon.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome-free-5.10.2-web/css/all.css">
    <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
  </head>
  <body>
    <div id="particles-js"></div>
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
      <div class="container">
        <div class="row">
          <div class="col-md-12 heading-section ftco-animate">
            <h2 class="mb-3 text-center">Upload Bukti Transaksi</h2>
          </div>
        </div>
        <div class="row d-flex justify-content-center">
          <div style="padding: 20px;" class="img-fluid">
            <div class="col-sm-auto ftco-animate mb-3 p-0" id="contentOne" tabindex="-1" style="z-index: 2; background-color: white">
              <label id="BungkusFoto" for="img1" class="img-fluid col-md-12 p-0 m-0 border b-top-content wrapper-transaksi border d-flex  justify-content-center align-items-center rounded uploadGambar shadow-sm" style="height: 450px; cursor: pointer;" title="Anda dapat mengunggah gambar sampai dengan 3MB" data-toggle="tooltip" data-placement="top">
                <div class="position-absolute" id="UlangInputFotoBukti" style="z-index: 9; right: 5px; top: 5px; display: none;">
                  <button onclick="Eraser();" type="button" title="Ulangi input foto?" data-toggle="tooltip" data-placement="left" class="btn btn-light py-0 px-2" style="font-size: 20px; background-color: rgba(255,255,255,.7);">
                    <i class="fas fa-times text-danger"></i>
                  </button>
                </div>
                <div>
                  <p id="titlePanduan" class="text-center" style="padding: 20px">Tekan tombol "UPLOAD BUKTI" / Klik di sini untuk upload. <span class="font-weight-bold text-secondary"></br>Foto diharapkan <a href="https://translate.google.com/translate?u=https://en.wikipedia.org/wiki/Page_orientation&hl=id&sl=en&tl=id&client=srp" class="text-secondary">berorientasi potrait!</a></span></p>
                </div>
                <img id="preview-img1" height="300px" width="auto" alt=" " style="display: none" />
              </label>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
               <input type="file" onchange="hideTitle(); UnDisable();" id="img1" class="FotoUpload d-none" name="inp_bukti_pembayaran">
               <button type="submit" style="z-index: 2;" id="btnUpload" name="btnUploadFotoTransaksi" class="btn btn-primary col px-0 py-2 mt-3 font-weight-bold" disabled>PROSES PESANAN</button>
             </form>
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
    <script src="../assets/vendor/particles.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
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
      particlesJS.load('particles-js', '../assets/vendor/particles.json', function() {
        console.log('callback - particles.js config loaded');
      });
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
        $('#btnUpload').prop('disabled', true);
        $('#UlangInputFotoBukti').css('display', 'none');
        $('#BungkusFoto').tooltip("enable");
      };
      function UnDisable() {
        if (document.getElementById('img1').value !== "") {
          document.getElementById('btnUpload').disabled = false;
          $('#UlangInputFotoBukti').css('display', 'block');
          $('#preview-img1').css('display','block');
        }
      };
      $('#UlangInputFotoBukti').hover(function () {
        $('#BungkusFoto').tooltip('disable');
      });
    </script>
    <?php 
      if( isset($_POST["btnUploadFotoTransaksi"]) ) :
        if( TahapAkhirReservasi($_POST) > 0 ) {
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
          unset($_SESSION["pilihanKamar"], $_SESSION["confirmPesanan"], $_SESSION["privasi"], $_SESSION["bank"]["pilih"], $_SESSION["lastID_Reservasi"], $_SESSION["lastID_Transaksi"]);
        }
        else{
          echo "
            <script>
              Swal.fire({
                type: 'error',
                title: 'Mohon untuk isi data dengan benar!',
                text: 'Silahkan ulangi pengisian data!',
                showConfirmButton: false,
                timer: 3000
              }).then(function() {
                window.location.href = 'uploadbuktitransaksi.php';
              });
            </script>
          ";
        }
      endif;
    ?>
  </body>
</html>