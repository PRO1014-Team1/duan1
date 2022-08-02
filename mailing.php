<?php




require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

//Create an instance; passing true enable exceptions
$mail = new PHPMailer(true);

function sendMail($mail, $to, $subject, $body)
{
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = ''; // SMTP username
    $mail->Password = ''; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to
    $mail->setFrom('', 'Nitwitty'); // Add a recipient
    $mail->addAddress($to); // Name is optional
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->send();
}

function generate_confirmation()
{
    $confirmation = md5(uniqid());
    return $confirmation;
}

//send a confirmation email to the user
function send_confirmation_email($email, $confirmation)
{
    $subject = 'Confirm your email';
    $body = '<p>Please confirm your email by clicking <a href="http://localhost/nitwitty/confirm.php?confirmation=' . $confirmation . '">here</a>.</p>';
    sendMail($mail, $email, $subject, $body);
}

// check if email exist in database
function check_mail($email)
{
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = pdo_query($sql);
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}
