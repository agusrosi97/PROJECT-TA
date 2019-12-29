<!----SESSION USERNAME---->
<?php
    // Initialize the session
    session_start();
    date_default_timezone_set('Asia/Singapore');
   
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['loggedin_pengguna'])){
        header("location: ../login/login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Print Result</title>
	<!--Icon-->
	<link rel="icon" type="image/png" href="../assets/images/logo-w.png">
	<!--Bootstrap For Layout-->
  <link rel="stylesheet" href="../assets-2/bootstrap_4.3.1/css/bootstrap.css">

    <style type="text/css">
    	.wrapper{
    		width: 98%;
        margin: 0 auto;
        border-radius: 2px;
        box-shadow: 0 4px 10px 1px rgba(0,0,0,0.35);
        margin-top:20px;
        margin-bottom: 20px;
        background-color: #ffff;
        opacity: 1;
    	}
    	.page-header{
    		padding-bottom: 20px;
    	}
    	h2{
    		margin-top: 0;
    	}
    	table thead tr th.almt{
    		width: 210px;
    	}
    	table thead tr th.tgl{
    		width: 300px;
    	}
    	table thead tr th.nma{
    		width: 150px;
    	}
    	table thead tr th.no-id{
    		width: 50px;
    	}
    </style>
</head>
<body>
	<div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header clearfix">
						<h2 class="text-center pt-3">Laporan Reservasi</h2>
					</div>

					<?php
					require_once '../koneksi/function_global.php';
					$sql = "SELECT tbl_reservasi.*, tbl_tamu.*, tbl_pengguna.*, tbl_transaksi_pembayaran.*
                  FROM tbl_reservasi
                  LEFT JOIN tbl_pengguna ON tbl_reservasi.id_pengguna = tbl_pengguna.id_pengguna
                  LEFT JOIN tbl_tamu ON tbl_reservasi.id_tamu = tbl_tamu.id_tamu
                  LEFT JOIN tbl_transaksi_pembayaran ON tbl_reservasi.id_reservasi = tbl_transaksi_pembayaran.id_reservasi WHERE nama_tamu = 'Agus Rosi Adi Purwibawa'
                  ";
					if ($result = mysqli_query($conn, $sql)) {
						if (mysqli_num_rows($result) > 0) {
							echo "<table class='table table-bordered table-striped'>";
								echo "<thead>";
									echo "<tr>";
										echo "<th class='no-id text-center'>No</th>";
										echo "<th class='tgl text-center'>Nama</th>";
										echo "<th class='jk text-center'>Total bayar</th>";
										echo "<th class='jk text-center'>Nama Staf</th>";
										echo "<th class='text-center'>Checkin</th>";
										echo "<th class='text-center'>Checkout</th>";
										echo "<th class='text-center'>J Hari</th>";
										echo "<th class='jk text-center'>J Dewasa</th>";
										echo "<th class='jk text-center'>J Anak</th>";
										echo "<th class='jk text-center'>Tgl Reservasi</th>";
									echo "</tr>";
								echo "</thead>";
								echo "<tbody>";
									$no=1;
									while($row = mysqli_fetch_array($result)){
										echo "<tr>";
											echo "<th class='text-center'>$no</th>";
                      echo "<td>" . $row['nama_tamu'] . "</td>";
                      echo "<td class='text-center'>" . $row["total_pembayaran_kamar"] . "</td>";
                      echo "<td class='text-center'>" . $row["username_pengguna"] . "</td>";
                      echo "<td class='text-center'>" . $row['tgl_checkin'] . "</td>";
                      echo "<td class='text-center'>" . $row['tgl_checkout'] . "</td>";
                      echo "<td>" . $row['jumlah_hari'] . "</td>";
                      echo "<td>" . $row['jumlah_orang'] . "</td>";
                      echo "<td>" . $row['jumlah_anak'] . "</td>";
                      echo "<td>" . $row['jam_reservasi'] . "</td>";
										echo "</tr>";
									$no++;
									}
								echo "</tbody>";
							echo "</table>";
							mysqli_free_result($result);
						} else {
							echo "<p class='lead text-center'><em>No Record Were Found !</em></p>";
						}
					} else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
					?>
				</div>
				<div class="col d-flex justify-content-end">
					<div class="p-5">
						<p class="text-center">Widuri Villa<br></p>
						<br>
						<br>
						<?php
						
							echo date('l, j F Y');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>