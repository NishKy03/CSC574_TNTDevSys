<?php
    require_once "dbConnect.php";
    session_start();

    // Initialize variables
    $orderID = $_GET['orderID'] ?? '';
    $staffOptions = "";

    // Fetch staff members with position='courier'
    $sql = "SELECT staffID, staffName, branchid FROM staff WHERE position = 'courier'";
    $result = mysqli_query($dbCon, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $staffID = $row['staffID'];
            $staffName = $row['staffName'];
            $staffbranch = $row['branchid'];
            $staffOptions .= "<option value='$staffID'>$staffID - $staffName</option>";
        }
    } else {
        $staffOptions = "<option value=''>No couriers available</option>";
    }

    // Handle form submission to update tracking_update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $orderID = $_POST['orderID'];
        $staffID = $_POST['staffid'];

        // Update the tracking_update table
        $updateSql = "UPDATE tracking_update SET date = NOW(), category = 'Assign Courier', staffID = ?, branchID = ? WHERE orderID = ?";
        if ($stmtUpdate = mysqli_prepare($dbCon, $updateSql)) {
            // Assuming branchID is available from session or other sources
            
            mysqli_stmt_bind_param($stmtUpdate, "sss", $staffID, $staffbranch, $orderID);

            if (mysqli_stmt_execute($stmtUpdate)) {
                // Redirect back to order list or wherever appropriate
                header("Location: COrderList.php");
                exit();
            } else {
                echo "Error updating record in tracking_update: " . mysqli_error($dbCon);
            }

            mysqli_stmt_close($stmtUpdate);
        } else {
            echo "Error preparing update statement: " . mysqli_error($dbCon);
        }
    }

    mysqli_close($dbCon);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ece0d1;
        }
        
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
            position: fixed;
        }
        .form-container {
            position: relative;
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: #4b0606;
            width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
        }
        .button-close .btn-close {
            position: absolute;
            background-color: transparent;
            border: none;
            font-size: 40px;
            cursor: pointer;
            right: 4px;
            top: 2px;
            color: white;
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
            margin-left: 40px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .button-confirm button {
            width: 30%;
            padding: 10px;
            margin-top: 10px;
            background-color: #b45858;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
        }
        .button-confirm button:hover {
            background-color: #45a049;
        }
        .form-container a {
            text-decoration: none;
            color: #cccccc;
            font-size: 14px;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="button-close">
                <button class="btn-close">&times;</button>
            </div>
            <h2>DELIVERY</h2>
            <p>Order ID: <?php echo $orderID; ?></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($orderID); ?>">
                <label for="staffid">Select Courier:</label>
                <select id="staffid" name="staffid">
                    <?php echo $staffOptions; ?>
                </select>

                <div class="button-confirm">
                    <button type="submit">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
