<?php 
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
function stringToInt($string){
  $bar = (float) $string;
  return $bar;
};
function hilangkanTitik($nilai) {
  $a = str_replace(".", "", $nilai);
  $a = stringToInt($a);
  return $a;
};
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agu',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ', ' . $pecahkan[0];
};
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
	$query = "INSERT INTO tbl_tamu VALUES (null, '$nama_tamu', '$tgl_lahir_tamu', '$email_tamu', '$password_enc', '$hp_tamu', '$almt_tamu', '$jk_tamu', '$foto_tamu',null)";
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

	$query = "UPDATE tbl_tamu SET nama_tamu = '$nama_tamu', tgl_lahir_tamu = '$tgl_lahir_tamu', email_tamu = '$email_tamu', no_telp_tamu = '$no_telp_tamu', alamat_tamu = '$alamat_tamu', jk_tamu = '$jk_tamu', foto_tamu = '$foto_tamu' WHERE id_tamu = $id";

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

// ========================================================================== //
// ========================= PROSES PESAN SEMENTARA ========================= //
// ========================================================================== //
function PesananReservasiSementara($data) {
	global $conn;
	date_default_timezone_set('Asia/Singapore');
	$id_tamu = $data["id_tamu"];
	$total_harga = $data["inp_totalHarga"];
	$checkIn = $data["inp_CekIn"];
	$checkOut = $data["inp_CekOut"];
	$dewasa = $data["inp_orgDewasa"];
	$anak = $data["inp_Anak"];
	$jumlah_kamar = $data["jumlah_kamar"];
	$jumlahHari = $data["inp_totalTtanggal"];
	$jamSekarang = date('Y-m-d H:i:s a', time());
	$ketRes_Tamu = $data["ketRes_Tamu"];
	$pilihBank = $data["pilih_bank"];
	$qq = 1;
	$id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
	$tipeKamarYangdiPilih = implode(", ", $_SESSION["pilihanKamar"]["tipeKamarTerpilih"]);
	$TotKamarPerPilihan = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
	$jumlahPerKamarYangdiPilih = implode(", ", $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"]);
	$newDateCheckIn = date_format(new Datetime($checkIn), "Y-m-d");
	$newDateCheckOut = date_format(new Datetime($checkOut), "Y-m-d");
	$_SESSION["privasi"] = $qq;
	$_SESSION["bank"]["pilih"] = $pilihBank;
	$query = "INSERT INTO tbl_reservasi VALUES (null, '$id_tamu',null,'$newDateCheckIn','$newDateCheckOut','$jumlahHari','$tipeKamarYangdiPilih','$jumlahPerKamarYangdiPilih','$jumlah_kamar','$dewasa','$anak','$jamSekarang')";
	if (mysqli_query($conn, $query)) :
    $last_id = mysqli_insert_id($conn);
    $queryInpTrans = "INSERT INTO tbl_transaksi_pembayaran VALUES (null, '$id_tamu',null,'$last_id','$tipeKamarYangdiPilih','$jumlahPerKamarYangdiPilih','$total_harga','$jamSekarang',null,null,'$ketRes_Tamu')";
    $_SESSION["lastID_Reservasi"] = $last_id;
  	if (mysqli_query($conn, $queryInpTrans)) :
  		$last_idTrans = mysqli_insert_id($conn);
  		foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar - '$TotKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
			$_SESSION["lastID_Transaksi"] = $last_idTrans;
  	endif;
	endif;
	return mysqli_affected_rows($conn);
};

// ========================================================================== //
// ========================= TAMU UPDATE RESERVASI ========================== //
// ========================================================================== //

function UpdateReservasiSementara($data) {
	global $conn;
	date_default_timezone_set('Asia/Singapore');
	$jamSekarang = date('Y-m-d H:i:s a', time());
	$ketRes_Tamu = $data["ketRes_Tamu"];
	$updateCheckin = $_SESSION["pilihanKamar"]["tglCheckin"];
	$updateCheckout = $_SESSION["pilihanKamar"]["tglCheckout"];
	$updatejmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
	$updateJmlKamar = $_SESSION["pilihanKamar"]["jumlah_kamar"];
	$updateJmlDewasa = $_SESSION["pilihanKamar"]["adt"];
	$updateJmlAnak = $_SESSION["pilihanKamar"]["cld"];
	$total_harga = hilangkanTitik($_SESSION["pilihanKamar"]["total_harga"]);
	$lastRes = $_SESSION["lastID_Reservasi"];
  $lastTrans = $_SESSION["lastID_Transaksi"];
	$id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
	$tipeKamarYangdiPilih = implode(", ", $_SESSION["pilihanKamar"]["tipeKamarTerpilih"]);
	$TotKamarPerPilihan = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
	$jumlahPerKamarYangdiPilih = implode(", ", $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"]);

	$newDateCheckIn = date_format(new Datetime($updateCheckin), "Y-m-d");
	$newDateCheckOut = date_format(new Datetime($updateCheckout), "Y-m-d");

	$query = "UPDATE tbl_reservasi SET tgl_checkin = '$newDateCheckIn', tgl_checkout = '$newDateCheckOut', jumlah_hari = '$updatejmlHari', tipe_kamar = '$tipeKamarYangdiPilih', jumlah_kamar_perPilihan = '$jumlahPerKamarYangdiPilih', jumlah_kamar = '$updateJmlKamar', jumlah_orang = '$updateJmlDewasa', jumlah_anak = '$updateJmlAnak', jam_reservasi = '$jamSekarang' WHERE id_reservasi = '$lastRes'";
	if (mysqli_query($conn, $query)) :
		$queryUpdtTrans = "UPDATE tbl_transaksi_pembayaran SET tipe_kamar = '$tipeKamarYangdiPilih', jumlah_kamar_perPilihan = '$jumlahPerKamarYangdiPilih', total_pembayaran_kamar = '$total_harga', jam_transaksi = '$jamSekarang', ket_transaksi = '$ketRes_Tamu' WHERE id_transaksi = '$lastTrans'";
  	if (mysqli_query($conn, $queryUpdtTrans)) :
  		foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar - '$TotKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
  	endif;
	endif;
	return mysqli_affected_rows($conn);
}

// ========================================================================== //
// ================== KEMBALIKAN JUMLAH KAMAR - SESSION ===================== //
// ========================================================================== //
function setGakValid() {
	global $conn;
	$lastRes = $_SESSION["lastID_Reservasi"];
  $lastTrans = $_SESSION["lastID_Transaksi"];
	$id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
	$TotKamarPerPilihan = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
	$queryubahres = "UPDATE tbl_reservasi SET jumlah_kamar = '0', tipe_kamar = '-', jumlah_kamar_perPilihan = '0' WHERE id_reservasi = '$lastRes'";
	if (mysqli_query($conn, $queryubahres)) :
		$queryubahtrans = "UPDATE tbl_transaksi_pembayaran SET tipe_kamar = '-', jumlah_kamar_perPilihan = '0', total_pembayaran_kamar = '0', status = 'GAK VALID' WHERE id_transaksi = '$lastTrans'";
		if (mysqli_query($conn, $queryubahtrans)) :
			foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar + '$TotKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
		endif;
	endif;
	return mysqli_affected_rows($conn);
}

// ========================================================================== //
// ======================== KEMBALIKAN JUMLAH KAMAR ========================= //
// ========================================================================== //
function KembalikanJumlahKamar() {
	global $conn;
	$lastRes = $_SESSION["lastID_Reservasi"];
  $lastTrans = $_SESSION["lastID_Transaksi"];
	$id_kamar = $_SESSION["pilihanKamar"]["tipeKamarTerpilih"];
	$TotKamarPerPilihan = $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"];
	$queryubahres = "UPDATE tbl_reservasi SET jumlah_kamar = '0', tipe_kamar = '-', jumlah_kamar_perPilihan = '0' WHERE id_reservasi = '$lastRes'";
	if (mysqli_query($conn, $queryubahres)) :
		$queryubahtrans = "UPDATE tbl_transaksi_pembayaran SET tipe_kamar = '-', jumlah_kamar_perPilihan = '0', total_pembayaran_kamar = '0' WHERE id_transaksi = '$lastTrans'";
		if (mysqli_query($conn, $queryubahtrans)) :
			foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar + '$TotKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
		endif;
	endif;
	return mysqli_affected_rows($conn);
}

// ========================================================================== //
// ========================= PROSES UPLOAD BUKTI ============================ //
// ========================================================================== //
function TahapAkhirReservasi() {
	global $conn;
	$lastTrans = $_SESSION["lastID_Transaksi"];
	$inpBuktiTransaksi = UploadFotoTransaksi();
	if (!$inpBuktiTransaksi) {
		return false;
	}
	$query = "UPDATE tbl_transaksi_pembayaran SET foto_bukti_transaksi = '$inpBuktiTransaksi' WHERE id_transaksi = '$lastTrans'";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);	
}

function UploadFotoTransaksi(){
	$namaFile = $_FILES['inp_bukti_pembayaran']['name'];
	$ukuranFile = $_FILES['inp_bukti_pembayaran']['size'];
	$error = $_FILES['inp_bukti_pembayaran']['error'];
	$tmpName = $_FILES['inp_bukti_pembayaran']['tmp_name'];
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
	move_uploaded_file($tmpName, '../assets/foto_transaksi/' . $namaFileBaru);
	return $namaFileBaru;
}

////////////////////////////////// ////////////////////////////////// 
//                               STAF                              //
////////////////////////////////// //////////////////////////////////

// ========================================================================== //
// ========================== Tambah RESERVASI ============================== //
// ========================================================================== //
function ReservasiTambah($data) {
	global $conn;
	date_default_timezone_set('Asia/Singapore');
	$id_tamu = $data["id_tamu"];
	$total_harga = hilangkanTitik($data["total_harga"]);
	$checkIn = $data["inp_CekIn"];
	$checkOut = $data["inp_CekOut"];
	$dewasa = $data["inp_orgDewasa"];
	$anak = $data["inp_Anak"];
	$jumlah_kamar = $data["jumlah_kamar"];
	$jumlahHari = $data["total_tanggal"];
	$jamSekarang = date('Y-m-d H:i:s a', time());
	$ketRes_Tamu = $data["ketRes_Tamu"];
	$id_kamar = $data["id_kamar"];
	$inputIDKamar = implode(", ", $id_kamar);
	$TotKamarPerPilihan = $data["jumlahKamarPerPilihan"];
	$jumlahKamarPerPilihan = implode(", ", $TotKamarPerPilihan);
	$newDateCheckIn = date_format(new Datetime($checkIn), "Y-m-d");
	$newDateCheckOut = date_format(new Datetime($checkOut), "Y-m-d");
	$query = "INSERT INTO tbl_reservasi VALUES (null, '$id_tamu',null,'$newDateCheckIn','$newDateCheckOut','$jumlahHari','$inputIDKamar','$jumlahKamarPerPilihan','$jumlah_kamar','$dewasa','$anak','$jamSekarang')";
	if (mysqli_query($conn, $query)) :
    $last_id = mysqli_insert_id($conn);
    $queryInpTrans = "INSERT INTO tbl_transaksi_pembayaran VALUES (null, '$id_tamu',null,'$last_id','$inputIDKamar','$jumlahKamarPerPilihan','$total_harga','$jamSekarang',null,'-.png','$ketRes_Tamu')";
  	if (mysqli_query($conn, $queryInpTrans)) :
  		$last_idTrans = mysqli_insert_id($conn);
  		foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar - '$TotKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
  	endif;
	endif;
	return mysqli_affected_rows($conn);
}

// ========================================================================== //
// ======================= BUTTON UBAH RESERVASI ============================ //
// ========================================================================== //

function UbahReservasi($data) {
	global $conn;
	$id_reservasi = $data['id_reservasi'];
	$getId_kamar = $data['id_kamar'];
	$getJumlahKamarPerPilihan = $data['jumlahKamarTerpilih'];

	$id_kamar = explode(", ", $getId_kamar);
	$jumlahKamarPerPilihan = explode(", ", $getJumlahKamarPerPilihan);

	$queryubahres = "UPDATE tbl_reservasi SET jumlah_kamar = '0', tipe_kamar = '-', jumlah_kamar_perPilihan = '0' WHERE id_reservasi = '$id_reservasi'";
	if (mysqli_query($conn, $queryubahres)) :
		$queryubahtrans = "UPDATE tbl_transaksi_pembayaran SET tipe_kamar = '-', jumlah_kamar_perPilihan = '0', total_pembayaran_kamar = '0' WHERE id_transaksi = '$id_reservasi'";
		if (mysqli_query($conn, $queryubahtrans)) :
			foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar + '$jumlahKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
		endif;
	endif;
	return mysqli_affected_rows($conn);
}

// ========================================================================== //
// ========================== UBAH RESERVASI ================================ //
// ========================================================================== //
function ReservasiUbah($data) {
	global $conn;
	date_default_timezone_set('Asia/Singapore');
	$id_reservasi = $data['id_reservasi'];
	$id_tamu = $data["id_tamu"];
	$total_harga = hilangkanTitik($data["total_hargaa"]);
	$checkIn = $data["inp_CekIn"];
	$checkOut = $data["inp_CekOut"];
	$dewasa = $data["inp_orgDewasa"];
	$anak = $data["inp_Anak"];
	$jumlah_kamar = $data["jumlah_kamar"];
	$jumlahHari = $data["total_tanggal"];
	$jamSekarang = date('Y-m-d H:i:s a', time());
	$id_kamar = $data["id_kamar"];
	$inputIDKamar = implode(", ", $id_kamar);
	$TotKamarPerPilihan = $data["jumlahKamarPerPilihan"];
	$jumlahKamarPerPilihan = implode(", ", $TotKamarPerPilihan);
	$newDateCheckIn = date_format(new Datetime($checkIn), "Y-m-d");
	$newDateCheckOut = date_format(new Datetime($checkOut), "Y-m-d");

	$query = "UPDATE tbl_reservasi SET tgl_checkin = '$newDateCheckIn', tgl_checkout = '$newDateCheckOut', jumlah_hari = '$jumlahHari', tipe_kamar = '$inputIDKamar', jumlah_kamar_perPilihan = '$jumlahKamarPerPilihan', jumlah_kamar = '$jumlah_kamar', jumlah_orang = '$dewasa', jumlah_anak = '$anak', jam_reservasi = '$jamSekarang' WHERE id_reservasi = '$id_reservasi'";
	if (mysqli_query($conn, $query)) :
		$queryUpdtTrans = "UPDATE tbl_transaksi_pembayaran SET tipe_kamar = '$inputIDKamar', jumlah_kamar_perPilihan = '$jumlahKamarPerPilihan', total_pembayaran_kamar = '$total_harga', jam_transaksi = '$jamSekarang' WHERE id_transaksi = '$id_reservasi'";
  	if (mysqli_query($conn, $queryUpdtTrans)) :
  		foreach ($id_kamar as $key => $val) :
				$queryUbahJMLKamar = "UPDATE tbl_tipe_kamar SET jumlah_kamar = jumlah_kamar - '$TotKamarPerPilihan[$key]' WHERE id_tipe_kamar = '".$val."'";
				mysqli_query($conn, $queryUbahJMLKamar);
			endforeach;
  	endif;
	endif;
	return mysqli_affected_rows($conn);
}

function VerifikasiValid($data) {
	global $conn;
	$id_reservasi = $data["id_reservasi"];
	$id_transaksi = $data["id_transaksi"];
	$id_pengguna = $data["id_staf"];

	$query = "UPDATE tbl_transaksi_pembayaran SET
						id_pengguna = '$id_pengguna',
						status = 'VALID'
						WHERE id_transaksi = '".$id_transaksi."'";
	if(mysqli_query($conn, $query)):
		$query2 = "UPDATE tbl_reservasi SET
						id_pengguna = '$id_pengguna'
						WHERE id_reservasi = '".$id_reservasi."'";
		mysqli_query($conn, $query2);
	endif;
	return mysqli_affected_rows($conn);
}

function VerifikasiTidakValid($data) {
	global $conn;
	$id_reservasi = $data["id_reservasi"];
	$id_transaksi = $data["id_transaksi"];
	$id_pengguna = $data["id_staf"];

	$query = "UPDATE tbl_transaksi_pembayaran SET
						status = 'GAK VALID'
						WHERE id_transaksi = '".$id_transaksi."'";
	if(mysqli_query($conn, $query)):
		$query2 = "UPDATE tbl_reservasi SET
						id_pengguna = '$id_pengguna'
						WHERE id_reservasi = '".$id_reservasi."'";
		mysqli_query($conn, $query2);
	endif;
	return mysqli_affected_rows($conn);
}

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

	$query = "INSERT INTO tbl_tamu VALUES (null, '$nama_tamu', '$tgl_lahir_tamu', '$email_tamu', '$password_terbaru', '$hp_tamu', '$almt_tamu', '$jk_tamu', '',null)";
		
	mysqli_query($conn, $query);
	$aa = mysqli_insert_id($conn);
	$_SESSION["getIDTAMU"] = $aa;

	return mysqli_affected_rows($conn);	
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

////////////////////////////////// ////////////////////////////////// 
//                           TAMBAHAN                              //
////////////////////////////////// //////////////////////////////////

function transaksiValid($bulan,$tahun){
 	global $conn;
 	$sql = mysqli_query($conn, "
			SELECT * FROM tbl_transaksi_pembayaran WHERE MONTH(jam_transaksi) = '".$bulan."' and YEAR(jam_transaksi) = '".$tahun."' and status = 'VALID'
 	");
	$hasil = mysqli_num_rows($sql);

	if ($hasil == '') {
		$hasil = 0;
	}
	return $hasil;		
}
	
function grafikValid($tahun){
 	$bulan1 = transaksiValid(1,$tahun);
 	$bulan2 = transaksiValid(2,$tahun);
 	$bulan3 = transaksiValid(3,$tahun);
 	$bulan4 = transaksiValid(4,$tahun);
 	$bulan5 = transaksiValid(5,$tahun);
 	$bulan6 = transaksiValid(6,$tahun);
 	$bulan7 = transaksiValid(7,$tahun);
 	$bulan8 = transaksiValid(8,$tahun);
 	$bulan9 = transaksiValid(9,$tahun);
 	$bulan10 = transaksiValid(10,$tahun);
 	$bulan11 = transaksiValid(11,$tahun);
 	$bulan12 = transaksiValid(12,$tahun);

 	$data = 
 	[
 		$bulan1,
 		$bulan2,
 		$bulan3,
 		$bulan4,
 		$bulan5,
 		$bulan6,
 		$bulan7,
 		$bulan8,
 		$bulan9,
 		$bulan10,
 		$bulan11,
 		$bulan12
 	];
 	return $data;
}

function transaksiGakValid($bulan,$tahun){
 	global $conn;
 	$sql = mysqli_query($conn, "
			SELECT * FROM tbl_transaksi_pembayaran WHERE MONTH(jam_transaksi) = '".$bulan."' and YEAR(jam_transaksi) = '".$tahun."' and status = 'GAK VALID'
 	");
	$hasil = mysqli_num_rows($sql);

	if ($hasil == '') {
		$hasil = 0;
	}
	return $hasil;		
}

function grafikGakValid($tahun){
 	$bulan1 = transaksiGakValid(1,$tahun);
 	$bulan2 = transaksiGakValid(2,$tahun);
 	$bulan3 = transaksiGakValid(3,$tahun);
 	$bulan4 = transaksiGakValid(4,$tahun);
 	$bulan5 = transaksiGakValid(5,$tahun);
 	$bulan6 = transaksiGakValid(6,$tahun);
 	$bulan7 = transaksiGakValid(7,$tahun);
 	$bulan8 = transaksiGakValid(8,$tahun);
 	$bulan9 = transaksiGakValid(9,$tahun);
 	$bulan10 = transaksiGakValid(10,$tahun);
 	$bulan11 = transaksiGakValid(11,$tahun);
 	$bulan12 = transaksiGakValid(12,$tahun);

 	$data = 
 	[
 		$bulan1,
 		$bulan2,
 		$bulan3,
 		$bulan4,
 		$bulan5,
 		$bulan6,
 		$bulan7,
 		$bulan8,
 		$bulan9,
 		$bulan10,
 		$bulan11,
 		$bulan12
 	];
 	return $data;
}
// GRAFIK RESERVAI
function DataReservasi($bulan,$tahun) {
	global $conn;
	$sql = mysqli_query($conn, "SELECT * FROM tbl_reservasi WHERE MONTH(jam_reservasi) = '".$bulan."' and YEAR(jam_reservasi) = '".$tahun."'
	");

	$hasil = mysqli_num_rows($sql);

	if ($hasil == '') {
		$hasil = 0;
	}
	return $hasil;	
}
function grafikReservasi($tahun){
 	$bulan1 = DataReservasi(1,$tahun);
 	$bulan2 = DataReservasi(2,$tahun);
 	$bulan3 = DataReservasi(3,$tahun);
 	$bulan4 = DataReservasi(4,$tahun);
 	$bulan5 = DataReservasi(5,$tahun);
 	$bulan6 = DataReservasi(6,$tahun);
 	$bulan7 = DataReservasi(7,$tahun);
 	$bulan8 = DataReservasi(8,$tahun);
 	$bulan9 = DataReservasi(9,$tahun);
 	$bulan10 = DataReservasi(10,$tahun);
 	$bulan11 = DataReservasi(11,$tahun);
 	$bulan12 = DataReservasi(12,$tahun);

 	$data = 
 	[
 		$bulan1,
 		$bulan2,
 		$bulan3,
 		$bulan4,
 		$bulan5,
 		$bulan6,
 		$bulan7,
 		$bulan8,
 		$bulan9,
 		$bulan10,
 		$bulan11,
 		$bulan12
 	];
 	return $data;
}

function time_elapsed_string($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);
  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;
  $string = array(
    'y' => 'Tahun',
    'm' => 'Bulan',
    'w' => 'Minggu',
    'd' => 'Hari',
    'h' => 'jam',
    'i' => 'menit',
    's' => 'detik',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v; //. ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }
  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' lalu' : 'Baru saja';
}
?>