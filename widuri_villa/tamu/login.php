<?php 
  session_start();

  if ( !empty($_SESSION['loggedin']) ) {
    header('location: ../index.php');
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
  <link rel="stylesheet" href="../vendors-2/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">

  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets/js/sweetalert2.min.js"></script>

  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>

</head>
<body>
  <?php 
  require '../koneksi/function_global.php';
  if( isset($_POST["submit"]) ) {


    $email_tamu = strtolower(htmlspecialchars($_POST["inp_email_tamu"]));
    $password_tamu = strtolower(htmlspecialchars($_POST["inp_pass_tamu"]));

    $result = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE email_tamu = '$email_tamu'");

    // cek username
    if( mysqli_num_rows($result) === 1 ) {

      
      $row = mysqli_fetch_assoc($result);
      // ambil data foto dri row yang diambil lagi dari data yang ada
      $id = $row['id_tamu'];
      $nama_tamu = $row["nama_tamu"];
      $tgl_lahir_tamu = $row["tgl_lahir_tamu"];
      $email_tamu = $row["email_tamu"];
      $password_tamu_old = $row["password_tamu"];
      $no_telp_tamu = $row["no_telp_tamu"];
      $alamat_tamu = $row["alamat_tamu"];
      $jk_tamu = $row["jk_tamu"];
      $foto_tamu = $row["foto_tamu"];
      // cek password
      if( password_verify($password_tamu, $row["password_tamu"]) ) {
        // set session
        $_SESSION["loggedin"] = array();
        $_SESSION["loggedin"]["id_tamu"] = $id;
        $_SESSION["loggedin"]["nama_tamu"] = $nama_tamu;
        $_SESSION["loggedin"]["tgl_lahir_tamu"] = $tgl_lahir_tamu;
        $_SESSION["loggedin"]["email_tamu"] = $email_tamu;
        $_SESSION["loggedin"]["password_tamu"] = $password_tamu_old;
        $_SESSION["loggedin"]["no_telp_tamu"] = $no_telp_tamu;
        $_SESSION["loggedin"]["alamat_tamu"] = $alamat_tamu;
        $_SESSION["loggedin"]["jk_tamu"] = $jk_tamu;
        $_SESSION["loggedin"]["foto_tamu"] = $foto_tamu;

        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Selamat Datang!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = '../index.php';
            })
          </script>
        ";
      }else{
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Email atau kata sandi Anda salah!',
              showConfirmButton: false,
              timer : 2000
            }).then(function() {
              window.location.href = '../tamu/login.php';
            })
          </script>
        ";
      }
    }else{
      echo "
        <script>
          Swal.fire({
            type: 'error',
            title: 'Email Anda belum terdaftar!',
            showConfirmButton: false,
            timer : 2000
          }).then(function() {
            window.location.href = '../tamu/login.php';
          })
        </script>
      ";
    }
  }
  ?>
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
        <form action="" method="post">
          <div class="form-group position-relative wrapper-inp-login">
            <label>Email address</label>
            <input type="email" name="inp_email_tamu" class="form-control login-inp" placeholder="Email">
            <span class="inp-focus"></span>
          </div>
          <div class="form-group position-relative wrapper-inp-login">
            <label>Password</label>
            <input type="password" name="inp_pass_tamu" class="form-control login-inp" placeholder="Password" id="inp-pass">
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass">
              <i class="fas fa-eye"></i>
            </div>
            
          </div>
          <div class="text-center">
            <button type="submit" name="submit" class="btn btn-darkblue btn-flat m-b-30 m-t-30">Sign in</button>
          </div>
          <div class="register-link mt-lg-4 text-center">
            <p>Don't have account ? <a href="../tamu/register.php"> Sign Up Here</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <script src="../assets-2/js/main.js"></script>
</body>

</html>
