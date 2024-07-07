<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once('SWOrderDetails.php');
        ?>
        <script >
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
                padding: 3px;
                text-align: left;
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
            .section td.topright-b {
                border-bottom: 2px solid black;
                border-left: 2px solid black;
            }
            .section td.topbotright-b {
                border-left: 2px solid black;
            }
            .section td.topleft-b {
                border-bottom: 2px solid black;
                border-right: 2px solid black;
            }
            .section td.topbotleft-b {
                border-right: 2px solid black;
            }
            .section tr.details{
                font-size: small;
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
                <td class="all-b"><img src="images/tntlogo.png"></td>
                <td class="all-b" colspan="2" style="text-align: center;"><h2><?php echo $orderID; ?></h2></td>
            </tr>
            <tr>
                <td class="bottom-b" colspan="2" style="font-weight:bold; font-size:medium;">Order Details</td>
                <td class="all-b" rowspan="12" style="text-align: center; padding-left:10px; padding-left:10px; padding-right:10px;"><?php if($insurance > 0.0) echo "<h2>INSURED</h2>"?><br><h2><?php echo $rPostcode; ?></h2></td>
            </tr>
            <tr class="details">
                <td class="topright-b">Weight(kg):</td>
                <td class="topleft-b"><?php echo $weight; ?></td>
            </tr>
            <tr>
                <td class="bottom-b" colspan="2" style="font-weight:bold; font-size:medium;">Sender Details</td>
            </tr>
            <tr class="details">
                <td class="topbotright-b" style="vertical-align:text-top;">Name:</td>
                <td class="topbotleft-b"><?php echo $sName; ?></td>
            </tr>
            <tr class="details">
                <td class="topbotright-b" style="vertical-align:text-top;">Phone No:</td>
                <td class="topbotleft-b"><?php echo $sPhoneNo; ?></td>
            </tr>
            <tr class="details">
                <td class="topbotright-b" style="vertical-align:text-top;">Address:</td>
                <td class="topbotleft-b"><?php echo $sAddress; ?>,<br><?php echo $sPostcode; ?>&nbsp;<?php echo $sCity; ?>,<br><?php echo $sState; ?></td>
            </tr>
            <tr class="details">
                <td class="topright-b" style="vertical-align:text-top;">Postcode:</td>
                <td class="topleft-b"><?php echo $sPostcode; ?></td>
            </tr>
            <tr>
                <td class="bottom-b" colspan="2" style="font-weight:bold; font-size:medium;">Sender Details</td>
            </tr>
            <tr class="details">
                <td class="topbotright-b" style="vertical-align:text-top;">Name:</td>
                <td class="topbotleft-b"><?php echo $rName; ?></td>
            </tr>
            <tr class="details">
                <td class="topbotright-b" style="vertical-align:text-top;">Phone No:</td>
                <td class="topbotleft-b"><?php echo $rPhoneNo; ?></td>
            </tr>
            <tr class="details">
                <td class="topbotright-b" style="vertical-align:text-top;">Address:</td>
                <td class="topbotleft-b"><?php echo $rAddress; ?>,<br><?php echo $rPostcode; ?>&nbsp;<?php echo $rCity; ?>,<br><?php echo $rState; ?></td>
            </tr>
            <tr class="details">
                <td class="topright-b" style="vertical-align:text-top;">Postcode:</td>
                <td class="topleft-b"><?php echo $rPostcode; ?></td>
            </tr>
            <tr class="details">
                <td class="all-b" style="text-align: center;"><h3>P.O.D.</h3></td>
                <td class="right-b">Name:<br>IC:</td>
                <td class="left-b">Signature:</td>
            </tr>
            <tr></tr>
        </table>
    </div>
    </div>
    </body>
</html>