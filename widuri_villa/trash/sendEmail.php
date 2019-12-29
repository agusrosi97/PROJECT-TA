<?php
// function sendMail()
// {
use PHPMailer\PHPMailer\PHPMailer;
function aa()
{
		//Create a new PHPMailer instance
	require_once 'PHPMailer/PHPMailer/PHPMailer.php';
	require_once 'PHPMailer/PHPMailer/SMTP.php';
	require_once 'PHPMailer/PHPMailer/Exception.php';
	$aa = 1212;
	$cc = "guzrosiadi97@gmail.com";
	$body = "<div><b><h3>From:&nbsp;".$cc."</h3></b><br><b><h3>Pesanan:</h3></b></div>";

	$mail = new PHPMailer();
		//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	$mail->SMTPAuth   = true;
	$mail->Host       = 'smtp.gmail.com';
	$mail->Port       = 465;
	$mail->SMTPSecure = 'ssl';
	$mail->Username   = 'agusrosiadi.p@gmail.com';
	$mail->Password   = 'wvnrglbdmwieyiwk';
	$mail->setFrom($cc,'aa');
	$mail->addAddress('villawiduri@gmail.com');
	$mail->Subject    = "PHPMailer GMail SMTP test ROSIADIPURWIBAWA".$aa."";
	$mail->Body       = $body;
	$mail->AltBody    = 'This is a plain-text message body';
	if (!$mail->send()) {
		echo 'Mailer Error: '. $mail->ErrorInfo;
	} else {
		echo 'Message sent!';
	}
}
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" method="POST">
		<input type="hidden" name="from" value="agusrosiadi.p@gmail.com">
		<textarea name="message"></textarea>
		<button type="submit" name="kirim">KIRIM</button>
	</form>
</body>
</html>
<?php if (isset($_POST['kirim'])) {
	aa();
} ?>