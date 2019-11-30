<?php
	session_start();
	// if (isset($_REQUEST['getValue'])) {
	$getData = $_POST['getValueResv'];
	switch ($getData) {
    case 'day':
      $_SESSION['currentDate_Resv'] = "DAY(jam_reservasi) = DAY(CURRENT_DATE())";
    break;
    case 'month':
      $_SESSION['currentDate_Resv'] = "MONTH(jam_reservasi) = MONTH(CURRENT_DATE())";
    break;
    case 'year':
      $_SESSION['currentDate_Resv'] = "YEAR(jam_reservasi) = YEAR(CURRENT_DATE())";
    break;
    default:
  	$_SESSION['currentDate_Resv'] = "YEAR(jam_reservasi) = YEAR(CURRENT_DATE())";
	}
	// }
?>