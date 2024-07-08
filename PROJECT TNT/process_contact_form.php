<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['desc'];

    // Email addresses to send the message to
    $to_emails = array(
        'TNT@courier.my'
    );

    // Subject and message body
    $subject = 'Contact Form Submission';
    $body = "Name: $name\n\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    // Headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send emails to each recipient
    foreach ($to_emails as $to_email) {
        mail($to_email, $subject, $body, $headers);
    }

    // Redirect back to the form page after sending emails
    header('Location: contactUs.php?message=sent');
    exit();
} else {
    // Redirect to the form page if accessed directly
    header('Location: contactUs.php');
    exit();
}

