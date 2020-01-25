<?php
session_start();
unset($_SESSION['LAST_ACTIVITY']);
require 'koneksi/function_global.php';
$cekKET = mysqli_query($conn, "SELECT SUM(jumlah_kamar) AS kettKamar FROM tbl_tipe_kamar");
$bar = mysqli_fetch_assoc($cekKET);
$SUMKettKam = $bar["kettKamar"];
if (isset($_POST['inputReservasi'])) :
	if ($SUMKettKam <= 0) :
		echo "
				<script type='text/javascript' src='assets-2/js/jquery-3.3.1.js'></script>
				<link rel='stylesheet' href='assets/css/sweetalert2.min.css'>
				<script type='text/javascript' src='assets/js/sweetalert2.min.js'></script>
				<script>
					$( document ).ready(function() {
						Swal.fire({
							type: 'error',
							title: 'Maaf, untuk saat ini kamar sudah habis dipesan.',
							showConfirmButton: false,
							// timer: 2000
						}).then(function() {
							window.location.href = 'index.php';
						})
					});
				</script>
			";
	elseif (empty($_POST['ci'] and $_POST['co'])) :
		echo "
				<script type='text/javascript' src='assets-2/js/jquery-3.3.1.js'></script>
				<link rel='stylesheet' href='assets/css/sweetalert2.min.css'>
				<script type='text/javascript' src='assets/js/sweetalert2.min.js'></script>
				<script>
					$( document ).ready(function() {
						Swal.fire({
							type: 'error',
							title: 'Tanggal harus dimasukkan!',
							showConfirmButton: false,
							timer: 2000
						}).then(function() {
							window.location.href = 'index.php';
						})
					});
				</script>
			";
	else :
		$ci = $_POST['ci'];
		$co = $_POST['co'];
		$jml = $_POST['jml_hari'];
		$adt = $_POST['adlt'];
		$cld = $_POST['child'];
		$_SESSION["pilihanKamar"] = array();
		$_SESSION["pilihanKamar"]["tglCheckin"] = $ci;
		$_SESSION["pilihanKamar"]["tglCheckout"] = $co;
		$_SESSION["pilihanKamar"]["jml_hari"] = $jml;
		$_SESSION["pilihanKamar"]["adt"] = $adt;
		$_SESSION["pilihanKamar"]["cld"] = $cld;
		header("location:tamu/kamar_pilihan_BARU3.php");
	endif;
endif;
if (!empty($_SESSION["loggedin"])) :
	$id = $_SESSION["loggedin"]["id_tamu"];
	$cekTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE id_tamu = '$id'");
	if (mysqli_num_rows($cekTamu) === 1) :
		$rowT = mysqli_fetch_assoc($cekTamu);
		$fotoT = $rowT["foto_tamu"];
	endif;
