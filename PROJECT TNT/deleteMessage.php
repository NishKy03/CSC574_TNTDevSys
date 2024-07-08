<?php
include 'dbConnect.php';

if (isset($_GET['id'])) {
    $messageId = intval($_GET['id']);
    $sql = "DELETE FROM contactus WHERE messageid = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("i", $messageId);
    if ($stmt->execute()) {
        echo "Message deleted successfully.";
    } else {
        echo "Error deleting message: " . $dbCon->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}

$dbCon->close();

// Redirect back to the messages page
header("Location: message.php");
exit();
?>
