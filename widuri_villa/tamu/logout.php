<?php 
session_start();
$_SESSION["loggedin"] = '';
session_unset($_SESSION["loggedin"]);
session_destroy($_SESSION["loggedin"]);

// setcookie('id', '', time() - 3600);
// setcookie('key', '', time() - 3600);

header("Location: ../index.php");
exit;
?>