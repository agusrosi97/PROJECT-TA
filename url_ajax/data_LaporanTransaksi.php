<?php 
	session_start();
	$_SESSION['perioAwalTrans'] = $_POST['awal_trans'];
	$_SESSION['perioAkhirTrans'] = $_POST['akhir_trans'];
?>