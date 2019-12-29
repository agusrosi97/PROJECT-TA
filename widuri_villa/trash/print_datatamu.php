<?php
  session_start();
  if(!isset($_SESSION['loggedin_pengguna'])){
    header("location: ../login/login.php");
    exit;
  }
  date_default_timezone_set('Asia/Singapore');
  setlocale(LC_ALL, 'ID_id');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Print Result</title>
	<link rel="icon" type="image/png" href="../assets/images/logo-w.png">
  <link rel="stylesheet" type="text/css" href="../assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css">

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
	<div class="wrapper rounded">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header clearfix">
						<h2 class="text-center">DATA TAMU</h2>
					</div>

					<?php
					require_once '../koneksi/function_global.php';
					if (!empty($_SESSION['LaporanTamu'])) {
						$sql = "".$_SESSION['LaporanTamu']."";
					}
					else{
						$sql = "SELECT * FROM tbl_tamu WHERE date_sub(now(), interval 5 day) <= `date_create` ORDER BY id_tamu DESC";
					};
					if ($result = mysqli_query($conn, $sql)) {
						if (mysqli_num_rows($result) > 0) {
							echo "<table class='table table-bordered table-striped'>";
								echo "<thead>";
									echo "<tr>";
										echo "<th class='no-id text-center'>No</th>";
										echo "<th class=' no-id text-center'>ID</th>";
										echo "<th class='tgl text-center'>Nama</th>";
										echo "<th class='jk text-center'>Tgl Lahir</th>";
										echo "<th class='text-center'>Email</th>";
										echo "<th class='text-center'>No Tlp</th>";
										echo "<th class='jk text-center'>JK</th>";
										echo "<th class='almt text-center'>Alamat</th>";
									echo "</tr>";
								echo "</thead>";
								echo "<tbody>";
									$no=1;
									while($row = mysqli_fetch_array($result)){
										echo "<tr>";
											echo "<th class='text-center'>$no</th>";
											echo "<td class='text-center'>" . $row['id_tamu'] . "</td>";
                      echo "<td>" . $row['nama_tamu'] . "</td>";
                      echo "<td class='text-center'>" . tgl_indo2($row['tgl_lahir_tamu']) . "</td>";
                      echo "<td class='text-center'>" . $row['email_tamu'] . "</td>";
                      echo "<td>" . $row['no_telp_tamu'] . "</td>";
                      echo "<td>" . $row['jk_tamu'] . "</td>";
                      echo "<td>" . $row['alamat_tamu'] . "</td>";
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
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
					?>
				</div>
				<div class="col d-flex justify-content-end">
					<div class="p-5">
						<p class="text-center"><?= $_SESSION["loggedin_pengguna"]["nama_pengguna"]; ?><br></p>
						<br>
						<br>
						<?php
							echo strftime("%A, %m %B %Y");
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		// window.print();
	</script>
</body>
</html>