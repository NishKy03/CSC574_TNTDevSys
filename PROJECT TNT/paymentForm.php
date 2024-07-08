<?php
    session_start();
    if (!isset($_SESSION['staffID'])) {
        echo '<div class="access-denied">Only Accessible by Staff</div>';
        echo "<script>window.location = 'login.php';</script>";
        exit();
    }

    require_once 'dbConnect.php'; // Adjust the path as per your project structure

    // Check if staff position is 'staff'
    if ($_SESSION['position'] !== 'staff') {
        echo '<div class="access-denied">Access Denied. Only accessible by regular staff.</div>';
        exit();
    }

    $orderID = isset($_GET['orderID']) ? $_GET['orderID'] : null;
    $shipRateID = isset($_GET['shipRateID']) ? $_GET['shipRateID'] : null;

    if ($orderID === null || $shipRateID === null) {
        die("Missing required parameters.");
    }

    $sqlselect = "SELECT * FROM orders WHERE orderID = ?";
    $stmtselect = $dbCon->prepare($sqlselect);
    $stmtselect->bind_param("i", $orderID);
    $stmtselect->execute();
    $resultselect = $stmtselect->get_result();
    $rowselect = $resultselect->fetch_assoc();
    $Weight = $rowselect['parcelWeight'];
    $insurance = $rowselect['insurance'];

    $sql = "SELECT * FROM shipping_rate WHERE shipRateID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("i", $shipRateID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $baseFee = $row['baseFee'];
    $addFee = $row['addFee'];

    $totalAmount = $baseFee + ($Weight * $addFee) + ($insurance * $Weight);

    $sql2 = "UPDATE orders SET totalAmount = ? WHERE orderID = ?";
    $stmt2 = $dbCon->prepare($sql2);
    $stmt2->bind_param("di", $totalAmount, $orderID);
    if($stmt2->execute()){
    $message = "Record updated successfully";
    }
    $stmt2->close();

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $paymentMethod = $_POST['methodPay']; // Corrected to match the name attribute of your select element
        $sql = "INSERT INTO payment (orderID, paymentMethod) VALUES (?, ?)";
        $stmt = $dbCon->prepare($sql);
        $stmt->bind_param("is", $orderID, $paymentMethod);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Payment Successful!')</script>";
        header("Location: COrderList.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ece0d1;
        }
        .navbar {
            background-color: #4b0a05;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            padding: 0 20px;
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #4b0a05;
            color: #ff6600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin: -2px;
            border: 4.5px solid #ff6600;
            font-family: Verdana, sans-serif;
            font-weight: bold;
        }
        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 10px 10px;
            transition: background-color 0.3s ease;
            font-family: Verdana, sans-serif;
            font-weight: bold;
            font-size: 18px;
        }
        .navbar-links a:hover {
            background-color: #ddd;
            color: black;
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
            position: absolute;
            border: none;
            padding: 3%;
            margin-left: 70%;
            margin-top: 60%;
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
        .form-container select {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            background-color: white;
            color: black;
        }
        c
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
    <?php include("CHeader.php")?>

    <div class="container">
    <form class="form-container" method="POST" action="paymentForm.php?orderID=<?php echo $orderID ?>&shipRateID=<?php echo $shipRateID ?>">
            <div class="button-close">
                <button class="btn-close">&times;</button>
            </div>
            <h2>PAYMENT</h2>
            <label for="totalAmount">Total Amount</label>
            <input type="text" id="totalAmount" name="totalAmount" value="<?php echo isset($totalAmount) ? $totalAmount : ''?>">
            <label for="methodPay">Payment Method</label>
            <select id="methodPay" name="methodPay">
                <option value="onlineBanking">Online Banking</option>
                <option value="creditDebitCard">Credit / Debit Card</option>
                <option value="maybank2u">Maybank2u</option>
            </select>
            <div class="button-confirm">
                <button type="submit" name="submit">SUBMIT</button>
            </div>
        </form>
    </div>
</body>
</html>
