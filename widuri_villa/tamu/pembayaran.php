<?php
  session_start();
  if (empty($_SESSION["pilihanKamar"])) :
    header("location:../index.php");
  endif;

  $tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
  $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
  $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
  $adlt = $_SESSION["pilihanKamar"]["adt"];
  $cild = $_SESSION["pilihanKamar"]["cld"];
  $total_harga = $_SESSION["pilihanKamar"]["total_harga"];

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
    <link rel="stylesheet" href="../assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../assets/css/jquery.timepicker.css">
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <link rel="stylesheet" href="../assets/css/icomoon.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome-free-5.10.2-web/css/all.css">
    <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">  
    <script type="text/javascript">
      function jmlHari(){
        var tgl_masuk = new Date(document.getElementById("TM").value);
        var tgl_keluar = new Date(document.getElementById("TK").value);
        return parseInt((tgl_keluar - tgl_masuk) / (24 * 3600 * 1000));
      }
      function hitungHari(){
        if(document.getElementById("TK")){
          document.getElementById("jumlahHari").value=jmlHari();
        } 
      }
    </script>
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
      <div class="container">

        <div class="row">
          <div class="col-md-12 heading-section ftco-animate">
            <h2 class="mb-3">Pembayaran</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 ftco-animate mb-3">
            <div class="card border rounded shadow-sm p-3">
              <?php if(mysqli_num_rows($cekKamar) === 0) : ?><div class="text-center"><h4>Dalam Pembaruan</h4></div><?php else : ?><?php endif; ?>
              
              <!-- LOOPING KAMAR -->
              <?php $i = 1; ?>
              <?php foreach ($dataTipeKamar as $row): ?>
                <div class="row">
                  <!-- SLIDER -->
                  <div class="col-md-7 position-relative">
                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade gambar-kamar rounded shadow-sm" data-ride="carousel" data-target="#lightbox-modal--<?=$i?>" data-toggle="modal">
                      <div class="carousel-inner" id="my-gallery">
                        <div class="carousel-item active">
                          <?php if($row["foto_tipe_kamar"] === "") : ?><h5>Dalam Pembaruan</h5><?php else : ?><img class="img-fluid rounded" src="../assets/foto_tipe_kamar/<?php echo $row["foto_tipe_kamar"]; ?>" alt=""><?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /SLIDER -->
                  <div class="col-md-5 position-relative daftar-fasilitas left-border">
                    <div class="border-bottom d-flex justify-content-between align-items-center">
                      <h4 class=""><?php echo $row["nama_tipe_kamar"]; ?></h4>
                      <?php if($row['harga_kamar'] <= 0) : ?><h5 class="font-weight-bold">Dalam Pembaruan</h5><?php else : ?><h5 class="font-weight-bold"><?="Rp.". number_format($row['harga_kamar'],2,',','.').",-" ?></h5><?php endif; ?>
                      <!-- ID HARGA -->
                      <input type="hidden" id="hargaPerKamar<?=$i?>" value="<?php if($row['harga_kamar'] <= 0) : ?>0<?php else : ?><?= $row['harga_kamar'] ?><?php endif; ?>">
                    </div>
                    <div class="row">
                      <div class="col-7">
                        <ol>
                          <?php
                            $fasilitas = explode(',', $row["fasilitas"]);
                            foreach($fasilitas as $value) {
                              echo "<li><i class='fas fa-check text-success' style='font-size:10px;'></i> $value</li>";
                            }
                          ?>
                        </ol>        
                      </div>
                      <div class="col-5 pl-0">
                        <div class="form-row pt-sm-3 pr-1">
                          <label class="pt-1 col-md-4">Qty</label> 
                          <select id="Kamar<?= $i ?>" class="form-control inputangka col-md-8" disabled="true">
                            <?php
                              $j = 0;
                              for ($x = -1; $x < $row['jumlah_kamar']; $x++) {
                                echo "<option value='".$j."'>".$j."</option>";
                                $j++;
                              }
                            ?>
                          </select>                   
                        </div>
                      </div>       
                    </div>
                    <div class="d-flex">
                      <button type="button" class="btn btn-primary" id="btnKamar_<?php echo $i ?>" style="width: 100%">PILIH</button>
                    </div>
                  </div>
                </div>
                <hr class='my-4 liner'>
                <?php $i++; ?>
              <?php endforeach; ?>
              <!-- /LOOPING KAMAR -->
            </div>
          </div>

          <!-- your reservation -->
          <?php include 'formReservasi.php'; ?>
          <!-- /your reservation -->

        </div>
      </div>
    </section>
    <!-- /Fasility -->
    
    <!-- Contact -->
    <footer class="page-section ftco-footer ftco-section ftco-no-pb" id="contact">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
            <span class="subheading">Contact</span>
            <h2 class="mb-2">Hubungi kami</h2>
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 d-flex flex-column justify-content-center align-items-center">
              <a href="../index.php">
                <img src="../assets/images/logo-title.png" alt="widuri" width="99.5px" height="70px">
              </a>
              <h3>Widuri Villa</h3>
              <ul class="ftco-footer-social list-unstyled mt-5">
                <li class="ftco-animate"><a href=""><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href=""><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href=""><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Support By</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="icon-long-arrow-right mr-2"></span>Colorlib</a></li>
                <li><a href="#"><span class="icon-long-arrow-right mr-2"></span>Bootstrap</a></li>
                <li><a href="#"><span class="icon-long-arrow-right mr-2"></span>FontAwesome</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Looking back</h2>
              <ul class="list-unstyled">
                <li><a href="../index.php#about"><span class="icon-long-arrow-right mr-2"></span>About Us</a></li>
                <li><a href="../index.php#features"><span class="icon-long-arrow-right mr-2"></span>Features</a></li>
                <li><a href="../index.php#gallery"><span class="icon-long-arrow-right mr-2"></span>Gallery</a></li>
                <li><a href="../index.php#contact"><span class="icon-long-arrow-right mr-2"></span>Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Contact info</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">Jalan Raya Kerobokan Kelod, No:. 101, Br.Taman, Kuta Utara, Badung - Bali</span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+62 8179 719 692</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope pr-4"></span><span class="text">widuri@gmail.com</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a><span> | Redesign by Agus Rosi Adi Purwibawa</span>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
        </div>
      </div>
    </footer>

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
    <script src="../assets/js/bootstrap-datepicker.js"></script>
    <script src="../assets/js/jquery.timepicker.min.js"></script>
    <script src="../assets/js/scrollax.min.js"></script>
    <script src="../assets/js/jquery.easing.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script type="text/javascript">
      <?php $i = 1; ?>
      <?php foreach ($dataTipeKamar as $key): ?>
        $('.inputangka').on('change',function(){
          var JmlKamar = Number($('#Kamar').val());
          var JmlHari = Number($('#jumlahHari').val());
          var hargaKamar_tipe<?php echo "$i" ?> = Number($('#hargaPerKamar<?=$i?>').val());
          var TotHarga = JmlKamar * JmlHari * hargaKamar_tipe<?php echo "$i" ?>;
          document.getElementById('total_harga').value = TotHarga;
          if ($('#total_harga').val() > 0) {
            if ($('#btnPesan_reservasi').prop('disabled', true)){
              $('#btnPesan_reservasi').prop('disabled', false);
            }
          }else{
            $('#btnPesan_reservasi').prop('disabled', true);
          }
        });
        $('#btnKamar_<?php echo "$i" ?>').on('click', function(){
          if($('#Kamar<?php echo "$i" ?>').prop('disabled', true)){
            $('#Kamar<?php echo "$i" ?>').prop('disabled', false);
          }
        });
      <?php $i++; ?>
      <?php endforeach ?>

      // 
    </script>
    
  </body>
</html>
