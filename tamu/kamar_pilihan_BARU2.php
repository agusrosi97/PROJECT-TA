<?php
  session_start();
  if (empty($_SESSION["pilihanKamar"])) :
    header("location:../index.php");
  endif;
  // get session
  $tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
  $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
  $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
  $adlt = $_SESSION["pilihanKamar"]["adt"];
  $cild = $_SESSION["pilihanKamar"]["cld"];
  if (!empty($_SESSION["pilihanKamar"]["total_harga"])) :
    $total_harga = $_SESSION["pilihanKamar"]["total_harga"];
    $jumlah_kamar = $_SESSION["pilihanKamar"]["jumlah_kamar"];
  endif;
  if (isset($_POST["submitPesanan"])) :
    // get data form
    $nama_kamar = $_POST["nama_kamar"];
    $jumlah_kamar = $_POST["jumlah_kamar"];
    $tipe_kamar = $_POST["tipe_kamar"];
    $inpCekIn = $_POST["inpCekIn"];
    $inpCekOut = $_POST["inpCekOut"];
    $jml_adlt = $_POST["org_dewasa"];
    $jml_ank = $_POST["anak"];
    $total_tanggal = $_POST["total_tanggal"];
    $total_harga = $_POST["total_harga"];
    // set session
    $_SESSION["confirmPesanan"] = true;
    $_SESSION["pilihanKamar"] = array();
    $_SESSION["pilihanKamar"]["tglCheckin"] = $inpCekIn;
    $_SESSION["pilihanKamar"]["tglCheckout"] = $inpCekOut;
    $_SESSION["pilihanKamar"]["jml_hari"] = $total_tanggal;
    $_SESSION["pilihanKamar"]["adt"] = $jml_adlt;
    $_SESSION["pilihanKamar"]["cld"] = $jml_ank;
    $_SESSION["pilihanKamar"]["total_harga"] = $total_harga;
    $_SESSION["pilihanKamar"]["jumlah_kamar"] = $jumlah_kamar;
    // cus
    header('location:metodePembayaran.php');
  endif;

  require '../koneksi/function_global.php';

  if (!empty($_SESSION["loggedin"])) :
    $id = $_SESSION["loggedin"]["id_tamu"];
    // $namanya = $_SESSION["loggedin"]["nama_tamu"];
    $cekTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE id_tamu = '$id'");
    if (mysqli_num_rows($cekTamu) === 1 ) :
      $rowT = mysqli_fetch_assoc($cekTamu);
      $fotoT = $rowT["foto_tamu"];
    endif;
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
    <link rel='stylesheet' href='../assets/css/jquery-ui.min.css'>
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <link rel="stylesheet" href="../assets/css/icomoon.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome-free-5.10.2-web/css/all.css">
    <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">
  </head>
  <body onload="Loadaa()">  
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
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
    <!-- home -->
    <div class="parallax-window hero-wrap--2 ftco-degree-bg" data-parallax="scroll" data-image-src="../assets/images/20180819_134434.jpg">
      <div class="overlay"></div>
      <div class="container-fluid">
        <div class="row no-gutters slider-text--2 justify-content-center align-items-center">
          <div class="col-lg-12 col-md-12 ftco-animate d-flex align-items-center justify-content-center">
            <div class="text text-center">
              <h1>PILIHAN KAMAR</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /home -->
    <!-- pilihan kamar -->
    <section class="page-section ftco-section ftco-no-pb">
      <div class="container">

        <div class="row">
          <div class="col-md-12 heading-section ftco-animate">
            <h2 class="mb-3">Daftar Kamar</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 ftco-animate mb-3">
            <div id="contentOne" class="card border rounded p-3 b-top-content" tabindex="-1">
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
                      <!-- /ID HARGA -->
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
                          <select id="Kamar<?=$i?>" class="form-control col-md-8" onchange='hitung(); Loadaa();' disabled>
                            <?php
                              $j = 0;
                              for ($x = 0; $x <= $row['jumlah_kamar']; $x++) {?>
                                <option value='<?php echo $x ?>'><?php echo $j; ?></option>
                                <?php
                                $j++;
                              }
                            ?>
                          </select>                   
                        </div>
                      </div>       
                    </div>
                    <div class="d-flex">
                      <button type="button" class="btn btn-primary" id="btnKamar_<?=$i?>" style="width: 100%">PILIH</button>
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
    <?php include '../footer/footer-tamu.php'; ?>
    <?php include 'modal_gallery.php'; ?>
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script type="text/javascript" src="../assets-2/bootstrap_4.3.1/js/bootstrap.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
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

    <script type="text/javascript">
      function hitung(){
        var JmlHari = Number($('#jumlahHari').val());
        var TotHarga=0;
        var TotKamar=0;
        <?php $i = 1; ?>
        <?php foreach ($dataTipeKamar as $key): ?>
          var JmlKamar<?=$i;?> = Number($('#Kamar<?=$i;?>').val());
          var hargaKamar_tipe<?=$i;?> = Number($('#hargaPerKamar<?=$i;?>').val());
          TotHarga = TotHarga+(JmlKamar<?=$i;?> * hargaKamar_tipe<?=$i;?>);
          TotKamar = TotKamar+JmlKamar<?=$i;?>;
        <?php $i++; ?>
        <?php endforeach; ?>
        var total_Harga = TotHarga * JmlHari;
        document.getElementById('total_harga').value = total_Harga;
        document.getElementById('jmlKamar').value = TotKamar;
      };

      function Loadaa() {
        var hargavalue = document.getElementById('total_harga').value;
        if (hargavalue <= 0) {
          document.getElementById('btnPesan_reservasi').disabled = true;
        }else{
          document.getElementById('btnPesan_reservasi').disabled = false;
        }
      };
       
      <?php $i = 1; ?>
      <?php foreach ($dataTipeKamar as $key): ?>
        $('#btnKamar_<?=$i;?>').on('click', function(){
          if($('#Kamar<?=$i;?>').prop('disabled', true)){
            $('#Kamar<?=$i;?>').prop('disabled', false);
          }
        });
      <?php $i++; ?>
      <?php endforeach; ?>
      
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
    </script>    
  </body>
</html>
