<?php
  ob_start();
  session_start();
  require '../koneksi/function_global.php';
  if (empty($_SESSION["pilihanKamar"])) :
    header("location:../index.php");
  elseif (empty($_SESSION["confirmPesanan"])) :
    header("location:../index.php");
  endif;
  // get session
  $tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
  $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
  $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
  $adlt = $_SESSION["pilihanKamar"]["adt"];
  $cild = $_SESSION["pilihanKamar"]["cld"];
  $total_harga = hilangkanTitik($_SESSION["pilihanKamar"]["total_harga"]);
  $jumlah_kamar = $_SESSION["pilihanKamar"]["jumlah_kamar"];
  $id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
  $JmlKamar = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
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
  if(!empty($_SESSION["lastID_Transaksi"])):
    $lastIDTrans = $_SESSION["lastID_Transaksi"];
  endif;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Widuri Villa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../assets/images/logo-w.png">
    <link rel="stylesheet" type="text/css" href="../assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/lightgallery.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/lg-transitions.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/aos.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/flaticon.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/icomoon.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/fontawesome-free-5.10.2-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/sweetalert2.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light pembayaran-header" id="ftco-navbar">
      <div class="container-fluid">
        <a class="navbar-brand" type="text/css" href="../index.php"><img src="../assets/images/logo.png" alt="widuri" width="79.5px" height="50px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <div class="tamu-user-small">
            <?php if(!empty($_SESSION['loggedin'])) : ?>
              <div class='dropdown'>
                <div class="wrapper-avatar--2 small-avatar-2 dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                  <?php if($fotoT === "") : ?><img src='../assets/images/user.png' alt=''><?php else : ?><img src='../assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
                </div>
                <div class='dropdown-menu dropdown-menu-right shadow dropdownMenu-tamu' aria-labelledby='navbarDropdown'>
                  <a href='../tamu/user_ubah.php?id=<?=$id?>' class='dropdown-item'><i class='fas fa-cog'></i> Ubah akun</a>
                  <a href='../tamu/user_ubah_password.php?id=<?=$id?>' class='dropdown-item'><i class='fas fa-key'></i> Ganti password</a>
                  <a href='../tamu/logout.php' class='dropdown-item'><i class='fas fa-sign-out-alt'></i> Logout</a>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="../index.php#home" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="../index.php#about" class="nav-link">About</a></li>
            <li class="nav-item"><a href="../index.php#features" class="nav-link">Features</a></li>
            <li class="nav-item"><a href="../index.php#gallery" class="nav-link">Gallery</a></li>
            <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
          </ul>
          <?php
            if(empty($_SESSION["loggedin"])) : ?>
              <div class='d-flex align-items-center justify-content-center logis autoWidth'>
                <a href='../tamu/login.php'><h6 class='mb-0 btn btn-outline-light'>Login</h6></a>
                <a href='../tamu/register.php'><h6 class='mb-0 btn btn-outline-light' style='padding-left: 10px;'>Register</h6></a>
              </div>
            <?php else : ?>
              <div class='dropdown tamu-user'>
                <div class="wrapper-avatar--2 tamu-avatar dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" tabindex="0">
                  <?php if($fotoT === "") : ?><img src='../assets/images/user.png' alt=''><?php else : ?><img src='../assets/foto_tamu/<?= $fotoT; ?>' alt=''><?php endif; ?>
                </div>
                <div class='dropdown-menu dropdown-menu-right shadow' aria-labelledby='navbarDropdown'>
                  <a href='user_ubah.php?id=<?=$id?>' class='dropdown-item'><span class="mr-2"><i class='fas fa-cog'></span></i> Ubah akun</a>
                  <a href='user_ubah_password.php?id=<?=$id?>' class='dropdown-item'><span class="mr-2"><i class='fas fa-key'></i></span> Ganti password</a>
                  <a href='logout.php' class='dropdown-item text-danger'><span class="mr-2"><i class='fas fa-sign-out-alt'></i></span> Logout</a>
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
            <h2 class="mb-1">Metode Pembayaran</h2>
            <a class="text-primary" href="kamar_pilihan_BARU3.php" style="font-size: 20px"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 ftco-animate mb-3">
            <div id="contentOne" class="card border rounded p-3 b-top-content" tabindex="-1">
              <div class="row">
                <div class="col">
                  <h3 class="">Informasi</h3>
                  <div class="d-flex justify-content-between border-bottom mb-2">
                    <h5><i class="fas fa-info-circle text-info"></i> Pembayaran hanya dilakukan melalui Bank Transfer.</h5>
                  </div>
                  <div class="col px-0 d-flex justify-content-between py-3">
                    <h4 class="total_harga">Total Pembayaran Anda :</h4>
                    <h4 class="total_harga"><b>Rp.<?=number_format($total_harga,2,',','.')?>,-</b></h4>
                  </div>
                  <h6>Pilih Rekening tujuan</h6>
                  <form action="" method="POST" id="formMetodePembayaran">
                    <!-- PENTING -->
                    <input type="hidden" value="<?=$id ?>" name="id_tamu">
                    <input type="hidden" value="Online" name="ketRes_Tamu" >
                    <input type="hidden" value="<?=$total_harga ?>" name="inp_totalHarga" >
                    <input type="hidden" value="<?=$tglCI ?>" name="inp_CekIn">
                    <input type="hidden" value="<?=$tglCO ?>" name="inp_CekOut">
                    <input type="hidden" value="<?="$jmlHari" ?>" name="inp_totalTtanggal" >
                    <input type="hidden" value="<?=$adlt ?>" name="inp_orgDewasa">
                    <input type="hidden" value="<?=$cild ?>" name="inp_Anak">
                    <input type="hidden" value="<?=$jumlah_kamar ?>" name="jumlah_kamar">
                    <!-- /PENTING -->
                    <div class="form-group mb-4">
                      <div class="custom-control custom-radio m-3">
                        <input type="radio" class="custom-control-input" id="bca" name="pilih_bank" value="bca" required>
                        <label class="custom-control-label col triggerBtnPilihBank" for="bca"><img src="../assets/images/bca.png" style="position: absolute; top: -11px; cursor: pointer;"></label>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <div class="custom-control custom-radio m-3">
                        <input type="radio" class="custom-control-input" id="mandiri" name="pilih_bank" value="mandiri" required>
                        <label class="custom-control-label col triggerBtnPilihBank" for="mandiri"><img src="../assets/images/mandiri.png" style="position: absolute; top: -11px; cursor: pointer;"></label>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <div class="custom-control custom-radio m-3">
                        <input type="radio" class="custom-control-input" id="bri" name="pilih_bank" value="bri" required>
                        <label class="custom-control-label col triggerBtnPilihBank" for="bri"><img src="../assets/images/bri.png" style="position: absolute; top: -13px; cursor: pointer;"></label>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <div class="custom-control custom-radio m-3">
                        <input type="radio" class="custom-control-input" id="bni" name="pilih_bank" value="bni" required>
                        <label class="custom-control-label col triggerBtnPilihBank" for="bni"><img src="../assets/images/bni.png" style="position: absolute; top: -11px; cursor: pointer;"></label>
                      </div>
                    </div>
                    <div class="col text-center">
                      <button id="btnPilihBank" class="btn btn-primary rounded shadow-sm font-weight-bold" type="button" disabled style="width: 100%; height: 45px" data-toggle="modal" data-target="#confirmPesanan">Lanjut ke pembayaran</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-12 card border rounded p-3 b-top-content mt-3" id="zz" tabindex="-1">
              <div class="d-flex justify-content-center border-bottom">
                <h4>Kamar yang Anda pilih</h4>
              </div>
              <button type="button" class="close btn-close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="col-lg-12 px-0">
                <?php foreach (array_combine($id_kamar, $JmlKamar) as $key => $JmlKamarTerpilih): ?>
                  <?php
                    $query = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE id_tipe_kamar = ".$key."");
                    $row = mysqli_fetch_assoc($query);
                  ?>
                  <div class="row">
                    <div class="col-md-5 py-2">
                      <div class="gambar-kamar rounded shadow-sm">
                        <div class="d-flex align-self-center align-items-center">
                          <img class="img-fluid rounded" src="../assets/foto_tipe_kamar/<?=$row["foto_tipe_kamar"]; ?>" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="d-flex justify-content-between align-items-center pt-1">
                        <h4><?=$row["nama_tipe_kamar"]; ?></h4>
                        <h5>Jumlah kamar: <b><?=$JmlKamarTerpilih; ?></b></h5>
                      </div>
                      <div class="border-top pt-2">
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
            </div>
          </div>
          <!-- your reservation -->
          <div class="col-lg-4 pilihanAnda ftco-animate">
            <div id="contentTwo" class="card border p-4 mb-2 b-top-content" tabindex="-1">
              <h2 class="text-center border-bottom pb-4">Reservasi Anda</h2>
              <div class="form-group">
                <label for="tgl_c1" class="mb-0">Checkin</label>
                <input type="text" id="tgl_c1" class="form-control pem inputangka inputangka border-top-0 border-right-0 pt-0 border-left-0" value="<?=$tglCI ?>" readonly>
              </div>
              <div class="form-group">
                <label for="tgl_co" class="mb-0">Checkout</label>
                <input type="text" id="tgl_co" class="form-control pem inputangka border-top-0 border-right-0 border-left-0" value="<?=$tglCO ?>" readonly>
              </div>
              <div class="form-group">
                <label class="mb-0">Jumlah hari</label>
                <input type="text" id="jumlahHari" value="<?="$jmlHari" ?>" class="form-control pem inputangka border-top-0 border-right-0 border-left-0" readonly>
              </div>
              <div class="form-group">
                <label for="jml_adlt" class="mb-0">Dewasa</label>
                <input type="text" value="<?=$adlt ?>" id="jml_adlt" class="form-control pem border-top-0 border-right-0 border-left-0" readonly>
              </div>
              <div class="form-group">
                <label for="jml_ank" class="mb-0">Anak-anak</label>
                <input type="text" value="<?=$cild ?>" id="jml_ank" class="form-control pem border-top-0 border-right-0 border-left-0" readonly>
              </div>
              <div class="form-group">
                <label for="jmlKamar">Jumlah kamar terpilih</label>
                <input type="text" id="jmlKamar" class="form-control pem border-top-0 border-right-0 border-left-0"  value="<?=$jumlah_kamar ?>" readonly>
              </div>
            </div>
          </div>
          <!-- /your reservation -->
        </div>

    <!-- <?php 
      date_default_timezone_set('Asia/Makassar');
      $id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
      $JmlKamar = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
      $tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
      $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
      $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
      $adlt = $_SESSION["pilihanKamar"]["adt"];
      $cild = $_SESSION["pilihanKamar"]["cld"];
      $total_harga = $_SESSION["pilihanKamar"]["total_harga"];
      $Kam = '';
      $JumKam = '';
      $HarKam = '';
      foreach (array_combine($id_kamar, $JmlKamar) as $key => $JmlKamarTerpilih) {
        $query = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE id_tipe_kamar = ".$key."");
        $rowkam = mysqli_fetch_assoc($query);
        $Kam .= $rowkam['nama_tipe_kamar'].'<br>';
        $JumKam .= $JmlKamarTerpilih.' Kamar <br>';
        $HarKam .= 'Rp.'.number_format($rowkam['harga_kamar'],0,',','.').'</br>';
      }
      $tgl_indo2 = 'tgl_indo2';
      $number_format = 'number_format';
      $hilangkanTitik = 'hilangkanTitik';
      $my_var = <<<EOD
        <html lang="en">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <title></title>
          <style type="text/css">
          </style>    
        </head>
        <body style="margin:0; padding:0; background-color:#FFFFFF;">
          <div>
            <p style="font-size:17px">Terimakasih, Anda sudah memilih Kami sebagai tujuan penginapan Anda.</p>
            <p style="font-size:17px">Pesanan Anda akan segera kami konfirmasi.</p>
          </div>
          <p>Detail Pesanan :</p>
          <div style="border: 1px solid #dee2e6 !important; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; display: inline-block; padding: 10px 20px; border-radius: 0.25rem;position:relative">
            <div style="border-bottom: 1px solid #dee2e6;margin:0 0 10px 0"><h4 style="margin-bottom: 0; font-size:17px">Reservasi Anda</h4></div>
            <table border="0" cellspacing="0">
              <tr >
                <th style="text-align:left;">Checkin</th>
                <td style="padding-right: 15px; padding-left: 10px"> : </td>
                <td>{$tgl_indo2(date_format(new Datetime($tglCI), "Y-m-d"))}</td>
              </tr>
              <tr>
                <th style="text-align:left;">Checkout</th>
                <td style="padding-right: 15px; padding-left: 10px"> : </td>
                <td>{$tgl_indo2(date_format(new Datetime($tglCO), "Y-m-d"))}</td>
              </tr>
              <tr>
                <th style="text-align:left;">Malam</th>
                <td style="padding-right: 15px; padding-left: 10px"> : </td>
                <td>$jmlHari Malam</td>
              </tr>
              <tr>
                <th style="text-align:left;">J. Dewasa</th>
                <td style="padding-right: 15px; padding-left: 10px"> : </td>
                <td>$adlt Orang</td>
              </tr>
              <tr>
                <th style="text-align:left;">J. Anak</th>
                <td style="padding-right: 15px; padding-left: 10px"> : </td>
                <td>$cild</td>
              </tr>
            </table>
            <div style="border-bottom: 1px solid #dee2e6;margin:10px 0"><h4 style="margin-bottom: 0; font-size:17px">Kamar Pilihan</h4></div>
            <table>
              <tr>
                <th>Kamar</th>
                <th style="padding-left:20px; text-align:left;">Harga /Kamar</th>
                <th style="padding-left:20px; text-align:left;">Qty.kamar pilihan</th>
                <th style="padding-left:20px; text-align:left;">Total Bayar</th>
              </tr>
              <tr>
                <td>$Kam</td>
                <td style="padding-left:20px">$HarKam</td>
                <td style="padding-left:20px">$JumKam</td>
                <td valign="middle" style="padding-left:20px">Rp.{$number_format($hilangkanTitik($total_harga),0,',','.')}</td>
              </tr>
            </table>
          </div>
        </body>
        </html>
      EOD;
      echo $my_var;
      ?> -->

      </div>
    </section>
    <!-- /Fasility -->
    <div class="modal fade" id="confirmPesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
          <div class="modal-header py-2">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <h4 class="text-secondary">Anda yakin ingin melanjutkan ke proses pembayaran?</h4>
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <?php if (!empty($lastIDTrans)): ?>
              <button type="submit" name="submitUbahReservasiTamu" class="btn btn-primary px-4" form="formMetodePembayaran">Iya</button>
            <?php else : ?>
              <button type="submit" name="submitMetode" class="btn btn-primary px-4" form="formMetodePembayaran">Iya</button>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <?php include '../footer/footer-tamu.php'; ?>
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
      $('.triggerBtnPilihBank').on('click', function () {
        $('#btnPilihBank').prop('disabled', false);
      });
      $('.close').on('click',function() {
        $(this).closest('#zz').fadeOut();
      });
      $(window).width(function(){
        var win = $(this);
        if (win.width() > 800) {
          $('.btn-close').css('display','none');
        }
        else{
          $('.btn-close').css('display','block');
          $('.pilihanAnda').removeClass('ftco-animate');
        }
      });
      function ConfirmEditReservasi() {
        Swal.fire({
          html: '<h4>Anda yakin ingin melanjutkan ke proses pembayaran?</h4>',
          type: 'question',
          showCloseButton: true,
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
              window.location.href = 'kamar_pilihan_BARU3.php';
            })
          }
        })
      };
    </script>
    <?php 
      if( isset($_POST["submitMetode"]) ) {
        if( PesananReservasiSementara($_POST) > 0 ) {
          header('Location:pesanan2.php');
        }
      }
      if ( isset($_POST["submitUbahReservasiTamu"]) ) {
        if( UpdateReservasiSementara($_POST) > 0 ) {
          header('Location:pesanan2.php');
        }
      }
    ?>
  </body>
</html>
<?php ob_end_flush(); ?>