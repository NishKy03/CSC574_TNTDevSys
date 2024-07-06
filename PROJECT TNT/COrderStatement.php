<?php
    include('CnavIn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Order Statement</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #ECE0D1;
            margin: 0;
        }
        .progress-container {
            display: flex;
            background-color: #4a4a4a;
            padding: 0;
            justify-content: center;
            align-items: center;
            position: fixed;
            width: 100%;
            margin-top: 70px;
        }
        .progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 50%;
            background-color: #4a4a4a;
            padding: 10px 0;
            position: relative;
            margin: 0 auto;
        }

        .step-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #777;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            border: 2px solid #4a4a4a;
            z-index: 1;
        }

        .step.active {
            background-color: #f7931e;
            border-color: #f7931e;
        }

        .label {
            margin-top: 5px;
            color: white;
            font-size: 14px;
            text-align: center;
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            margin-left: 1%;
            width: 94%;
            top: 35%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #777;
            z-index: 0;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            width: fit-content;
            margin: auto;
        }
        .title {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .order-id {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .section {
            padding: 10px;
            margin-bottom: 20px;
            margin-top: 30%;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        .section th, .section td {
            padding: 10px;
            text-align: center;
        }
        .section th {
            background-color: #f0f0f0;
        }
        .section td.all-b {
            border: 2px solid black;
        }
        .section td.right-b {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            border-left: 2px solid black;
        }
        .section td.left-b {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            border-right: 2px solid black;
        }
        .section td.bottom-b {
            border-top: 2px solid black;
            border-right: 2px solid black;
            border-left: 2px solid black;
        }
        .section td.top-b {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
            border-left: 2px solid black;
        }
        .section img {
            height: 50px;
            width: auto;
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
        .actions button {
            background-color: #d9534f;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 10px;
            font-size: 1em;
        }
        .actions button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<div class="progress-container">
    <div class="progress-bar">
        <div class="step-container">
            <div class="step">1</div>
            <div class="label">Order</div>
        </div>
        <div class="step-container">
            <div class="step">2</div>
            <div class="label">Payment</div>
        </div>
        <div class="step-container">
            <div class="step active">3</div>
            <div class="label">Statement</div>
        </div>
    </div>
</div>
<div>
<?php
    require_once('orderStatementDetails.php');
?>
<div class="container">
    <div class="section">
        <table>
            <tr>
                <td class="right-b"><img src="images/tntlogo.png"></td>
                <td class="left-b"><h2><?php echo $orderID; ?></h2></td>
            </tr>
            <tr>
                <td class="bottom-b" style="font-weight:bold; font-size:large;">TO</td>
                <td class="all-b" rowspan="2" style="word-wrap: break-word; text-align: left;"><?php echo $rName; ?>&nbsp;&nbsp;<?php echo $rPhoneNo; ?>&nbsp;&nbsp;<?php echo $rAddress; ?>,&nbsp;<?php echo $rPostcode; ?>&nbsp;<?php echo $rCity; ?>,&nbsp;<?php echo $rState; ?></td>
            </tr>
            <tr><td class="top-b"><?php echo $rPostcode; ?></td></tr>
            <tr>
                <td class="bottom-b" style="font-weight:bold; font-size:large;">FROM</td>
                <td class="all-b" rowspan="2" style="word-wrap: break-word; text-align: left;"><?php echo $sName; ?>&nbsp;&nbsp;<?php echo $sPhoneNo; ?>&nbsp;&nbsp;<?php echo $sAddress; ?>,&nbsp;<?php echo $sPostcode; ?>&nbsp;<?php echo $sCity; ?>,&nbsp;<?php echo $sState; ?></td>
            </tr>
            <tr><td class="top-b"><?php echo $sPostcode; ?></td></tr>
            <tr>
                <td class="all-b"><?php echo $orderDate; ?></td>
                <td class="all-b" rowspan="2" style="word-wrap: break-word; text-align: left;">Total = RM <?php echo $amount; ?></td>
            </tr>
            <tr><td class="all-b"><?php echo $weight; ?> KG</td></tr>
        </table>
    </div>

    <div class="actions">
        <a href='printOrderStatement.php' target="popup" onclick="window.open('printOrderStatement.php', '_blank', 'width=600,height=400'); return false;">Print</a>
        <button onclick="generateWaybill()">Generate Waybill</button>
    </div>
</div>
</div>
<script>
    function generateWaybill() {
        alert('Waybill generated!');
    }
</script>

</body>
</html>
