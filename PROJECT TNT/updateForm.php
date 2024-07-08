<?php
    include('CHeader.php');
    require_once('dbConnect.php');
    $branchID = $_SESSION['branchID']; 
    $sql1 = "SELECT branchID, CONCAT(branchID, ' - ', name) as branchName FROM branch ORDER BY branchID"; 
    if (isset($_GET["orderID"]) && !empty(trim($_GET["orderID"]))) {
        $orderID = trim($_GET["orderID"]);
        // Prepare a select statement
        $sql2 = "SELECT staffID, CONCAT(staffID, ' - ', staffName) as staffName FROM staff WHERE position = 'courier' AND branchID = ? ORDER BY staffID";
        
        if ($stmt = mysqli_prepare($dbCon, $sql2)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            
            // Set parameters
            $param_id = $branchID;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $rsStaff = mysqli_stmt_get_result($stmt);
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    } else {
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $orderID= trim($_POST["orderID"]);
        $category = trim($_POST["category"]);
        $branchID = trim($_POST["branchID"]);
        if($category == 'Delivery') {
            $staffID = trim($_POST["staffID"]);
        } else {
            $staffID = $_SESSION['staffID'];
        }

            $sql3 = "INSERT INTO tracking_update (date, category, staffID, branchID, orderID) VALUES (CURDATE(), ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($dbCon, $sql3)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sdsd", $param_ctg, $param_sid, $param_bid, $param_oid);
    
                // Set parameters
                $param_ctg = $category;
                $param_sid = $staffID;
                $param_bid = $branchID;
                $param_oid = $orderID;
    
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    header("location: COrderList.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }
    
            // Close statement
            mysqli_stmt_close($stmt);
            }
    
        // Close connection
        mysqli_close($dbCon);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ece0d1;
        }
        .container {
            margin-left: 250px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 150px;
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
            margin-left: -10%;
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
        .form-container input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .form-container select {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .button-confirm input[type="submit"] {
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
        .button-confirm input[type="text"]:hover {
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
            <h2>Update Order</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="orderID">Order ID</label>
                <input type="text" id="orderID" name="orderID" value="<?php echo $orderID ?>" readonly>
                <label for="category">Category</label>
                <select type="text" id="category" name="category" onchange="showSecondDropdown()">
                    <option value="Arrival">Arrival</option>
                    <option value="Departure">Departure</option>
                    <option value="Delivery">Delivery</option>
                </select>
                <label for="branchID">Branch ID</label>
                <select type="text" id="branchID">
                    <?php 
                        if($rsBranch = mysqli_query($dbCon, $sql1)) {
                            while ($row = mysqli_fetch_assoc($rsBranch)) { ?>
                            <option value="<?php echo $row['branchID']; ?>">
                                <?php echo $row['branchName']; ?>
                            </option>
                    <?php }} ?>
                </select>
                <div id="staff" style="display: none;">
                <label for="staffID">Staff ID</label>
                <select type="text" id="staffID">
                    <?php 
                        while ($row = mysqli_fetch_assoc($rsStaff)) { ?>
                            <option value="<?php echo $row['staffID']; ?>">
                                <?php echo $row['staffName']; ?>
                            </option>
                    <?php } ?>
                </select>
                </div>
                <div class="button-confirm">
                    <input type="submit">
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
    </script>
</body>
</html>