endif;
$infoKamar = query("SELECT * FROM tbl_tipe_kamar ORDER BY id_tipe_kamar");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Widuri Villa</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="assets/images/logo-w.png">
	<link rel="stylesheet" type="text/css" href="assets/css/open-iconic-bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/lightgallery.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/lg-transitions.css">
	<link rel="stylesheet" type="text/css" href="assets/css/aos.css">
	<link rel="stylesheet" type="text/css" href="assets/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/flaticon.css">
	<link rel="stylesheet" type="text/css" href="assets/css/icomoon.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free-5.10.2-web/css/all.css">
	<link rel="stylesheet" type="text/css" href="assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font/flaticon.css">
	<link rel='stylesheet' type="text/css" href='assets/css/sweetalert2.min.css'>
	<link rel='stylesheet' type="text/css" href='assets/css/jquery-ui.min.css'>
	<link rel="stylesheet" type="text/css" href="assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css">
	<link rel="manifest" href="manifest.webmanifest">
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container-fluid">
			<a class="navbar-brand" type="text/css" href="index.php"><img src="assets/images/logo.png" alt="widuri" width="79.5px" height="50px"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>
			<div class="collapse navbar-collapse" id="ftco-nav">
				<div class="tamu-user-small">
					<?php if (!empty($_SESSION['loggedin'])) : ?>
						<div class='dropdown'>
							<div class="wrapper-avatar--2 small-avatar-2 dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
								<?php if ($fotoT === "") : ?><img src='assets/images/user.png' alt=''><?php else : ?><img src='assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
							</div>
							<div class='dropdown-menu dropdown-menu-right shadow dropdownMenu-tamu' aria-labelledby='navbarDropdown'>
								<a href='tamu/user_ubah.php?id=<?= $id ?>' class='dropdown-item'><i class='fas fa-cog'></i> Ubah akun</a>
								<a href='tamu/user_ubah_password.php?id=<?= $id ?>' class='dropdown-item'><i class='fas fa-key'></i> Ganti password</a>
								<a href='tamu/logout.php' class='dropdown-item text-danger'><i class='fas fa-sign-out-alt'></i> Logout</a>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="#home" class="nav-link">Home</a></li>
					<li class="nav-item"><a href="#about" class="nav-link">About</a></li>
					<li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
					<li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
					<li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
				</ul>
				<?php
				if (empty($_SESSION["loggedin"])) : ?>
					<div class='d-flex align-items-center justify-content-center logis autoWidth'>
						<a href='tamu/login.php'>
							<h6 class='mb-0 btn btn-outline-light'>Login</h6>
						</a>
						<a href='tamu/register.php'>
							<h6 class='mb-0 btn btn-outline-light' style='padding-left: 10px;'>Register</h6>
						</a>
					</div>
				<?php else : ?>
					<div class='dropdown tamu-user'>
						<div class="wrapper-avatar--2 tamu-avatar dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" tabindex="0">
							<?php if ($fotoT === "") : ?><img src='assets/images/user.png' alt=''><?php else : ?><img src='assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
						</div>
						<div class='dropdown-menu dropdown-menu-right shadow' aria-labelledby='navbarDropdown'>
							<a href='tamu/user_ubah.php?id=<?= $id ?>' class='dropdown-item'><span class="mr-2"><i class='fas fa-cog'></span></i> Ubah akun</a>
							<a href='tamu/user_ubah_password.php?id=<?= $id ?>' class='dropdown-item'><span class="mr-2"><i class='fas fa-key'></i></span> Ganti password</a>
							<a href='tamu/logout.php' class='dropdown-item text-danger'><span class="mr-2"><i class='fas fa-sign-out-alt'></i></span> Logout</a>
						</div>
					</div>
				<?php endif;
				?>
			</div>
		</div>
	</nav>
	<!-- END nav -->
	<!-- home -->
	<div class="parallax-window hero-wrap ftco-degree-bg" data-parallax="scroll" data-image-src="assets/images/20180819_134434.jpg" id="home">
		<div class="overlay"></div>
		<div class="container-fluid">
			<div class="row no-gutters slider-text justify-content-center align-items-center">
				<div class="col-lg-12 col-md-12 ftco-animate d-flex align-items-center justify-content-center">
					<div class="text text-center">
						<h1 class="mb-4">WIDURI VILLA</h1>
						<p style="font-size: 18px; text-shadow: 4px 3px 5px #000000ba">Jalan Raya Kerobokan Kelod - No 101 - Br. Taman - Kuta Utara - Badung - Bali - Indonesia</p>
						<button class="btn btn-primary" data-toggle="modal" data-target="#form-ca">Reservasi Sekarang</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /home -->
	<!-- about -->
	<section class="page-section ftco-section bg-light pb-5" id="about">
		<div class="container-fluid heading-section text-center">
			<span class="subheading heading-section-about-mobile">About Widuri Villa</span>
			<h2 class="mb-4 heading-section-about-mobile">About Us</h2> <!-- PR -->
			<div class="row no-gutters">
				<!-- carousel -->
				<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center carousel slide carousel-fade" id="carouselExampleIndicators" data-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="assets/images/20180930_164334.jpg" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item">
							<img src="assets/images/20180926_163714.jpg" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item">
							<img src="assets/images/IMG-20180918-WA0014.jpg" class="d-block w-100" alt="...">
						</div>
					</div>
				</div>
				<!-- /carousel -->
				<div class="col-md-6 wrap-about py-md-5 d-flex justify-content-center align-items-center ftco-animate" style="z-index: 9">
					<div class="heading-section">
						<h2 class="mb-4 text-left heading-section-about">About Us</h2>
						<p class="text-left">Villa Widuri berdiri pada tahun 2010 dan proses pembangunan memerlukan waktu 1 tahun. Villa dengan suasana yang nyaman, fasilitas yang disediakan cukup memadai serta beberapa penawaran yang ditawarkan untuk Anda menjadi nilai tambah bagi Kami untuk memberikan yang terbaik bagi Anda.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /about -->
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 heading-section text-center ftco-animate mb-5">
					<span class="subheading">What we offer</span>
					<h2 class="mb-2">Exclusive Offer For You</h2>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<?php foreach ($infoKamar as $row) : ?>
					<div class="col-md-5">
						<div class="property-wrap ftco-animate">
							<span class="img rounded shadow-sm" style="background-image: url(assets/foto_tipe_kamar/<?= $row['foto_tipe_kamar'] ?>);"></span>
							<div class="text shadow-sm rounded position-relative">
								<?php if ($row['jumlah_kamar'] <= 5 and $row['jumlah_kamar'] >= 1) : ?>
									<h2 class="p-0 m-0 position-absolute" style="right: -10px; top: -20px"><span class="badge badge-danger shadow">Hurry <?= $row['jumlah_kamar'] ?> left</span></h2>
								<?php elseif ($row['jumlah_kamar'] == 0) : ?>
									<h2 class="p-0 m-0 position-absolute" style="right: -10px; top: -20px"><span class="badge badge-danger shadow">Sold Out</span></h2>
								<?php else : ?>
								<?php endif; ?>
								<p class="price"></span><span class="orig-price">Rp.<?= number_format($row['harga_kamar'], 0, ',', '.') ?><small>/night</small></span></p>
								<ul class="property_list d-flex justify-content-between flex-wrap">
									<?php $fasilitas = explode(',', $row["fasilitas"]);
									if ($row['id_tipe_kamar'] == 1) : ?>
										<span class="flt flaticon-bed mr-2"> 1</span>
										<span class="flt flaticon-bathtub mr-2"> 1</span>
										<span class="flt flaticon-kitchen mr-2" data-toggle="tooltip" title="Dapur"></span>
										<span class="flt flaticon-support mr-2" data-toggle="tooltip" title="Pelayanan 24 jam"></span>
										<span class="flt flaticon-swimming-pool mr-2" data-toggle="tooltip" title="Kolam renang"></span>
										<span class="flt flaticon-wifi" data-toggle="tooltip" title="Wifi"></span>
									<?php elseif ($row['id_tipe_kamar'] == 2) : ?>
										<span class="flt flaticon-bed mr-2"> 2</span>
										<span class="flt flaticon-bathtub mr-2"> 2</span>
										<span class="flt flaticon-kitchen mr-2" data-toggle="tooltip" title="Dapur"></span>
										<span class="flt flaticon-support mr-2" data-toggle="tooltip" title="Pelayanan 24 jam"></span>
										<span class="flt flaticon-swimming-pool mr-2" data-toggle="tooltip" title="Kolam renang"></span>
										<span class="flt flaticon-gazebo mr-2" data-toggle="tooltip" title="Gazebo"></span>
										<span class="flt flaticon-wifi" data-toggle="tooltip" title="Wifi"></span>
									<?php else : ?>
										<span class="flt flaticon-bed mr-2"> 2</span>
										<span class="flt flaticon-bathtub mr-2"> 2</span>
										<span class="flt flaticon-kitchen mr-2"></span>
										<span class="flt flaticon-support mr-2"></span>
										<span class="flt flaticon-swimming-pool mr-2"></span>
										<span class="flt flaticon-gazebo mr-2"></span>
										<span class="flt flaticon-wifi"></span>
									<?php endif;
									?>
								</ul>
								<h2><?= $row['nama_tipe_kamar'] ?></h2>
								<?php if ($row['jumlah_kamar'] > 0) : ?>
									<a href="#" class="d-flex align-items-center justify-content-center btn-custom" data-toggle="modal" data-target="#form-ca">
										<span class="ion-ios-link"></span>
									</a>
								<?php else : ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</section>
	<!-- Fasility -->
	<section class="page-section ftco-section bg-light" id="features">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-md-7 text-center heading-section ftco-animate">
					<span class="subheading">Facility</span>
					<h2 class="mb-3">Our Facility</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-4 ftco-animate">
					<div class="card mb-2">
						<div class="card-body">
							<h4 class="card-title border-bottom">Tipe Satu</h4>
							<ol>
								<li>Satu kamar</li>
								<li>Satu kamar mandi</li>
								<li>Dapur</li>
								<li>Kolam renang</li>
								<li>Wifi</li>
							</ol>
						</div>
					</div>
				</div>
				<div class="col-md-4 ftco-animate">
					<div class="card mb-2">
						<div class="card-body">
							<h4 class="card-title border-bottom">Tipe Dua</h4>
							<ol>
								<li>Setiap villa dengan luas lahan 200m<sup>2</sup></li>
								<li>Bangunan dengan luas 100m<sup>2</sup></li>
								<li>Kolam renang pribadi</li>
								<li>Dua kamar</li>
								<li>Satu dapur</li>
								<li>Dua kamar mandi</li>
								<li>Wifi</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /Fasility -->
	<!-- Gallery -->
	<section class="page-section ftco-section ftco-no-pb" id="gallery">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 heading-section text-center ftco-animate mb-5">
					<span class="subheading">Gallery</span>
					<h2 class="mb-2">Our Gallery</h2>
				</div>
			</div>
			<div class="row" id="my-gallery">
				<div class="col-md-4">
					<div class="property-wrap ftco-animate img-hover-zoom img-hover-zoom--colorize">
						<a href="assets/images/gallery2.jpg" class="img" style="background-image: url(assets/images/gallery2.jpg);" data-src="assets/images/gallery2.jpg"></a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="property-wrap ftco-animate img-hover-zoom img-hover-zoom--colorize">
						<a href="assets/images/gallery1.jpg" class="img" style="background-image: url(assets/images/gallery1.jpg);" data-src="assets/images/gallery1.jpg"></a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="property-wrap ftco-animate img-hover-zoom img-hover-zoom--colorize">
						<a href="assets/images/gallery3.jpg" class="img" style="background-image: url(assets/images/gallery3.jpg);" data-src="assets/images/gallery3.jpg"></a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="property-wrap ftco-animate img-hover-zoom img-hover-zoom--colorize">
						<a href="assets/images/gallery4.jpg" class="img" style="background-image: url(assets/images/gallery4.jpg);" data-src="assets/images/gallery4.jpg"></a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="property-wrap ftco-animate img-hover-zoom img-hover-zoom--colorize">
						<a href="assets/images/gallery5.jpg" class="img" style="background-image: url(assets/images/gallery5.jpg);" data-src="assets/images/gallery5.jpg"></a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="property-wrap ftco-animate img-hover-zoom img-hover-zoom--colorize">
						<a href="assets/images/gallery6.jpg" class="img" style="background-image: url(assets/images/gallery6.jpg);" data-src="assets/images/gallery6.jpg"></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /Gallery -->
	<!-- Contact -->
	<footer class="page-section ftco-footer ftco-section" id="contact">
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
						<a href="index.php">
							<img src="assets/images/logo-title.png" alt="widuri" width="99.5px" height="70px">
						</a>
						<h3>Widuri Villa</h3>
						<ul class="ftco-footer-social list-unstyled mt-5">
							<li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
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
					<div class="ftco-footer-widget foo-index mb-4">
						<h2 class="ftco-heading-2">Looking back</h2>
						<ul class="list-unstyled">
							<li><a href="#about"><span class="icon-long-arrow-right mr-2"></span>About Us</a></li>
							<li><a href="#features"><span class="icon-long-arrow-right mr-2"></span>Features</a></li>
							<li><a href="#gallery"><span class="icon-long-arrow-right mr-2"></span>Gallery</a></li>
							<li><a href="#contact"><span class="icon-long-arrow-right mr-2"></span>Contact</a></li>
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
					<p>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>
							document.write(new Date().getFullYear());
						</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a><span> | Redesign by Agus Rosi Adi Purwibawa</span>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					</p>
				</div>
			</div>
		</div>
	</footer>
	<!-- scroll -->
	<bottom style="cursor: pointer;" id="scroll-ca" data-toggle="modal" data-target="#form-ca" class="btn btn-primary btn-lg scroll-ca animated pulse infinite shadow-sm">PESAN SEKARANG</bottom>
	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" /></svg></div>
	<?php include 'tamu/popup_check_availability.php'; ?>
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-migrate-3.0.1.min.js"></script>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/parallax.js"></script>
	<script type="text/javascript" src="assets/js/jquery.waypoints.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.stellar.min.js"></script>
	<script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="assets/vendor/fontawesome-free-5.10.2-web/js/all.js"></script>
	<script type="text/javascript" src="assets/js/lightgallery-all.min.js"></script>
	<script type="text/javascript" src="assets/js/aos.js"></script>
	<script type="text/javascript" src="assets/js/jquery.animateNumber.min.js"></script>
	<script type="text/javascript" src="assets/js/scrollax.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
	<script type='text/javascript' src='assets/js/sweetalert2.min.js'></script>
	<script>
		function clikb() {
			Swal.fire({
				type: 'error',
				title: 'Kamar tidak tersedia!',
				showConfirmButton: false
			}).then(function() {
				window.location.href = 'tabel_reservasi.php';
			})
		};
		$('#TM').datepicker({
			minDate: 0,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
		});
		$('#TK').datepicker({
			minDate: 0,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
		});
		$('#TM').datepicker().bind("change", function() {
			var minValue = $(this).val();
			minValue = $.datepicker.parseDate("dd-mm-yy", minValue);
			$('#TK').datepicker("option", "minDate", minValue);
			calculate();
		});
		$('#TK').datepicker().bind("change", function() {
			var maxValue = $(this).val();
			maxValue = $.datepicker.parseDate("dd-mm-yy", maxValue);
			$('#TM').datepicker("option", "maxDate", maxValue);
			calculate();
		});

		function calculate() {
			var d1 = $('#TM').datepicker('getDate');
			var d2 = $('#TK').datepicker('getDate');
			var oneDay = 24 * 60 * 60 * 1000;
			var diff = 0;
			if (d1 && d2) {
				diff = Math.round(Math.abs((d2.getTime() - d1.getTime()) / (oneDay)));
			}
			$('#jumlahHari').val(diff);
		};
		
		window.addEventListener('load', () => {
			registerSW();
		});
		async function registerSW() {
			if ('serviceWorker' in navigator) {
				try {
					await navigator.serviceWorker.register('sw.js');
				} catch (e) {
					console.log(`SW registration failed`);
				}
			}
		}
	</script>
</body>

</html>