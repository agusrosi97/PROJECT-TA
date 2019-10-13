<?php
session_start();

if (isset($_GET['input'])) {
	$ci = $_GET['ci'];
	$co = $_GET['co'];
	$jml = $_GET['jml_hari'];
	$adt = $_GET['adlt'];
	$cld = $_GET['child'];
}
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
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
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
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container-fluid">
	      <a class="navbar-brand" href="index.php"><img src="../assets/images/logo.png" alt="widuri" width="79.5px" height="50px"></a>
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
	      </div>

	    </div>
	  </nav>
    <!-- END nav -->
    <!-- home -->
    <!-- <div class="parallax-window hero-wrap--2 ftco-degree-bg" data-parallax="scroll" data-image-src="../assets/images/20180819_134434.jpg"> -->
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
          <div class="col-md-8 ftco-animate mb-3">
	          <div class="card border rounded shadow-sm p-3">

							<!-- row image -->
							<div class="row">
	            	<div class="col-md-7 position-relative">
	            		<div id="carouselExampleIndicators--2" class="carousel slide carousel-fade gambar-kamar" data-ride="carousel" data-target="#lightbox-modal--2" data-toggle="modal">
									  <ol class="carousel-indicators">
									    <li data-target="#carouselExampleIndicators--2" data-slide-to="0" class="active"></li>
									    <li data-target="#carouselExampleIndicators--2" data-slide-to="1"></li>
									    <li data-target="#carouselExampleIndicators--2" data-slide-to="2"></li>
									    <li data-target="#carouselExampleIndicators--2" data-slide-to="3"></li>
									    <li data-target="#carouselExampleIndicators--2" data-slide-to="4"></li>
									  </ol>
									  <div class="carousel-inner" id="my-gallery">
									    <div class="carousel-item active">
									      <img class="img-fluid" src="../assets/images/gallery8.jpg" alt="First slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery9.jpg" alt="Second slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery10.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery11.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery12.jpg" alt="Third slide">
									    </div>
									  </div>
									</div>
	            	</div>
								<div class="col-md-5 position-relative daftar-fasilitas border-left">
									<div class="border-bottom d-flex justify-content-between align-items-center">
										<h4 class="">Tipe Satu</h4>
										<h6 class="">Rp. 400.000,-/Hari</h6>
									</div>
									<ol>
										<li>Satu kamar tidur</li>
										<li>Kamar mandi</li>
										<li>Kolam renag</li>
										<li>Dapur</li>
										<li>Wifi</li>
									</ol>
									<button class="btn btn-primary" style="width: 100%">PILIH</button>
								</div>
	            </div>
							<!-- /row images -->

	            <hr class="my-4">
							
							<!-- row images -->
	            <div class="row">
	            	<div class="col-md-7">
	            		<div id="carouselExampleIndicators" class="carousel slide carousel-fade gambar-kamar" data-ride="carousel" data-target="#lightbox-modal" data-toggle="modal">
									  <ol class="carousel-indicators">
									    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="8"></li>
									    <li data-target="#carouselExampleIndicators" data-slide-to="9"></li>
									  </ol>
									  <div class="carousel-inner" id="my-gallery">
									    <div class="carousel-item active">
									      <img class="img-fluid" src="../assets/images/gallery7.jpg" alt="First slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery3.jpg" alt="Second slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery1.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery2.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery4.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery13.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery14.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery15.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery16.jpg" alt="Third slide">
									    </div>
									    <div class="carousel-item">
									      <img class="img-fluid" src="../assets/images/gallery17.jpg" alt="Third slide">
									    </div>
									  </div>
									</div>
	            	</div>
								<div class="col-md-5 position-relative daftar-fasilitas border-left">
									<div class="border-bottom d-flex justify-content-between align-items-center">
										<h4 class="">Tipe Dua</h4>
										<h6 class="">Rp. 800.000/Hari</h6>
									</div>
									<ol>
										<li>Dua kamar tidur</li>
										<li>Dua kamar mandi</li>
										<li>Satu kolam renag</li>
										<li>Dapur</li>
										<li>Satu Gazebo</li>
										<li>Wifi</li>
									</ol>
									<button type="submit" name="submit" class="btn btn-primary" style="width: 100%" form="form_reservasi">PILIH</button>
								</div>
	            </div>
	            <!-- /row image -->
	          </div>
						<!-- /image corausel -->
          </div>
          <!-- your reservation -->
          <div class="col-md-4 ftco-animate">
            <div class="card border p-4 mb-2 shadow-sm">
            	<h2 class="text-center border-bottom pb-4">Reservasi anda</h2>
              <form id="form_reservasi" action="" method="POST">
								<div class="form-group">
									<label for="tgl_c1">Checkin</label>
									<input type="date" id="TM" class="form-control txtDate" value="<?php echo "$ci" ?>" onchange="hitungHari()">
								</div>
								<div class="form-group">
									<label for="tgl_co">Checkout</label>
									<input type="date" id="TK" class="form-control txtDate" value="<?php echo "$co" ?>" onchange="hitungHari()">
								</div>
								<div class="form-group">
									<label for="jml_adlt">Dewasa</label>
									<select id="jml_adlt" name="org_dewasa" class="form-control">
										<option>Adult</option>
										<option <?php if ($adt == 1 ) echo 'selected' ; ?> value="1">1</option>
										<option <?php if ($adt == 2 ) echo 'selected' ; ?> value="2">2</option>
									</select>
								</div>
								<div class="form-group">
									<label for="jml_ank">Anak-anak</label>
									<select name="anak" id="jml_ank" class="form-control">
										<option value="0">Children</option>
										<option <?php if ($cld == 1 ) echo 'selected' ; ?> value="1">1</option>
										<option <?php if ($cld == 2 ) echo 'selected' ; ?> value="2">2</option>
									</select>
								</div>
								<div class="form-group">
									<label>Jumlah hari</label>
									<input type="text" id="jumlahHari" name="total_tanggal" value="<?php echo "$jml" ?>" class="form-control" readonly>
								</div>
								<div class="col text-center">
									<button type="submit" class="btn btn-primary shadow-sm" name="submit">Checkout</button>
									<a href="../index.php" class="btn btn-secondary">Cancel</a>
								</div>
							</form>
            </div>
          </div>
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
	  <script src="../assets/js/bootstrap.min.js"></script>
	  <script type="text/javascript" src="../assets/js/parallax.js"></script>
	  <script src="../assets/js/jquery.waypoints.min.js"></script>
	  <script src="../assets/js/jquery.stellar.min.js"></script>
	  <script src="../assets/js/owl.carousel.min.js"></script>
	  <script type="text/javascript" src="../assets/vendor/fontawesome-free-5.10.2-web/js/all.js"></script>
	  <script src="../assets/js/lightgallery-all.min.js"></script>
	  <script src="../assets/js/aos.js"></script>
	  <script src="../assets/js/jquery.animateNumber.min.js"></script>
	  <script src="../assets/js/bootstrap-datepicker.js"></script>
	  <script src="../assets/js/jquery.timepicker.min.js"></script>
	  <script src="../assets/js/scrollax.min.js"></script>
	  <script src="../assets/js/jquery.easing.min.js"></script>
	  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> -->
	  <!-- <script src="assets/js/google-map.js"></script> -->
	  <script src="../assets/js/main.js"></script>
    
  </body>
</html>
