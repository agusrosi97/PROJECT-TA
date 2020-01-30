<?php
session_start();
require '../koneksi/function_global.php';
if (isset($_POST["submit"])) {
  $email_tamu = strtolower(htmlspecialchars($_POST["inp_email_tamu"]));
  $password_tamu = strtolower(htmlspecialchars($_POST["inp_pass_tamu"]));
  $result = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE email_tamu = '$email_tamu'");
  $cekTamuIseng = mysqli_query($conn, "SELECT tbl_transaksi_pembayaran.*, tbl_tamu.*
        FROM tbl_transaksi_pembayaran
        INNER JOIN tbl_tamu ON tbl_transaksi_pembayaran.id_tamu = tbl_tamu.id_tamu
        WHERE tbl_tamu.email_tamu = '" . $email_tamu . "' AND `status` = 'GAK VALID'
      ");
  // cek username
  if (mysqli_num_rows($result) === 1) {
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
    if (password_verify($password_tamu, $row["password_tamu"])) {
      if (mysqli_num_rows($cekTamuIseng) >= 3) {
        echo "iseng";
      } else {
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
        echo "hore";
      }
    } else {
      echo "salah password";
    }
  } else {
    echo "bodong";
  }
}
?>