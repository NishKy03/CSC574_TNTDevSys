<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once('SWOrderDetails.php');
        ?>
        <script >
            //alert("Please click Ctrl + P to print the order statement");
            window.print();
        </script>
        <title>Print Order Statement</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <style>
            .container {
                padding: 20px;
                max-width: 800px;
                width: fit-content;
                margin: auto;
                font-family: "Poppins", sans-serif;
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
        </style>
    </head>
    <body>
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
    </div>
    </body>
</html>