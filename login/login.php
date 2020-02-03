<?php
session_start();

if (!empty($_SESSION['loggedin_pengguna']) and ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "owner")) {
  header('location: ../owner/index.php');
  exit;
} elseif (!empty($_SESSION['loggedin_pengguna']) and ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "admin")) {
  header('location: ../admin/index.php');
  exit;
} elseif (!empty($_SESSION['loggedin_pengguna']) and ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "staf")) {
  header('location: ../staf/index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Widuri Villa - Login</title>
  <meta name="description" content="Widuri Viila">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="apple-touch-icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
</head>

<body>

  <div class="wrapper-login">
    <div class="wrapper-img-login">
      <img src="../assets/images/20190502_091550_Richtone(HDR).jpg" alt="" class="img-login">
    </div>
    <div class="login-form px-5">
      <div class="text-center pb-4 mb-md-5 mb-lg-5">
        <a href="index.html">
          <img class="align-content" src="../assets/images/logo-title.png" alt="" width="119.5" height="80">
        </a>
      </div>
      <div class="position-relative form-tamu-login">
        <form id="login-form" method="post">
          <div class="form-group position-relative wrapper-inp-login">
            <label>Email address</label>
            <input type="email" name="inp_email_pengguna" class="form-control login-inp" placeholder="Email" autofocus>
            <span class="inp-focus"></span>
          </div>
          <div class="form-group position-relative wrapper-inp-login">
            <label>Password</label>
            <input type="password" name="inp_pass_pengguna" class="form-control login-inp" placeholder="Password" id="inp-pass" autocomplete="true">
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass">
              <i class="fas fa-eye"></i>
            </div>
          </div>
          <div class="text-center">
            <button id="btn-login" type="submit" name="submit" class="btn btn-darkblue btn-flat m-b-30 m-t-30">Sign in</button>
          </div>
        </form>
      </div>
      <div id="error" style="margin-top: 10px"></div>
    </div>
  </div>
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" /></svg></div>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../assets/js/sweetalert2.min.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script>
    $(document).ready(function() {
      $("#login-form").validate({
        rules: {
          inp_email_pengguna: {
            required: true,
            email: true
          },
          inp_pass_pengguna: {
            required: true,
          },
        },
        messages: {
          inp_email_pengguna: "Masukkan Email Anda!",
          inp_pass_pengguna: {
            required: "Masukkan Password Anda!"
          },
        },
        submitHandler: submitForm
      });

      function submitForm() {
        var data = $('#login-form').serialize();
        $.ajax({
          type: 'POST',
          url: '../url_ajax/proses_login_admin.php',
          data: data,
          beforeSend: function() {
            $("#error").fadeOut();
            $("#btn-login").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only"></span>');
          },
          success: function(response) {
            if (response == 'owner') {
              Swal.fire({
                type: 'success',
                title: 'Selamat Datang!',
                showConfirmButton: false,
                timer: 2000
              }).then(function() {
                window.location.href = '../owner/index.php';
              })
            } else if (response == 'admin') {
              Swal.fire({
                type: 'success',
                title: 'Selamat Datang!',
                showConfirmButton: false,
                timer: 2000
              }).then(function() {
                window.location.href = '../admin/index.php';
              })
            } else if (response == 'staf') {
              Swal.fire({
                type: 'success',
                title: 'Selamat Datang!',
                showConfirmButton: false,
                timer: 2000
              }).then(function() {
                window.location.href = '../staf/index.php';
              })
            } else if (response == 'salah password') {
              Swal.fire({
                type: 'error',
                title: 'Email atau kata sandi Anda salah!',
                showConfirmButton: false,
                timer: 2000
              })
            } else if (response == 'pensi') {
              Swal.fire({
                type: 'error',
                title: 'Mohon maaf ☹',
                html: 'Akun Anda sudah <b class=text-danger>tidak Aktif</b> !',
                showConfirmButton: false,
                timer: 2000
              })
            } else if (response == 'bodong') {
              Swal.fire({
                type: 'error',
                title: 'Email Anda belum terdaftar!',
                showConfirmButton: false,
                timer: 2000
              })
            }
          },
          complete: function() {
            $("#btn-login").html('Sign in');
          }
        });
        return false;
      }
    });
  </script>
</body>

</html>