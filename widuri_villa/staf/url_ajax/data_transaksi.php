<?php
	session_start();
	// if (isset($_REQUEST['getValue'])) {
	$getData = $_POST['getValueTrans'];
	switch ($getData) {
    case 'day':
      $_SESSION['currentDate_Trans'] = "DAY(jam_transaksi) = DAY(CURRENT_DATE()) AND status = 'VALID'";
    break;
    case 'month':
      $_SESSION['currentDate_Trans'] = "MONTH(jam_transaksi) = MONTH(CURRENT_DATE()) AND status = 'VALID'";
    break;
    case 'year':
      $_SESSION['currentDate_Trans'] = "YEAR(jam_transaksi) = YEAR(CURRENT_DATE()) AND status = 'VALID'";
    break;
    default:
  	$_SESSION['currentDate_Trans'] = "YEAR(jam_transaksi) = YEAR(CURRENT_DATE()) AND status = 'VALID'";
	}
	// }
?>