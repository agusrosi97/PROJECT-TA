<?php 
session_start();
if (isset($_POST['tglci'], $_POST['tglco'])) :
	$rsvcn = $_POST['tglci'];
	$rsvct = $_POST['tglco'];
	!empty($rsvcn) ? $_SESSION['tglrsvcn'] = $rsvcn : "";
	!empty($rsvct) ? $_SESSION['tglrsvct'] = $rsvct : "";
	$_SESSION['compar'] = 'A';
elseif (isset($_POST['periode_awal'], $_POST['periode_akhir'])) :
	$priawl = $_POST['periode_awal'];
	$priahr = $_POST['periode_akhir'];
	!empty($priawl) ? $_SESSION['periode_awal'] = $priawl : "";
	!empty($priahr) ? $_SESSION['periode_akhir'] = $priahr : "";
	$_SESSION['compar'] = 'B';
elseif (isset($_POST['default'])) :
	$_SESSION['compar'] = 'C';
endif;
?>