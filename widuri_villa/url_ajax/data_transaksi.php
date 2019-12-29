<?php
	session_start();
	// if (isset($_REQUEST['getValue'])) {
	$getData = $_POST['getValueTrans'];
	switch ($getData) {
    case 'day':
      $_SESSION['currentDate_Trans'] = "jam_transaksi >= DATE_SUB(NOW(),INTERVAL 24 HOUR) AND status = 'VALID'";
    break;
    case 'week':
      $_SESSION['currentDate_Trans'] = "jam_transaksi >= DATE_SUB(NOW(),INTERVAL 168 HOUR) AND status = 'VALID'";
    break;
    case 'month':
      $_SESSION['currentDate_Trans'] = "jam_transaksi >= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND status = 'VALID'";
    break;
    case 'year':
      $_SESSION['currentDate_Trans'] = "jam_transaksi >= DATE_SUB(NOW(), INTERVAL 1 YEAR) AND status = 'VALID'";
    break;
    default:
  	$_SESSION['currentDate_Trans'] = "jam_transaksi >= DATE_SUB(NOW(), INTERVAL 1 YEAR) AND status = 'VALID'";
	}
	// }
?>