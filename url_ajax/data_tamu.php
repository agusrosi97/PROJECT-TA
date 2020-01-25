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
      $_SESSION['currentDate_Tamu'] = "date_create >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    break;
    case 'year':
      $_SESSION['currentDate_Tamu'] = "date_create >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
    break;
    default:
  	$_SESSION['currentDate_Tamu'] = "date_create >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
	}
	// }
?>