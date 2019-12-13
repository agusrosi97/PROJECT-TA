<?php
	session_start();
	// if (isset($_REQUEST['getValue'])) {
	$getData = $_POST['getValueResv'];
	switch ($getData) {
    case 'day':
      $_SESSION['currentDate_Resv'] = "jam_reservasi >= DATE_SUB(NOW(),INTERVAL 24 HOUR)";
    break;
    case 'week':
      $_SESSION['currentDate_Resv'] = "jam_reservasi >= DATE_SUB(NOW(),INTERVAL 168 HOUR)";
    break;
    case 'month':
      $_SESSION['currentDate_Resv'] = "jam_reservasi >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY)";
    break;
    case 'year':
      $_SESSION['currentDate_Resv'] = "YEAR(jam_reservasi) = YEAR(CURRENT_DATE())";
    break;
    default:
  	$_SESSION['currentDate_Resv'] = "YEAR(jam_reservasi) = YEAR(CURRENT_DATE())";
	}
	// }
?>