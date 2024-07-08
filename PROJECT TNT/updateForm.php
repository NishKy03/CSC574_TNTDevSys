<?php
    include('CHeader.php');
    $sql = "SELECT branchID, CONCAT(branchID, ' - ', name) as branchName FROM branch ORDER BY branchID";
    $rsBranch = mysqli_query($dbCon, $sql);     
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
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
            position:fixed;
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
            <h2>Update Order</h2>
            <label for="orderID">Order ID</label>
            <input type="text" id="orderID" name="orderid" >
            <label for="category">Category</label>
            <select type="text" id="category" name="category">
                <option value="Arrival">Arrival</option>
                <option value="Departure">Departure</option>
                <option value="Delivery">Delivery</option>
            </select>
            <label for="branchID">Branch ID</label>
            <select type="text" id="branchID" name="branchID">
                <?php 
                    while ($row = mysqli_fetch_assoc($rsBranch)) { ?>
                    <option value="<?php echo $row['branchID']; ?>">
                        <?php echo $row['branchName']; ?>
                    </option>
                <?php } ?>
            </select>
            <select id="staff">

            </select>
            <div class="button-confirm">
                <button type="submit">SUBMIT</button>
            </div>
            
        </div>
    </div>
</body>
</html>