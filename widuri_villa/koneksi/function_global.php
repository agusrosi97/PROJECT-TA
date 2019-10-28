<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "widurivilla");
function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

////////////////////////////////// ////////////////////////////////// 
//                                TAMU                             //
////////////////////////////////// ////////////////////////////////// 
function register($data) {
	global $conn;
	$nama_tamu = htmlspecialchars($data["inp_nama_tamu"]);
	$tgl_lahir_tamu = htmlspecialchars($data["inp_tgllahir_tamu"]);
	$email_tamu = strtolower(htmlspecialchars($data["inp_email_tamu"]));
	$hp_tamu = htmlspecialchars($data["inp_tlp_tamu"]);
	$jk_tamu = htmlspecialchars($data["inp_jk_tamu"]);
	$password_tamu = strtolower(htmlspecialchars($data["inp_pass_tamu"]));
	$almt_tamu = htmlspecialchars($data["inp_alamat_tamu"]);
	$uploadFotoTamu = htmlspecialchars($data["tanpaFoto"]);

	$result = mysqli_query($conn, "SELECT email_tamu FROM tbl_tamu WHERE email_tamu = '$email_tamu'");

	if( mysqli_fetch_assoc($result) ) {
		echo "
			<script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
      <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
      <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
      <script>
        $( document ).ready(function() {
          Swal.fire({
            type: 'error',
            title: 'Akun sudah terdaftar!',
            showConfirmButton: false,
            timer: 2000  
          });
        });
      </script>
    ";
		return false;
	}

	$password_enc = password_hash($password_tamu, PASSWORD_DEFAULT);

	if( $_FILES['inp_foto_tamu']['error'] === 4 ) {
		$foto_tamu = $uploadFotoTamu;
	} else {
		$foto_tamu = upload();
	}
	

	$query = "INSERT INTO tbl_tamu
						VALUES
					  (null, '$nama_tamu', '$tgl_lahir_tamu', '$email_tamu', '$password_enc', '$hp_tamu', '$almt_tamu', '$jk_tamu', '$foto_tamu')
					";
	mysqli_query($conn, $query);
	
	$query_regis = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE email_tamu = '$email_tamu'");
	if (mysqli_num_rows($query_regis) === 1) :
		$row = mysqli_fetch_assoc($query_regis);
		$idTamu = $row["id_tamu"];
		$fotoTamu = $row["foto_tamu"];

		$_SESSION["loggedin"] = array();
		$_SESSION["loggedin"]["id_tamu"] = $idTamu;
		$_SESSION["loggedin"]["foto_tamu"] = $fotoTamu;
	endif;

	return mysqli_affected_rows($conn);
}

function upload() {
	$namaFile = $_FILES['inp_foto_tamu']['name'];
	$ukuranFile = $_FILES['inp_foto_tamu']['size'];
	$error = $_FILES['inp_foto_tamu']['error'];
	$tmpName = $_FILES['inp_foto_tamu']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
			alert('Upload gambar terlebih dahulu!');
		  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
			alert('Yang Anda upload bukan gambar!');
		  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 1000000 ) {
		echo "<script>
			alert('Gamber yang Anda upload terlalu besar!');
		  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/foto_tamu/' . $namaFileBaru);
	return $namaFileBaru;
}

