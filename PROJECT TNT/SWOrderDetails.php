<?php
    require_once "dbConnect.php";
    $sql = "SELECT o.orderID, r.name AS rName, r.phoneNo AS rPhoneNo, r.addressLine1 AS rAddress, r.postcode AS rPostcode, r.city AS rCity, r.state AS rState, s.senderName, s.senderPhoneNo, s.addressLine1 AS sAddress, s.postcode As sPostcode, s.city AS sCity, s.state AS sState, o.orderDate, o.parcelWeight, o.totalAmount, o.insurance
            FROM orders o, recipient r, sender s
            WHERE o.senderID = s.senderID
            AND o.recipientID = r.recipientID
            ORDER BY o.orderID DESC LIMIT 1";
    
    if ($result = mysqli_query($dbCon, $sql)) {
        if (mysqli_num_rows($result) == 1) {
            /* Fetch result row as an associative array. Since the result set
            contains only one row, we don't need to use while loop */
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // Retrieve individual field value
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
    }
    mysqli_free_result($result);
    mysqli_close($dbCon);
