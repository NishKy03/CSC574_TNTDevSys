<?php
    include('nav.html');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Orders List</title>
        <style>
            body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(0deg, rgba(148, 148, 148, 0.61) 0%, rgba(148, 148, 148, 0.61) 20%), url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            }

            .content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            }
            .content h1 {
                color: #7a2321;
                font: weight 700px;;
                margin-bottom: 20px;
            }
            .order-table {
                width: 100%;
                border-collapse: collapse;
            }
            .order-table th, .order-table td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }
            .order-table th {
                background: #b9876d;
                color: white;
            }
            .order-table tr:nth-child(even) {
                background: #f2f2f2;
            }
            .order-table tr:hover {
                background: #ddd;
            }
            .update-button {
                background: #56c4e1;
                border: none;
                padding: 5px 10px;
                color: white;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>ORDERS (Branch ID: B0009)</h1>
                <table class="order-table">
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>State (Recipient)</th>
                        <th>Status</th>
                        <th>Delivery Staff ID</th>
                        <th>Action</th>
                    </tr>
                    <!--
                    include 'orders.php';
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>{$order['order_id']}</td>";
                        echo "<td>{$order['order_date']}</td>";
                        echo "<td>{$order['state']}</td>";
                        echo "<td>{$order['status']}</td>";
                        echo "<td>{$order['delivery_staff_id']}</td>";
                        echo "<td><button class='update-button'>Update</button></td>";
                        echo "</tr>";
                    }
                    -->
                </table>
            </div>
        </div>
    </body>
</html>