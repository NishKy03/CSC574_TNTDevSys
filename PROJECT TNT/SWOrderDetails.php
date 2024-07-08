<?php
if (isset($_GET["orderID"]) && !empty(trim($_GET["orderID"]))) {
    // Include dbConnect file
    require_once "dbConnect.php";
    
    // Prepare a select statement
    $sql = "SELECT o.orderID, r.name AS rName, r.phoneNo AS rPhoneNo, r.addressLine1 AS rAddress, r.postcode AS rPostcode, r.city AS rCity, r.state AS rState, s.senderName, s.senderPhoneNo, s.addressLine1 AS sAddress, s.postcode As sPostcode, s.city AS sCity, s.state AS sState, o.orderDate, o.parcelWeight, o.totalAmount, o.insurance
            FROM orders o, recipient r, sender s
            WHERE o.senderID = s.senderID
            AND o.recipientID = r.recipientID
            AND o.orderID = ?";
    
    if ($stmt = mysqli_prepare($dbCon, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "d", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["orderID"]);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $orderID = $row['orderID'];
                $rName = $row['rName'];
                $rPhoneNo = $row['rPhoneNo'];
                $rAddress = $row['rAddress'];
                $rPostcode = $row['rPostcode'];
                $rCity = $row['rCity'];
                $rState = $row['rState'];
                $sName = $row['senderName'];
                $sPhoneNo = $row['senderPhoneNo'];
                $sAddress = $row['sAddress'];
                $sPostcode = $row['sPostcode'];
                $sCity = $row['sCity'];
                $sState = $row['sState'];
                $orderDate = $row['orderDate'];
                $weight = $row['parcelWeight'];
                $amount = $row['totalAmount'];
                $insurance = $row['insurance'];
            } else {
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_free_result($result);
    mysqli_close($dbCon);
} else {
    exit();
}