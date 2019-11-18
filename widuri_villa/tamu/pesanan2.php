<?php
  ob_start();
  session_start();
  require '../koneksi/function_global.php';
  $id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
  $JmlKamar = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
  $lastRes = $_SESSION["lastID_Reservasi"];
  $lastTrans = $_SESSION["lastID_Transaksi"];
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 7200)) {
    KembalikanJumlahKamar();
    unset($_SESSION["pilihanKamar"], $_SESSION["privasi"] ,$_SESSION["bank"]["pilih"], $_SESSION["lastID_Reservasi"], $_SESSION["lastID_Transaksi"], $_SESSION["confirmPesanan"]);
  }
  $_SESSION['LAST_ACTIVITY'] = time();

  if (empty($_SESSION["pilihanKamar"])) :
    header("location:../index.php");
  endif;
  if (empty($_SESSION["privasi"] AND $_SESSION["bank"]["pilih"])) :
    header("Location:metodePembayaran.php");
  endif;
  $tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
  $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
  $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
  $adlt = $_SESSION["pilihanKamar"]["adt"];
  $cild = $_SESSION["pilihanKamar"]["cld"];
  $total_harga = hilangkanTitik($_SESSION["pilihanKamar"]["total_harga"]);
  $jumlah_kamar = $_SESSION["pilihanKamar"]["jumlah_kamar"];
  $bank = $_SESSION["bank"]["pilih"];

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
    <section class="page-section ftco-section ftco-animate ftco-no-pb">
      <div class="container container-pembayaran">
        <div class="row">
          <div class="col-md-12 heading-section">
            <h2 class="mb-1">Pesanan</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div id="contentOne" class="card border rounded p-3 b-top-content shadow-sm" tabindex="-1">
              <div class="row">
                <div class="col">
                  <h3>Informasi</h3>
                  <div class="d-flex flex-column border-bottom">
                    <h5><i class="fas fa-info-circle text-danger"></i> Harap upload bukti transaksi dalam waktu dua jam!</h5>
                    <h5><i class="fas fa-exclamation-triangle text-warning"></i> Jika Anda ingin mengubah data pesanan, harap dilakukan sebelum membayar ke rekening tujuan!</h5>
                  </div>
                  <div class="d-flex justify-content-between align-items-center py-2 border-bottom bg-light px-2">
                    <?php if ($bank === "bca"): ?>
                      <h5 class="pt-2">Bank Central Asia</h5>
                    <?php elseif($bank === "mandiri") : ?>
                      <h5 class="pt-2">Bank Mandiri</h5>
                    <?php elseif($bank === "bri") : ?>
                      <h5 class="pt-2">BRI</h5>
                    <?php elseif($bank === "bni") : ?>
                      <h5 class="pt-2">BNI</h5>
                    <?php endif; ?>
                    <img src="../assets/images/<?=$bank?>.png" alt="">
                  </div>
                  <table>
                    <tr>
                      <th class="py-xl-3"><h4>Nomor Rekening</h4></th>
                      <td class="py-xl-3 px-xl-3 pr-3"><h4>:</h4></td>
                      <td class="py-xl-3"><h4>--- --- ----</h4></td>
                    </tr>
                    <tr>
                      <th class="py-xl-3"><h4>Pemilik</h4></th>
                      <td class="py-xl-3 px-xl-3 pr-3"><h4>:</h4></td>
                      <td class="py-xl-3"><h4>Widuri Villa</h4></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- your reservation -->
          <div class="col-lg-12 ftco-animate">
            <div id="contentTwo" class="card border p-4 mb-2 b-top-content shadow-sm" tabindex="-1">
              <div class="row">
                <div class="col-12">
                  <div class="position-absolute" style="right: 5px; top: 5px;" data-toggle="tooltip" data-placement="top" title="Ubah data reservasi">
                    <button data-toggle="modal" data-target="#confirmEditPesanan" class="btn btn-light text-primary px-2 py-1 shadow-sm" style="font-size: 17px">
                      <i class="fas fa-pen"></i>
                    </button>
                  </div>
                  <h2 class="text-center border-bottom pb-4">Reservasi Anda</h2>
                </div>

                <div class="col-md-7">
                  <?php foreach (array_combine($id_kamar, $JmlKamar) as $key => $JmlKamarTerpilih): ?>
                    <?php
                      $query = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE id_tipe_kamar = ".$key."");
                      $row = mysqli_fetch_assoc($query);
                    ?>
                    <div class="row">
                      <div class="col-md-5 py-2">
                        <div class="gambar-kamar rounded shadow-sm">
                          <div class="carousel-item active">
                            <img class="img-fluid rounded" src="../assets/foto_tipe_kamar/<?php echo $row["foto_tipe_kamar"]; ?>" alt="">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-7">
                        <div class="d-flex justify-content-between align-items-center pt-1">
                          <h4><?php echo $row["nama_tipe_kamar"]; ?></h4>
                          <h5>Jumlah kamar: <b><?php echo $JmlKamarTerpilih; ?></b></h5>
                        </div>
                        <div class="pt-2">
                        <h6>Fasilitas :</h6>
                        <?php
                          $fasilitas = explode(',', $row["fasilitas"]);
                          foreach($fasilitas as $value) {
                            echo "<li class='list-unstyled d-inline pr-2 pl-0 text-nowrap'><i class='fas fa-check text-success' style='font-size:10px;'></i> $value</li>";
                          };
                        ?>
                      </div>
                      </div>
                    </div>
                    <hr class='my-1 liner'>
                  <?php endforeach; ?>
                </div>

                <div class="col-md-5 pesananClass left-border">
                  <div class="d-block d-md-none d-xl-none border-bottom border-secondary mt-3 font-weight-bold font-italic">
                    <h4>Rincian Pesanan</h4>
                  </div>
                  <div class="form-group">
                    <label for="total_harga" style="font-size: 20px">Total Pembayaran</label>
                      <div class="form-control border-bottom border-top-0 border-left-0 border-right-0 font-weight-bold" style="font-size: 23px">Rp.<?php echo number_format($total_harga,2,',','.'); ?>,-</div>
                  </div>
                  <div class="form-group">
                    <label for="tgl_c1" class="mb-0">Checkin</label>
                    <input type="text" id="tgl_c1" class="form-control pem border-top-0 border-right-0 pt-0 border-left-0" value="<?php echo $tglCI ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="tgl_co" class="mb-0">Checkout</label>
                    <input type="text" id="TK" class="form-control pem inputangka border-top-0 border-right-0 border-left-0" value="<?php echo $tglCO ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="jml_adlt" class="mb-0">Dewasa</label>
                    <input type="text" value="<?php echo $adlt ?>" id="jml_adlt" class="form-control pem border-top-0 border-right-0 border-left-0" readonly>
                  </div>
                  <div class="form-group">
                    <label for="jml_ank" class="mb-0">Anak-anak</label>
                    <input type="text" value="<?php echo $cild ?>" id="jml_ank" class="form-control pem border-top-0 border-right-0 border-left-0" readonly>
                  </div>
                  <div class="form-group">
                    <label for="jmlKamar">Jumlah kamar terpilih</label>
                    <input type="text" id="jmlKamar" class="form-control pem border-top-0 border-right-0 border-left-0"  value="<?php echo $jumlah_kamar ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label class="mb-0">Jumlah hari</label>
                    <input type="text" name="inp_totalTtanggal" value="<?php echo "$jmlHari" ?>" class="form-control pem border-0" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-12 px-0 mt-4 border-top d-flex align-self-center align-items-center flex-column justify-content-center flex-md-wrap">
                <h3 class="mt-4">Sudah membayar?</h3>
                <a href="uploadbuktitransaksi.php" id="btnUpload" class="btn btn-primary py-2 font-weight-bold ml-md-3 shadow-sm">UPLOAD BUKTI TRANSAKSI</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Fasility -->
    <div class="modal fade" id="confirmEditPesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
          <div class="modal-header py-2">
            <h5 class="modal-title" id="exampleModalLabel">Edit Pesanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <h4 class="text-secondary">Yakin ingin mengubah data reservasi?</h4>
            <h5 class="text-danger"><i class="fas fa-exclamation-triangle text-warning"></i> Kamar yang Anda pilih sebelumnya mungkin akan berkurang atau hilang.</h5>
            <form action="" method="POST">
              <input type="hidden" name="id_reservasi" value="<?php echo $lastRes; ?>">
              <input type="hidden" name="ketRes_Tamu" value="Online">
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" name="submitEditReservasi" class="btn btn-primary px-4 font-weight-bold">Yakin!</button>
            </form>
          </div>
        </div>
      </div>
    </div>
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
          location.reload();
        });
      };
    </script>
    <?php 
      if( isset($_POST["submitEditReservasi"]) ) {
        if( KembalikanJumlahKamar($_POST) > 0 ) {
          unset($_SESSION['LAST_ACTIVITY']);
          header('Location:kamar_pilihan_BARU3.php');
        }
      }
    ?>
  </body>
</html>
<?php ob_end_flush(); ?>