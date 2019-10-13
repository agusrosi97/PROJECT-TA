<?php
  session_start();

  if ( empty($_SESSION['loggedin']))
  {
    header('Location: ../index.php');
    exit;
  }

  require '../koneksi/function_global.php';

  // ambil data di URL
  $id_tamuuu = $_GET["id"];

  // query data mahasiswa berdasarkan id
  $data_tamu = query("SELECT * FROM tbl_tamu WHERE id_tamu = $id_tamuuu")[0];
    
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

  <link rel="shortcut icon" href="../assets/images/logo-w.png">

  <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
  <link rel="apple-touch-icon" href="../assets/images/logo-w.png">
  <link rel="stylesheet" href="../vendors-2/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets-2/fontawesome-free-5.10.2-web/css/all.css">
  <link rel="stylesheet" href="../assets-2/css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body class="">
  <div class="wrapper-register">
    <div class="wrapper-img-register">
      <img src="../assets/images/20190502_091550_Richtone(HDR).jpg" alt="" class="img-register">
    </div>     
    <div class="register-form px-5">
      <div class="position-relative form-tamu-register">
        <form method="POST" action="" enctype="multipart/form-data">

          <input type="hidden" name="inp_id_tamu" value="<?php echo $data_tamu["id_tamu"] ?>">
          <input type="hidden" name="inp_foto_LM" value="<?php echo $data_tamu["foto_tamu"] ?>">

          <div class="col-md-12 d-flex justify-content-center align-items-center">
            <label for="imgInp" class="custom-file-upload">
              <div class="wrapper-avatar shadow">
                <i class="fas fa-user-plus"></i>
                <img id="blah" src="../assets/foto_tamu/<?php echo $data_tamu["foto_tamu"] ?>" alt="" />
                <span class="hover--img"></span>
              </div>
            </label>
            <input id="imgInp" type="file" name="inp_foto_tamu">
          </div>

          <div class="form-row">
            <div class="form-group position-relative wrapper-inp-register col-md-7">
              <label>Nama Anda</label>
              <input type="text" class="form-control register-inp" placeholder="Nama Anda" name="inp_nama_tamu" value="<?php echo $data_tamu["nama_tamu"] ?>" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-5">
              <label for="tamu_tgl">Tgl Lahir</label>
              <input id="tamu_tgl" type="date" class="form-control register-inp" name="inp_tgllahir_tamu" value="<?php echo $data_tamu["tgl_lahir_tamu"] ?>" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-7">
              <label>Email</label>
              <input type="email" class="form-control register-inp" placeholder="Email" name="inp_email_tamu" value="<?php echo $data_tamu["email_tamu"] ?>" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register col-md-5">
              <label>Nomor telepon</label>
              <input type="number" class="form-control register-inp" placeholder="Telpon" name="inp_tlp_tamu" value="<?php echo $data_tamu["no_telp_tamu"] ?>" required>
              <span class="inp-focus"></span>
            </div>

            <div class="form-group position-relative wrapper-inp-register nobdr col-md-6">
              <label>Jenis kelamin</label>
              <select class="form-control register-inp" name="inp_jk_tamu" required>
                <option value="L" <?php if ($data_tamu["jk_tamu"] == 'L') { echo 'selected="selected"'; } ?>>Laki-laki</option>
                <option value="P" <?php if ($data_tamu["jk_tamu"] == 'P') { echo 'selected="selected"'; } ?>>Perempuan</option>
              </select>
              <span class="inp-focus"></span>
            </div>
          </div>

          <div class="form-row">
            
            <div class="form-group position-relative wrapper-inp-register col-md-12">
              <label>Address</label>
              <textarea class="form-control register-inp" placeholder="Your address" name="inp_alamat_tamu" required><?php echo $data_tamu["alamat_tamu"]; ?></textarea>
              <span class="inp-focus"></span>
            </div>

          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-darkblue btn-flat m-b-30 m-t-30" id="btn-register" name="submit">UBAH DATA</button>
          </div>
  
          <div class="register-link mt-lg-4 text-center">
            <p><a href="../index.php">Batal</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="../assets-2/js/bootstrap.js"></script>
  <script src="../assets-2/js/main.js"></script>
  <script type="text/javascript" src="../assets-2/fontawesome-free-5.10.2-web/js/all.js"></script>
  <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>


  <?php 
    if( isset($_POST["submit"]) ) {
    
      // cek apakah data berhasil diubah atau tidak
      if( ubah($_POST) > 0 ) {
        echo "
          <script>
            Swal.fire({
              type: 'success',
              title: 'Data berhasil diubah!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = '../index.php';
            });
          </script>
        ";
      } else {
        echo "
          <script>
            Swal.fire({
              type: 'info',
              title: 'Data tidak ada perubahan.',
              showConfirmButton: false,
              timer: 3000
              }).then(function() {
              window.location.href = '../index.php';             
            });
          </script>
        ";
      }
    }
  ?>

</body>

</html>