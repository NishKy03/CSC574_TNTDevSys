<?php
include '../dbConnect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderID = $_POST['orderID'];
    
    // SQL to fetch order details based on orderID
    $sql = "
        SELECT o.orderID, tu.date, o.status, s.senderName 
        FROM tracking_update tu
        JOIN orders o ON tu.orderID = o.orderID
        JOIN sender s ON o.senderID = s.senderID
        WHERE o.orderID=?";

    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("s", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data
        $row = $result->fetch_assoc();
        $orderID = $row['orderID'];
        $date = $row['date'];
        $status = $row['status'];
        $senderName = $row['senderName'];

        // Redirect to tracking.php with orderID as a parameter
        header("Location: tracking.php?orderID=$orderID");
        exit();
    } else {
        echo "<script>alert('No Records " . $stmt->error . "'); window.location='tracking.php';</script>";
    }

    $stmt->close();
}

$dbCon->close();
?>
