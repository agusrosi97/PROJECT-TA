<?php 
session_start();
$_SESSION['tgl_awalTrans'] = $_POST['tgl_awal'];
$_SESSION['tgl_akhirTrans'] = $_POST['tgl_akhir'];
?>