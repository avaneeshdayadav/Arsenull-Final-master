<?php
$to = 'avaneeshdyadav@gmail.com';
$subject = 'SBI account hacked.';
$from = 'avaneeshdyadav@gmail.com';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '<html><body>';
$message .= '<h4>This is regarding your SBI Account</h4>';
$message .= '<p>Your SBI acccount PIN number and account number has been hacked and 5000 Rs has been deducted from your account. More 5000 Rs will be deduced from your account in next few hours if you do not call on the number 9854171765. Further details will be provided on the phone call.</p>';
$message .= '</body></html>';
 
// Sending email

// last parameter, the headers, are optional for the function but required for sending HTML email, as this is where we are able to pass along the Content-Type declaration telling email clients to parse the email as HTML.

if(mail($to, $subject, $message, $headers))
{
    echo 'Your mail has been sent successfully.';
}
else
{
    echo 'Unable to send email. Please try again.';
}
?>