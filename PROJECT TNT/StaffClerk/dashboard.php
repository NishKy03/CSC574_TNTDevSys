<?php
    include('nav.html');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <style>
            body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(0deg, rgba(148, 148, 148, 0.61) 0%, rgba(148, 148, 148, 0.61) 20%), url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            }
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
            .chart-container {
                background: rgba(255, 255, 255, 0.8);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="chart-container">
                <h2>Orders Delivered by Staff</h2>
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </body>
</html>

<!--SELECT o.staffID, COUNT(o.staffID)
FROM ORDERS o JOIN TRACKING_UPDATE t
ON o.orderID = t.orderID JOIN STAFF s
ON t.staffID = s.staffID
WHERE category = 'Delivery'
AND branchID = ?
GROUP BY t.staffID;-->