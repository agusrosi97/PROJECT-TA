<?php 
  session_start();
  if ( empty($_SESSION['loggedin']) ) {
    header('location: ../index.php');
    exit;
  }
  require '../koneksi/function_global.php';
  // ambil data di URL
  $id_tamuuu = $_GET["id"];
  // query data mahasiswa berdasarkan id
  $data_tamuKu = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE md5(id_tamu) = '$id_tamuuu'");
  $data_tamu = mysqli_fetch_assoc($data_tamuKu);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Widuri Villa - Ubah password</title>
  <meta name="description" content="Widuri Viila">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo-w.png">
  <link rel="apple-touch-icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" href="../vendors-2/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
</head>
<body>
  <div class="wrapper-login">
    <div class="wrapper-img-login">
      <img src="../assets/images/20190502_091550_Richtone(HDR).jpg" alt="" class="img-login">
    </div>     
    <div class="login-form px-5">
      <div class="text-center pb-4 mb-md-5 mb-lg-5 position-relative">
        <button onclick="window.history.go(-1); return false;" type="button" class="btn btn-light position-absolute col-3 p-2 rounded shadow-sm text-secondary" style="z-index: 1; top: -20px; left: -30px;"><i class="fas fa-chevron-left"></i> Back</button>
        <a href="index.html">
          <img class="align-content" src="../assets/images/logo-title.png" alt="" width="119.5" height="80">
        </a>
      </div>
      <div class="position-relative form-tamu-login">
        <form action="" method="post">
          <input type="hidden" name="inp_id_tamu" value="<?php echo $data_tamu["id_tamu"] ?>">
          <div class="form-group position-relative wrapper-inp-login">
            <label>Password Saat ini</label>
            <!-- input -->
            <input type="password" name="inp_pass_lama_tamu" class="form-control login-inp" placeholder="Password saat ini." id="inp-pass-lama">
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass-lama">
              <i class="fas fa-eye"></i>
            </div>
          </div>
          <div class="form-group position-relative wrapper-inp-login">
            <label>Password Baru</label>
            <!-- input -->
            <input type="password" name="inp_pass_baru_tamu" class="form-control login-inp" placeholder="Password baru" id="inp-pass-baru">
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass-baru">
              <i class="fas fa-eye"></i>
            </div>
          </div>
          <div class="form-group position-relative wrapper-inp-register">
            <label>Confirm Password</label>
            <!-- input -->
            <input type="password" class="form-control register-inp" placeholder="Password" id="inp-pass-confirm-tamu" name="inp_pass_ubah_tamu" required>
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass--3">
              <i class="fas fa-eye"></i>
            </div>
            <span id="pesan" class="pesan_check"><i class="fas fa-check"></i></span>
          </div>
          <div class="text-center pt-3">
            <button type="submit" name="submit" class="btn btn-darkblue btn-flat mb-2 m-t-30" id="btn-register">UBAH PASSWORD</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  <script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
  <script type="text/javascript" src="../assets-2/js/Popper.js"></script>
  <script type="text/javascript" src="../assets-2/js/bootstrap.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
  <?php 
    if( isset($_POST["submit"]) ) {
      // cek apakah data berhasil diubah atau tidak
      if( ubah_pass($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Password berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
              }).then(function() {
              javascript:history.go(-2);
            });
          </script>
        ";
      }
    }
  ?>
</body>
</html>