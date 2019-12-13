<?php 
  session_start();

  if ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "owner") ) {
    header('location: ../owner/index.php');
    exit;
  }
  elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "admin") ) {
    header('location: ../admin/index.php');
    exit;
  }
  elseif ( !empty($_SESSION['loggedin_pengguna']) AND ($_SESSION["loggedin_pengguna"]["level_pengguna"] == "staf") ) {
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
  <link rel="stylesheet" href="../vendors-2/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets/js/sweetalert2.min.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
</head>
<body>
  <?php 
  require '../koneksi/function_global.php';

  if( isset($_POST["submit"]) ) {

    $email_pengguna = strtolower(htmlspecialchars($_POST["inp_email_pengguna"]));
    $password_pengguna = strtolower(htmlspecialchars($_POST["inp_pass_pengguna"]));

    $result = mysqli_query($conn, "SELECT * FROM tbl_pengguna WHERE email_pengguna = '$email_pengguna'");

    if( mysqli_num_rows($result) === 1 ) {

      $row = mysqli_fetch_assoc($result);

      if ($row["status_pengguna"] === 'Aktif') {

        $id = $row["id_pengguna"];
        $level_pengguna = $row["hak_akses_pengguna"];
        $email = $row["email_pengguna"];
        $nama_pengguna = $row["username_pengguna"];
        $tgl_lahir_pengguna = $row["tgl_lahir_pengguna"];
        $no_telp_pengguna = $row["no_telp_pengguna"];
        $jk = $row["jk_pengguna"];
        $alamat_pengguna = $row["alamat_pengguna"];
        $foto_pengguna = $row["foto_pengguna"];

        if( password_verify($password_pengguna, $row["password_pengguna"]) ) {

          if($row['hak_akses_pengguna'] == "owner"){
   
            $_SESSION["loggedin_pengguna"] = array();
            $_SESSION["loggedin_pengguna"]["id_pengguna"] = $id;
            $_SESSION["loggedin_pengguna"]["level_pengguna"] = $level_pengguna;
            $_SESSION["loggedin_pengguna"]["email"] = $email;
            $_SESSION["loggedin_pengguna"]["nama_pengguna"] = $nama_pengguna;
            $_SESSION["loggedin_pengguna"]["tgl_lahir_pengguna"] = $tgl_lahir_pengguna;
            $_SESSION["loggedin_pengguna"]["no_telp_pengguna"] = $no_telp_pengguna;
            $_SESSION["loggedin_pengguna"]["jk_pengguna"] = $jk;
            $_SESSION["loggedin_pengguna"]["alamat_pengguna"] = $alamat_pengguna;
            $_SESSION["loggedin_pengguna"]["foto_pengguna"] = $foto_pengguna;

            echo "
              <script>
                Swal.fire({
                  type: 'success',
                  title: 'Selamat Datang!',
                  showConfirmButton: false,
                  timer: 2000
                }).then(function() {
                  window.location.href = '../owner/index.php';
                })
              </script>
            ";
          }else if($row['hak_akses_pengguna'] == "admin"){
            $_SESSION["loggedin_pengguna"] = array();
            $_SESSION["loggedin_pengguna"]["id_pengguna"] = $id;
            $_SESSION["loggedin_pengguna"]["level_pengguna"] = $level_pengguna;
            $_SESSION["loggedin_pengguna"]["email"] = $email;
            $_SESSION["loggedin_pengguna"]["foto_pengguna"] = $foto_pengguna;
            $_SESSION["loggedin_pengguna"]["nama_pengguna"] = $nama_pengguna;
            $_SESSION["loggedin_pengguna"]["tgl_lahir_pengguna"] = $tgl_lahir_pengguna;
            $_SESSION["loggedin_pengguna"]["no_telp_pengguna"] = $no_telp_pengguna;
            $_SESSION["loggedin_pengguna"]["jk_pengguna"] = $jk;
            $_SESSION["loggedin_pengguna"]["alamat_pengguna"] = $alamat_pengguna;
            echo "
              <script>
                Swal.fire({
                  type: 'success',
                  title: 'Selamat Datang!',
                  showConfirmButton: false,
                  timer: 2000
                }).then(function() {
                  window.location.href = '../admin/index.php';
                })
              </script>
            ";
          }else if($row['hak_akses_pengguna'] == "staf"){
            $_SESSION["loggedin_pengguna"] = array();
            $_SESSION["loggedin_pengguna"]["id_pengguna"] = $id;
            $_SESSION["loggedin_pengguna"]["level_pengguna"] = $level_pengguna;
            $_SESSION["loggedin_pengguna"]["email"] = $email;
            $_SESSION["loggedin_pengguna"]["foto_pengguna"] = $foto_pengguna;
            $_SESSION["loggedin_pengguna"]["nama_pengguna"] = $nama_pengguna;
            $_SESSION["loggedin_pengguna"]["tgl_lahir_pengguna"] = $tgl_lahir_pengguna;
            $_SESSION["loggedin_pengguna"]["no_telp_pengguna"] = $no_telp_pengguna;
            $_SESSION["loggedin_pengguna"]["jk_pengguna"] = $jk;
            $_SESSION["loggedin_pengguna"]["alamat_pengguna"] = $alamat_pengguna;
            echo "
              <script>
                Swal.fire({
                  type: 'success',
                  title: 'Selamat Datang!',
                  showConfirmButton: false,
                  timer: 2000
                }).then(function() {
                  window.location.href = '../staf/index.php';
                })
              </script>
            ";
          }
        }else{
          echo "
            <script>
              Swal.fire({
                type: 'error',
                title: 'Email atau kata sandi Anda salah!',
                showConfirmButton: false,
                timer : 2000
              }).then(function() {
                window.location.href = '../login/login.php';
              })
            </script>
          ";
        }
      }else{
        echo "
          <script>
            Swal.fire({
              type: 'error',
              title: 'Mohon maaf ☹',
              html: 'Akun Anda sudah <b class=text-danger>tidak Aktif</b> !',
              showConfirmButton: false,
              timer : 2000
            }).then(function() {
              window.location.href = '../login/login.php';
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
            window.location.href = '../login/login.php';
          })
        </script>
      ";
    }
  }
  ?>

  <div class="wrapper-login">
    <div class="wrapper-img-login">
      <!-- <img src="../assets/images/20190502_091550_Richtone(HDR).jpg" alt="" class="img-login"> -->
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
            <input type="email" name="inp_email_pengguna" class="form-control login-inp" placeholder="Email">
            <span class="inp-focus"></span>
          </div>
          <div class="form-group position-relative wrapper-inp-login">
            <label>Password</label>
            <input type="password" name="inp_pass_pengguna" class="form-control login-inp" placeholder="Password" id="inp-pass">
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass">
              <i class="fas fa-eye"></i>
            </div>
            
          </div>
          <div class="text-center">
            <button type="submit" name="submit" class="btn btn-darkblue btn-flat m-b-30 m-t-30">Sign in</button>
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