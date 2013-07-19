<?php
   $firstName = mysqli_real_escape_string($dbc, trim($_POST['firstName']));
   $lastName = mysqli_real_escape_string($dbc, trim($_POST['lastName']));
   $name = mysqli_real_escape_string($dbc, trim($_POST['firstName'])) . ' ' . mysqli_real_escape_string($dbc, trim($_POST['lastName']));
   $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
   $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
   $confirmEmail = mysqli_real_escape_string($dbc, trim($_POST['confirmEmail'])); // only used to make form sticky
   $comments = mysqli_real_escape_string($dbc, trim($_POST['comments']));
   
   $to = 'info@quickrecognition.com';
   $subject = "Quick Recognition contact form";
   $msg = "Client details: <br />" .
   "Name: $name<br />" .
   "Phone: $phone<br />" .
   "Email: $email<br />" .
   "Comments: $comments<br />";
   $headers = 'From: info@quickrecognition.com' . "\r\n";
   $headers .= 'MIME-Version: 1.0' . "\n";
   $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
   mail($to, $subject, $msg, $headers);   
   
   echo "<p>Thank you for contacting us. Our staff will contact you within two business days.<br /><br />";
   echo 'Just to confirm your details: <br />';
   echo 'Name: ' . $name . '<br />';
   echo 'Phone: ' . $phone . '<br />';
   echo 'Email: ' . $email . '<br />';
   echo 'Comments: ' . $comments . "</p>";

?>
