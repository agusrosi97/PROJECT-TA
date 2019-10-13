<?php 
session_start();
$_SESSION["loggedin_pengguna"] = '';
session_unset($_SESSION["loggedin_pengguna"]);
session_destroy($_SESSION["loggedin_pengguna"]);

// setcookie('id', '', time() - 3600);
// setcookie('key', '', time() - 3600);

header("Location: ../login/login.php");
exit;
?>