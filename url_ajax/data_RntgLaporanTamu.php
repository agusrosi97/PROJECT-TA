<?php 
session_start();
$_SESSION['tglawalCheckout'] = $_POST['tgl_awal'];
$_SESSION['tglakhirCheckout'] = $_POST['tgl_akhir'];
?>