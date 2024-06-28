<?php
    include('nav.html');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Order Statement</title>
        <style>
            .progress-container {
                display: flex;
                background-color: #4a4a4a;
                padding: 10px 0;
                justify-content: center;
                align-items: center;
                position: relative;
                width: 100%;
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
    </body>
</html>