<?php
  session_start();
  require '../koneksi/function_global.php';
  if (isset($_POST["submit"])) {
    $email_pengguna = strtolower(htmlspecialchars($_POST["inp_email_pengguna"]));
    $password_pengguna = strtolower(htmlspecialchars($_POST["inp_pass_pengguna"]));
    $result = mysqli_query($conn, "SELECT * FROM tbl_pengguna WHERE email_pengguna = '$email_pengguna'");
    if (mysqli_num_rows($result) === 1) {
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
        if (password_verify($password_pengguna, $row["password_pengguna"])) {
          if ($row['hak_akses_pengguna'] == "owner") {
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
            echo "owner";
          } else if ($row['hak_akses_pengguna'] == "admin") {
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
            echo "admin";
          } else if ($row['hak_akses_pengguna'] == "staf") {
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
            echo "staf";
          }
        } else {
          echo "salah password";
        }
      } else {
        echo "pensi";
      }
    } else {
      echo "bodong";
    }
  }
?>