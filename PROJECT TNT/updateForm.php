<?php
include('CHeader.php');
require_once "dbConnect.php";

// Initialize variables
$orderID = $category = $branchID = $staffID = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate orderID (you may need additional validation here)
    $orderID = trim($_POST["orderID"]);
    $category = $_POST["category"];
    $branchID = $_POST["branchID"];
    $staffID = isset($_POST["staffID"]) ? $_POST["staffID"] : null;

    $nextUpdateID = 7000001;
    $sql1 = "SELECT MAX(updateID) AS maxUpdateID FROM tracking_update";
    $result = mysqli_query($dbCon, $sql1);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['maxUpdateID']) {
            $nextUpdateID = $row['maxUpdateID'] + 1;
        }
    }
    // Prepare the appropriate SQL update statement
    if ($category === "Delivery" && !empty($staffID)) {
        $sql2 = "INSERT INTO tracking_update (updateID, date, category, staffID, branchID, orderID) VALUES (?, CURDATE(), ?, ?, ?, ?)";
        $orderStatusUpdate = "UPDATE orders SET status = 'Out for Delivery' WHERE orderID = ?";
    } elseif ($category === "Departure") {
        $sql2 = "INSERT INTO tracking_update (updateID, date, category, branchID, orderID) VALUES (?, CURDATE(), ?, ?, ?)";
        $orderStatusUpdate = "UPDATE orders SET status = 'In Transit' WHERE orderID = ?";
    } else {
        $sql2 = "INSERT INTO tracking_update (updateID, date, category, branchID, orderID) VALUES (?, CURDATE(), ?, ?, ?, ?)";
        $orderStatusUpdate = null; // No status update for other categories
    }

    if ($stmt = mysqli_prepare($dbCon, $sql2)) {
        // Bind variables to the prepared statement as parameters
        if ($category === "Delivery" && !empty($staffID)) {
            mysqli_stmt_bind_param($stmt, "issss", $nextUpdateID, $category, $branchID, $staffID, $orderID);
        } else {
            mysqli_stmt_bind_param($stmt, "isss", $nextUpdateID, $category, $branchID, $orderID);
        }

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Update the order status if required
            if ($orderStatusUpdate) {
                if ($statusStmt = mysqli_prepare($dbCon, $orderStatusUpdate)) {
                    mysqli_stmt_bind_param($statusStmt, "s", $orderID);
                    mysqli_stmt_execute($statusStmt);
                    mysqli_stmt_close($statusStmt);
                }
            }

            // Set session variable to indicate success
            $_SESSION['update_success'] = true;

            // Redirect to the orders list page after successful update
            header("location: COrderList.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
} else {
    // Fetch existing order details for display
    if (isset($_GET["orderID"]) && !empty(trim($_GET["orderID"]))) {
        $orderID = trim($_GET["orderID"]);

        // Prepare a select statement to fetch staff based on branch
        $sql1 = "SELECT branchID, CONCAT(branchID, ' - ', name) as branchName FROM branch ORDER BY branchID";
        $rsBranch = mysqli_query($dbCon, $sql1);

        // Prepare a select statement to fetch staff for delivery category
        $sql2 = "SELECT staffID, CONCAT(staffID, ' - ', staffName) as staffName FROM staff WHERE position = 'courier' AND branchID = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql2)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $branchID);

            // Set parameter
            $branchID = $_SESSION['branchID'];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $rsStaff = mysqli_stmt_get_result($stmt);
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    } else {
        // Redirect to error page if orderID is not provided
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <style>
        /* Styles remain the same */
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
        .form-container input[type="text"], .form-container select {
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
            <h2>Update Order</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
                <label for="category">Category</label>
                <select id="category" name="category" onchange="showSecondDropdown()">
                    <option value="Arrival">Arrival</option>
                    <option value="Departure">Departure</option>
                    <option value="Delivery">Delivery</option>
                </select>
                <label for="branchID">Branch ID</label>
                <select id="branchID" name="branchID">
                    <?php 
                        while ($row = mysqli_fetch_assoc($rsBranch)) { ?>
                        <option value="<?php echo $row['branchID']; ?>">
                            <?php echo $row['branchName']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div id="staff" style="display: none;">
                    <label for="staffID">Staff ID</label>
                    <select id="staffID" name="staffID">
                        <?php 
                            while ($row = mysqli_fetch_assoc($rsStaff)) { ?>
                            <option value="<?php echo $row['staffID']; ?>">
                                <?php echo $row['staffName']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="button-confirm">
                    <button type="submit">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function showSecondDropdown() {
            var firstDropdown = document.getElementById('category');
            var secondDropdownContainer = document.getElementById('staff');
            
            if (firstDropdown.value === 'Delivery') {
                secondDropdownContainer.style.display = 'block';
            } else {
                secondDropdownContainer.style.display = 'none';
            }
        }

        // Check if session variable is set and display alert
        <?php
            if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
                echo "alert('Successfully updated order');";
                unset($_SESSION['update_success']); // unset the session variable after displaying alert
            }
        ?>
    </script>
</body>
</html>