<?php 
session_start();
$_SESSION["loggedin"] = '';
$_SESSION["pilihanKamar"] = '';
$_SESSION["privasi"] = '';
$_SESSION["bank"]["pilih"] = '';
session_unset($_SESSION["loggedin"], $_SESSION["pilihanKamar"], $_SESSION["privasi"], $_SESSION["bank"]["pilih"]);
session_destroy($_SESSION["loggedin"], $_SESSION["pilihanKamar"], $_SESSION["privasi"], $_SESSION["bank"]["pilih"]);

// setcookie('id', '', time() - 3600);
// setcookie('key', '', time() - 3600);

header("Location: ../index.php");
exit;
?>