<?php 
session_start();
$_SESSION["loggedin"] = '';
$_SESSION["pilihanKamar"] = '';
$_SESSION["privasi"] = '';
$_SESSION["bank"]["pilih"] = '';
$_SESSION["lastID_Reservasi"] = '';
$_SESSION["lastID_Transaksi"] = '';
$_SESSION["confirmPesanan"] = '';
$_SESSION['timeout'] = '';
session_unset($_SESSION['timeout'], $_SESSION["loggedin"], $_SESSION["confirmPesanan"], $_SESSION["pilihanKamar"], $_SESSION["privasi"], $_SESSION["bank"]["pilih"], $_SESSION["lastID_Reservasi"], $_SESSION["lastID_Transaksi"]);
session_destroy($_SESSION['timeout'], $_SESSION["loggedin"], $_SESSION["confirmPesanan"], $_SESSION["pilihanKamar"], $_SESSION["privasi"], $_SESSION["bank"]["pilih"], $_SESSION["lastID_Reservasi"], $_SESSION["lastID_Transaksi"]);
header("Location: ../index");
exit;
?>