<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$constants = parse_ini_file("/var/www/html/mailer.ini");
//require_once('email_config.php');
require('PHPMailerAutoload.php');
$mail = new PHPMailer();
$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication


$mail->Username = $constants['username'];                  // SMTP username
$mail->Password = $constants['password'];                 // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->smtpConnect($options);
$mail->From = 'noreply@markjurkiewicz.com';
$mail->FromName = 'noreply';
$mail->addAddress('markajurkiewicz@gmail.com', 'Mark');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo($_POST['email'], $_POST['name']);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Someone has contacted you from your website.';
$stuff = '';
foreach($_POST as $key=>$value){
    $stuff .= "<h3>$key : $value</h3>";
}
$mail->Body = $stuff;
$mail->AltBody = strip_tags($_POST['message']);

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>

// Check for empty fields
//if(empty($_POST['name'])  		||
//   empty($_POST['email']) 		||
//   empty($_POST['phone']) 		||
//   empty($_POST['message'])	||
//   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
//   {
//	echo "No arguments Provided!";
//	return false;
//   }
//
//$name = $_POST['name'];
//$email_address = $_POST['email'];
//$phone = $_POST['phone'];
//$message = $_POST['message'];
//
//// Create the email and send the message
//$to = 'markajurkiewicz@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
//$email_subject = "Website Contact Form:  $name";
//$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
//$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
//$headers .= "Reply-To: $email_address";
//mail($to,$email_subject,$email_body,$headers);
//return true;
