<?php
	session_start();
	// if (isset($_REQUEST['getValue'])) {
	$getData = $_POST['getValueTam'];
	switch ($getData) {
    case 'day':
      $_SESSION['currentDate_Tamu'] = "date_create >= DATE_SUB(NOW(),INTERVAL 24 HOUR)";
    break;
    case 'week':
      $_SESSION['currentDate_Tamu'] = "date_create >= DATE_SUB(NOW(),INTERVAL 168 HOUR)";
    break;
    case 'month':
      $_SESSION['currentDate_Tamu'] = "date_create >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY)";
    break;
    case 'year':
      $_SESSION['currentDate_Tamu'] = "YEAR(date_create) = YEAR(CURRENT_DATE())";
    break;
    default:
  	$_SESSION['currentDate_Tamu'] = "YEAR(date_create) = YEAR(CURRENT_DATE())";
	}
	// }
?>