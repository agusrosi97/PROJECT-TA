<?php 
  session_start();
  if ( !empty($_SESSION['loggedin']) ) {
    header('location: ../../index.php');
    exit;
  }
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Widuri Villa - Register</title>
  <meta name="description" content="Widuri Viila">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../../assets/images/logo-w.png">
  <link rel="apple-touch-icon" href="../../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" type="text/css" href="../../assets-2/css/style.css">
  <link rel="stylesheet" type="text/css" href="../../assets/css/sweetalert2.min.css">
  <link rel='stylesheet' type="text/css" href='../../assets/css/jquery-ui.min.css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body class="">
  <div class="wrapper-register">
    <div class="wrapper-img-register">
      <img src="../../assets/images/20190502_091550_Richtone(HDR).jpg" alt="" class="img-register">
    </div>     
    <div class="register-form px-5">
      <div class="position-relative form-tamu-register">
        <form method="POST" action="" enctype="multipart/form-data">
          <button onclick="window.history.go(-1); return false;" type="button" class="btn btn-light position-absolute col-3 p-2 rounded shadow-sm text-secondary" style="z-index: 1; top: -20px; left: -30px;"><i class="fas fa-chevron-left"></i> Back</button>
          
          <input type="hidden" name="tanpaFoto" value="">

          <div class="col-md-12 d-flex justify-content-center align-items-center">
            <label for="img1" class="custom-file-upload">
              <div class="wrapper-avatar shadow">
                <i class="fas fa-user-plus"></i>
                <img id="preview-img1" />
                <span class="hover--img"></span>
              </div>
            </label>
            <input type="file" id="img1" class="FotoUpload" name="inp_foto_tamu">
          </div>

          <div class="form-row">
            <div class="form-group position-relative wrapper-inp-register col-md-7">
              <label>Nama Anda <sup class="harus-isi">*</sup></label>
              <input type="text" class="form-control register-inp" placeholder="Nama Anda" name="inp_nama_tamu" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-5">
              <label for="tamu_tgl">Tgl Lahir <sup class="harus-isi">*</sup></label>
              <input id="tamu_tgl" type="text" class="form-control register-inp" name="inp_tgllahir_tamu" required autocomplete="off" placeholder="Tanggal lahir">
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-7">
              <label>Email <sup class="harus-isi">*</sup></label>
              <input type="email" class="form-control register-inp" placeholder="Email" name="inp_email_tamu" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-5">
              <label>Nomor telepon <sup class="harus-isi">*</sup></label>
              <input type="number" class="form-control register-inp" placeholder="Telpon" name="inp_tlp_tamu" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register nobdr col-md-6">
              <label>Jenis kelamin <sup class="harus-isi">*</sup></label>
              <select class="form-control register-inp" name="inp_jk_tamu" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
              <span class="inp-focus" style="z-index: 2"></span>
            </div>
          </div>

          <div class="form-row">

            <div class="form-group position-relative wrapper-inp-register col-md-12">
              <label>Address <sup class="harus-isi">*</sup></label>
              <textarea class="form-control register-inp" placeholder="Your address" name="inp_alamat_tamu" required></textarea>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-6 pt-3">
              <label>Password <sup class="harus-isi">*</sup></label>
              <input type="password" class="form-control register-inp" placeholder="Password" id="inp-pass--2" required>
              <span class="inp-focus"></span>
              <div class="btn-show-password" title="Show password" id="btn-toggle-pass--2">
                <i class="fas fa-eye"></i>
              </div>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-6 pt-3">
              <label>Confirm Password <sup class="harus-isi">*</sup></label>
              <input type="password" class="form-control register-inp" placeholder="Password" id="inp-pass--3" name="inp_pass_tamu" required>
              <span class="inp-focus"></span>
              <div class="btn-show-password" title="Show password" id="btn-toggle-pass--3">
                <i class="fas fa-eye"></i>
              </div>
              <span id="pesan" class="pesan_check"><i class="fas fa-check"></i></span>
            </div>
            
          </div>

          <div class="text-center pt-3">
            <button type="submit" class="btn btn-darkblue btn-flat m-b-30 m-t-30" id="btn-register" name="submit">REGISTER</button>
          </div>
  
          <div class="register-link mt-4 text-center">
            <p>Login <a href="../../tamu/login.php" class="text-primary">Here !</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <script type="text/javascript" src="../../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../../assets/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="../../assets/js/datepicker-id.js"></script>
  <script type="text/javascript" src="../../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../assets/js/sweetalert2.min.js"></script>
  <script src="../../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type="text/javascript">
    $('#tamu_tgl').datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "-150:+0",
    });
  </script>
  <?php
    require '../../koneksi/function_global.php';
    if( isset($_POST["submit"]) ) {
      if( register($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Terimakasih telah bergabung bersama kami. 🙂',
              showConfirmButton: false,
              timer: 1000
            }).then(function() {
              window.location.href = '../metodePembayaran.php';
            });
          </script>
        ";
      } else {
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Gagal membuat akun!'
            }).then(function() {
              window.location.href = 'register.php';
            })
          </script>
        ";
      }
    }
  ?>

</body>

</html>