<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Replace this with your own email address
$siteOwnersEmail = 'rao_dhruv@outlook.com';

if ($_POST) {

    // Initialize variables
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    $error = [];

    // Validate Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Validate Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Set subject if empty
    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }

    // If no errors, send the email
    if (empty($error)) {
        // Set Message
        $message = '';
        $message .= "Email from: " . $name . "<br />";
        $message .= "Email address: " . $email . "<br />";
        $message .= "Message: <br />";
        $message .= $contact_message;
        $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

        // Set From: header
        $from =  $name . " <" . $email . ">";

        // Email Headers
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Send email
        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }

    } else {
        $response = '';
        if (isset($error['name'])) $response .= $error['name'] . "<br /> \n";
        if (isset($error['email'])) $response .= $error['email'] . "<br /> \n";
        if (isset($error['message'])) $response .= $error['message'] . "<br />";
        
        echo $response;
    }

}
?>