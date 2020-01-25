<?php 
	$data_pengguna = mysqli_query($conn, "SELECT * FROM tbl_pengguna WHERE id_pengguna = '$id'");

  if ( mysqli_num_rows($data_pengguna) === 1 ) {
    $row = mysqli_fetch_assoc($data_pengguna);
    $namanya = $row["username_pengguna"];
    $tglLahirnya = $row["tgl_lahir_pengguna"];
    $emailnya = $row["email_pengguna"];
    $notelpnya = $row["no_telp_pengguna"];
    $jk_pengguna = $row["jk_pengguna"];
    $alamatnya = $row["alamat_pengguna"];
    $fotonya = $row["foto_pengguna"];
  };
?>