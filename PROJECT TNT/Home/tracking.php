<?php 
include '../dbConnect.php';
include '../universalHeader.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track & Trace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html{
            background-image: url('../images/bg.jpg'); /* Add the path to your background image */
            background-size: cover; /* Ensures the background image covers the entire body */
            background-position: 0px 50px; /* Centers the background image horizontally and vertically */
            background-repeat: no-repeat;
        }
        body {
            height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: rgba(248, 249, 250, 0.35);
            margin: 0;
            padding: 0;
            
        }

        h1 {
            color: #000;
            text-align: center;
            font-weight: 800;
            margin-top: 20px;
        }
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            width: 300px;
            transition: all 0.3s;
        }
        .search-container input[type="text"]:hover {
            border-color: #4b0606;
        }
        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4b0606;
            border: none;
            color: white;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #590909;
        }
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s, color 0.3s;
        }
        th {
            background-color: #4b0606;
            color: white;
        }
        td {
            color: #333;
        }
        tr:hover td {
            background-color: #f1f1f1;
            color: #4b0606;
        }
    </style>
</head>
<body>

    <h1>Track & Trace</h1>
    <form id="orderForm" action="fetchOrderDetails.php" method="POST">
        <div class="search-container">
            <input type="text" id="orderID" name="orderID" placeholder="Enter order ID" />
            <button type="submit">Search</button>
        </div>
    </form>
    <h1>Details</h1>
    <div class="table-container">
    <?php
        
        // Check if orderID is set in the URL parameter
        if (isset($_GET['orderID'])) {
            $orderID = $_GET['orderID'];
            
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
                // Output data as HTML table
                echo "<table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Sender</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['orderID']."</td>
                            <td>".$row['date']."</td>
                            <td>".$row['status']."</td>
                            <td>".$row['senderName']."</td>
                        </tr>";
                }

                echo "</tbody></table>";
            } else {
                echo 'No records found for orderID: '.$orderID;
            }

            $stmt->close();
        }

        $dbCon->close();
        ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
