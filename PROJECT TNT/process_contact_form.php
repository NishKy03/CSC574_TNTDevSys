<?php
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $description = $_POST['desc'];

    // Prepare and bind
    $stmt = $dbCon->prepare("INSERT INTO contactus (name, email, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $description);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the form page after successful insertion
        header('Location: contactUs.php?message=sent');
    } else {
        // Redirect back to the form page with error message
        header('Location: contactUs.php?message=error');
    }

    // Close the statement
    $stmt->close();
    // Close the connection
    $dbCon->close();
} else {
    // Redirect to the form page if accessed directly
    header('Location: contactUs.php');
    exit();
}