function ubah($data) {
	global $conn;

	$id = $data["inp_id_tamu"];
	$nama_tamu = htmlspecialchars($data["inp_nama_tamu"]);
	$tgl_lahir_tamu = htmlspecialchars($data["inp_tgllahir_tamu"]);
	$email_tamu = strtolower(htmlspecialchars($data["inp_email_tamu"]));
	$no_telp_tamu = htmlspecialchars($data["inp_tlp_tamu"]);
	$alamat_tamu = htmlspecialchars($data["inp_alamat_tamu"]);
	$jk_tamu = htmlspecialchars($data["inp_jk_tamu"]);
	$foto_tamu_lama = htmlspecialchars($data["inp_foto_LM"]);
	
	// cek apakah user pilih gambar baru atau tidak
	if( $_FILES['inp_foto_tamu']['error'] === 4 ) {
		$foto_tamu = $foto_tamu_lama;
	} else {
		$foto_tamu = upload();
	}

	$query = "UPDATE tbl_tamu SET
				nama_tamu = '$nama_tamu',
				tgl_lahir_tamu = '$tgl_lahir_tamu',
				email_tamu = '$email_tamu',
				no_telp_tamu = '$no_telp_tamu',
				alamat_tamu = '$alamat_tamu',
				jk_tamu = '$jk_tamu',
				foto_tamu = '$foto_tamu'
			  WHERE id_tamu = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

function ubah_pass($data) {
	global $conn;

	$id = $data["inp_id_tamu"];
	$password_tamu_lama = strtolower(htmlspecialchars($data["inp_pass_lama_tamu"]));
	$password_tamu_baru = strtolower(htmlspecialchars($data["inp_pass_ubah_tamu"]));

	$result = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE id_tamu = '$id'");

	if( mysqli_num_rows($result) === 1 ) {

		$row = mysqli_fetch_assoc($result);

		if( password_verify($password_tamu_lama, $row["password_tamu"]) ) {

			$password_tamu_terbaru_enc = password_hash($password_tamu_baru, PASSWORD_DEFAULT);

			$query = "UPDATE tbl_tamu SET
				password_tamu = '$password_tamu_terbaru_enc'
			  WHERE id_tamu = $id
			";

			mysqli_query($conn, $query);

			return mysqli_affected_rows($conn);	
		}
		else
		{
			echo "
				<script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
        <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
        <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
        <script>
          $( document ).ready(function() {
            Swal.fire({
              type: 'error',
              title: 'Password Anda saat ini salah!',
              showConfirmButton: false,
              timer: 2000  
            });
          });
        </script>
			";
			return false;
		}
	}
}

////////////////////////////////// ////////////////////////////////// 
//                               STAF                              //
////////////////////////////////// ////////////////////////////////// 
function stafTambahTamu($data) {
	global $conn;
	$nama_tamu = htmlspecialchars($data["inp_nama_tamu"]);
	$tgl_lahir_tamu = htmlspecialchars($data["inp_tgllahir_tamu"]);
	$email_tamu = strtolower(htmlspecialchars($data["inp_email_tamu"]));
	$hp_tamu = htmlspecialchars($data["inp_tlp_tamu"]);
	$jk_tamu = htmlspecialchars($data["inp_jk_tamu"]);
	$almt_tamu = htmlspecialchars($data["inp_alamat_tamu"]);

	// cek email tamu
	$result = mysqli_query($conn, "SELECT email_tamu FROM tbl_tamu WHERE email_tamu = '$email_tamu'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
			alert('Akun sudah terdaftar!');
		  </script>";
		return false;
	}

	$tlgLahirPass = date_format(new Datetime($tgl_lahir_tamu), "Ymd");

	$password_terbaru = password_hash($tlgLahirPass, PASSWORD_DEFAULT);

	// $foto_tamu = stafUploadFotoTamu();
	// if( !$foto_tamu ) {
	// 	return false;
	// }

	$query = "INSERT INTO tbl_tamu
						VALUES
					  (null, '$nama_tamu', '$tgl_lahir_tamu', '$email_tamu', '$password_terbaru', '$hp_tamu', '$almt_tamu', '$jk_tamu', '')
					";
		
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
	// cek email tamu //
}

function stafUbahTamu($data) {
	global $conn;

	$id = $data["id"];
	$nama_tamu = htmlspecialchars($data["inp_nama_tamu"]);
	$tgl_lahir_tamu = htmlspecialchars($data["inp_tgllahir_tamu"]);
	// $email_tamu = strtolower(htmlspecialchars($data["inp_email_tamu"]));
	$no_telp_tamu = htmlspecialchars($data["inp_tlp_tamu"]);
	$alamat_tamu = htmlspecialchars($data["inp_alamat_tamu"]);
	$jk_tamu = htmlspecialchars($data["inp_jk_tamu"]);
	$foto_tamu_lama = htmlspecialchars($data["inp_foto_tamu"]);

	// $result = mysqli_query($conn, "SELECT email_tamu FROM tbl_tamu WHERE email_tamu = '$email_tamu'");

	// if( mysqli_fetch_assoc($result) ) {
	// 	echo "<script>
	// 			alert('Akun sudah terdaftar!');
	// 		  </script>";
	// 	return false;
	// }
	
	// cek apakah user pilih gambar baru atau tidak
	// if( $_FILES['inp_foto_tamu']['error'] === 4 ) {
	// 	$foto_tamu = $foto_tamu_lama;
	// } else {
	// 	$foto_tamu = upload();
	// }

	$query = "UPDATE tbl_tamu SET
				nama_tamu = '$nama_tamu',
				tgl_lahir_tamu = '$tgl_lahir_tamu',
				no_telp_tamu = '$no_telp_tamu',
				alamat_tamu = '$alamat_tamu',
				jk_tamu = '$jk_tamu',
				foto_tamu = '$foto_tamu_lama'
			  WHERE id_tamu = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

function stafUploadFotoTamu() {
	$namaFile = $_FILES['inp_foto_tamu']['name'];
	$ukuranFile = $_FILES['inp_foto_tamu']['size'];
	$tmpName = $_FILES['inp_foto_tamu']['tmp_name'];
	
	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	
	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 1000000 ) {
		echo "<script>
			alert('Gamber yang Anda upload terlalu besar!');
		  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/foto_tamu/' . $namaFileBaru);
	return $namaFileBaru;
}

////////////////////////////////// ////////////////////////////////// 
// 															ADMIN                              //
////////////////////////////////// ////////////////////////////////// 
function AdminTambahPengguna($data) {
	global $conn;
	$nama_pengguna = htmlspecialchars($data["inp_nama_pengguna"]);
	$tgl_lahir_pengguna = htmlspecialchars($data["inp_tgllahir_pengguna"]);
	$email_pengguna = strtolower(htmlspecialchars($data["inp_email_pengguna"]));
	$akses_pengguna = htmlspecialchars($data["inp_akses_pengguna"]);
	$hp_pengguna = htmlspecialchars($data["inp_tlp_pengguna"]);
	$jk_pengguna = htmlspecialchars($data["inp_jk_pengguna"]);
	$almt_pengguna = htmlspecialchars($data["inp_alamat_pengguna"]);
	$status_pengguna = htmlspecialchars($data["inp_statusPengguna"]);

	$result = mysqli_query($conn, "SELECT email_pengguna FROM tbl_pengguna WHERE email_pengguna = '$email_pengguna'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
			alert('Akun sudah terdaftar!');
		  </script>";
		return false;
	}
  
  $tlgLahirP = date_format(new Datetime($tgl_lahir_pengguna), "Ymd");

	$password_terbaru = password_hash($tlgLahirP, PASSWORD_DEFAULT);

	// $foto_tamu = stafUploadFotoTamu();
	// if( !$foto_tamu ) {
	// 	return false;
	// }

	$query = "INSERT INTO tbl_pengguna
				VALUES
			  (null, '$nama_pengguna', '$password_terbaru', '$email_pengguna', '$akses_pengguna', '$tgl_lahir_pengguna', '$hp_pengguna', '$almt_pengguna', '$jk_pengguna', '','$status_pengguna')
			";
		
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

function AdminUbahPengguna($data) {
	global $conn;

	$id = $data["id"];
	$username_pengguna = htmlspecialchars($data["inp_nama_pengguna"]);
	$tgl_lahir_pengguna = htmlspecialchars($data["inp_tgllahir_pengguna"]);
	$no_telp_pengguna = htmlspecialchars($data["inp_tlp_pengguna"]);
	$akses = htmlspecialchars($data["inp_akses_pengguna"]);
	$alamat_pengguna = htmlspecialchars($data["inp_alamat_pengguna"]);
	$jk_pengguna = htmlspecialchars($data["inp_jk_pengguna"]);
	$status_pengguna = htmlspecialchars($data["inp_status_pengguna"]);
	$foto_pengguna_lama = htmlspecialchars($data["inp_foto_pengguna"]);

	$query = "UPDATE tbl_pengguna SET
				username_pengguna = '$username_pengguna',
				tgl_lahir_pengguna = '$tgl_lahir_pengguna',
				no_telp_pengguna = '$no_telp_pengguna',
				hak_akses_pengguna = '$akses',
				alamat_pengguna = '$alamat_pengguna',
				jk_pengguna = '$jk_pengguna',
				status_pengguna = '$status_pengguna',
				foto_pengguna = '$foto_pengguna_lama'
			  WHERE id_pengguna = '$id'
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

////////////////////////////////// ////////////////////////////////// 
//                               PENGGUNA                          //
////////////////////////////////// //////////////////////////////////
function PenggunaTambahTipeKamar($data) {
	global $conn;
	$namaKamar = htmlspecialchars($data["inp_namaKamar"]);
	$jumlah_kamar = htmlspecialchars($data["inp_jumlahKamar"]);
	$harga_kamar = htmlspecialchars($data["inp_hargaKamar"]);
	$checkFasilitas = implode(', ', ($data["inp_fasilitas"]));
	$foto_Kamar = uploadFotoTipeKamar();
	if( !$foto_Kamar ) {
		return false;
	}
	$query = "INSERT INTO tbl_tipe_kamar VALUES (null,'$namaKamar','$jumlah_kamar','$harga_kamar','$foto_Kamar','$checkFasilitas')";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);	
}

function uploadFotoTipeKamar() {
	$namaFile = $_FILES['inp_foto_tipeKamar']['name'];
	$ukuranFile = $_FILES['inp_foto_tipeKamar']['size'];
	$error = $_FILES['inp_foto_tipeKamar']['error'];
	$tmpName = $_FILES['inp_foto_tipeKamar']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
			alert('Anda belum memilih gambar!');
	  </script>";
		return false;
	}
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
			alert('Yang Anda upload bukan gambar!');
	  </script>";
	  return false;
	}
	if( $ukuranFile > 3000000 ) {
		echo "<script>
			alert('Gamber yang Anda upload terlalu besar!');
	  </script>";
		return false;
	}
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/foto_tipe_kamar/' . $namaFileBaru);
	return $namaFileBaru;
}

function PenggunaUbahTipeKamar($data) {
	global $conn;

	$id = $data["id"];
	$namaKamar = htmlspecialchars($data["udt_namaKamar"]);
	$jumlah_kamar = htmlspecialchars($data["udt_jumlahKamar"]);
	$harga_kamar = htmlspecialchars($data["udt_hargaKamar"]);
	$checkFasilitas = implode(', ', ($data["udt_fasilitas"]));
	$FTKLama = htmlspecialchars($data["udt_fotoTipeKamar_Lama"]);
	if( $_FILES['udt_foto_tipeKamar']['error'] === 4 ) {
		$foto_Kamar = $FTKLama;
	}else{
		$foto_Kamar = UbahFotoTipeKamar();
	}
	$query = "UPDATE tbl_tipe_kamar SET
						nama_tipe_kamar = '$namaKamar',
						jumlah_kamar = '$jumlah_kamar',
						harga_kamar = '$harga_kamar',
						foto_tipe_kamar = '$foto_Kamar',
						fasilitas = '$checkFasilitas'
						WHERE id_tipe_kamar = '$id'
					";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

function UbahFotoTipeKamar() {
	$namaFile = $_FILES['udt_foto_tipeKamar']['name'];
	$ukuranFile = $_FILES['udt_foto_tipeKamar']['size'];
	$error = $_FILES['udt_foto_tipeKamar']['error'];
	$tmpName = $_FILES['udt_foto_tipeKamar']['tmp_name'];
	if( $error === 4 ) {
		echo "<script>
			alert('Sukses!');
		  </script>";
		return $namaFile;
	}
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
			alert('Yang Anda upload bukan gambar!');
	  </script>";
	  return false;
	}
	if( $ukuranFile > 1000000 ) {
		echo "<script>
			alert('Gamber yang Anda upload terlalu besar!');
		  </script>";
		return false;
	}
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/foto_tipe_kamar/' . $namaFileBaru);
	return $namaFileBaru;
}

function ubah_pass_pengguna($data) {
	global $conn;

	$id = $data["inp_id_pengguna"];
	$password_pengguna_lama = strtolower(htmlspecialchars($data["inp_pass_lama_pengguna"]));
	$password_pengguna_baru = strtolower(htmlspecialchars($data["inp_pass_ubah_pengguna"]));

	$result = mysqli_query($conn, "SELECT * FROM tbl_pengguna WHERE id_pengguna = '$id'");

	if( mysqli_num_rows($result) === 1 ) {

		$row = mysqli_fetch_assoc($result);

		if( password_verify($password_pengguna_lama, $row["password_pengguna"]) ) {

			$password_pengguna_terbaru_enc = password_hash($password_pengguna_baru, PASSWORD_DEFAULT);

			$query = "UPDATE tbl_pengguna SET
				password_pengguna = '$password_pengguna_terbaru_enc'
			  WHERE id_pengguna = $id
			";

			mysqli_query($conn, $query);

			return mysqli_affected_rows($conn);	
		}
		else
		{
			echo "
				<script type='text/javascript' src='../assets-2/js/jquery-3.3.1.js'></script>
        <link rel='stylesheet' href='../assets/css/sweetalert2.min.css'>
        <script type='text/javascript' src='../assets/js/sweetalert2.min.js'></script>
        <script>
          $( document ).ready(function() {
            Swal.fire({
              type: 'error',
              title: 'Password Anda saat ini salah!',
              showConfirmButton: false,
              timer: 2000  
            });
          });
        </script>
			";
			return false;
		}
	}
}

function UbahDataDiri_Pengguna($data) {
	global $conn;

	$id = $data["id"];
	$username_pengguna = htmlspecialchars($data["inp_nama_pengguna"]);
	$tgl_lahir_pengguna = htmlspecialchars($data["inp_tgllahir_pengguna"]);
	$no_telp_pengguna = htmlspecialchars($data["inp_tlp_pengguna"]);
	$alamat_pengguna = htmlspecialchars($data["inp_alamat_pengguna"]);
	$jk_pengguna = htmlspecialchars($data["inp_jk_pengguna"]);
	$gakGantiFoto = htmlspecialchars($data["fotoLamanya"]);

	if( $_FILES['inp_foto_pengguna']['error'] === 4 ) {
		$gantiFoto = $gakGantiFoto;
	}else{
		$gantiFoto = upload_FotoDataDiri_pengguna();
	}

	$query = "UPDATE tbl_pengguna SET
		username_pengguna = '$username_pengguna',
		tgl_lahir_pengguna = '$tgl_lahir_pengguna',
		no_telp_pengguna = '$no_telp_pengguna',
		alamat_pengguna = '$alamat_pengguna',
		jk_pengguna = '$jk_pengguna',
		foto_pengguna = '$gantiFoto'
	  WHERE id_pengguna = '$id'
	";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

function upload_FotoDataDiri_pengguna() {
	$namaFile = $_FILES['inp_foto_pengguna']['name'];
	$ukuranFile = $_FILES['inp_foto_pengguna']['size'];
	$error = $_FILES['inp_foto_pengguna']['error'];
	$tmpName = $_FILES['inp_foto_pengguna']['tmp_name'];
	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
			alert('Anda tidak upload foto.');
	  </script>";
	  return false;
	}
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
			alert('Yang Anda upload bukan gambar!');
	  </script>";
	  return false;
	}
	if( $ukuranFile > 1000000 ) {
		echo "<script>
			alert('Gamber yang Anda upload terlalu besar!');
	  </script>";
		return false;
	}
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../assets/foto_pengguna/' . $namaFileBaru);
	return $namaFileBaru;
}

?>