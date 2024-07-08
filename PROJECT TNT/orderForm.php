<?php
    session_start();
    if (!isset($_SESSION['staffID'])) {
        echo '<div class="access-denied">Only Accessible by Staff</div>';
        echo "<script>window.location = 'login.php'<script>";
        exit();
    }

    require_once 'dbConnect.php'; // Adjust the path as per your project structure

    // Check if staff position is 'courier'
    if ($_SESSION['position'] !== 'staff') {
        echo '<div class="access-denied">Access Denied. Only accessible by regular staff.</div>';
        exit();
    }

    $username = $_SESSION["staffName"]; // Use the correct session variable to display the username
    
    $staffIncharge = $_SESSION['staffID'];
    $staffBranch = $_SESSION['branchID'];

    $message = "";
    $SID = $SName = $SPhone = $SAddress = $SCity = $SState = $SPostcode = $RID = $RName = $RPhone = $RAddress = $RCity = $RState = $RPostcode = $Weight = $Description = $Insurance = $rateID = "";
    $SName_err = $SPhone_err = $SAddress_err = $SCity_err = $SState_err = $SPostcode_err = $RName_err = $RPhone_err = $RAddress_err = $RCity_err = $RState_err = $RPostcode_err = $Weight_err = $Description_err = $Insurance_err = $rateID_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Sender Details
        if (empty(trim($_POST["SName"]))) {
            $SName_err = "Please enter the sender's name.";
        } else {
            $SName = trim($_POST["SName"]);
        }
        if (empty(trim($_POST["SPhone"]))) {
            $SPhone_err = "Please enter the sender's phone number.";
        } else {
            $SPhone = trim($_POST["SPhone"]);
        }
        if (empty(trim($_POST["SAddress"]))) {
            $SAddress_err = "Please enter the sender's address.";
        } else {
            $SAddress = trim($_POST["SAddress"]);
        }
        if (empty(trim($_POST["SCity"]))) {
            $SCity_err = "Please enter the sender's city.";
        } else {
            $SCity = trim($_POST["SCity"]);
        }
        if (empty(trim($_POST["SState"]))) {
            $SState_err = "Please enter the sender's state.";
        } else {
            $SState = trim($_POST["SState"]);
        }
        if (empty(trim($_POST["SPostcode"]))) {
            $SPostcode_err = "Please enter the sender's postcode.";
        } else {
            $SPostcode = trim($_POST["SPostcode"]);
        }
        //Recipient Details
        if (empty(trim($_POST["RName"]))) {
            $RName_err = "Please enter the recipient's name.";
        } else {
            $RName = trim($_POST["RName"]);
        }
        if (empty(trim($_POST["RPhone"]))) {
            $RPhone_err = "Please enter the recipient's phone number.";
        } else {
            $RPhone = trim($_POST["RPhone"]);
        }
        if (empty(trim($_POST["RAddress"]))) {
            $RAddress_err = "Please enter the recipient's address.";
        } else {
            $RAddress = trim($_POST["RAddress"]);
        }
        if (empty(trim($_POST["RCity"]))) {
            $RCity_err = "Please enter the recipient's city.";
        } else {
            $RCity = trim($_POST["RCity"]);
        }
        if (empty(trim($_POST["RState"]))) {
            $RState_err = "Please enter the recipient's state.";
        } else {
            $RState = trim($_POST["RState"]);
        }
        if (empty(trim($_POST["RPostcode"]))) {
            $RPostcode_err = "Please enter the recipient's postcode.";
        } else {
            $RPostcode = trim($_POST["RPostcode"]);
        }
        //Parcel Details
        if (empty(trim($_POST["weight"]))) {
            $Weight_err = "Please enter the parcel's weight.";
        } else {
            $Weight = floatval($_POST["weight"]);
        }
        if (empty(trim($_POST["description"]))) {
            $Description_err = "Please enter the parcel's description.";
        } else {
            $Description = trim($_POST["description"]);
        }
        $Insurance = isset($_POST["insurance"]) ? 1.0 : 0.0;
        if (isset($_POST["shipRateID"]) && !empty(trim($_POST["shipRateID"]))) {
            $rateID = trim($_POST["shipRateID"]);
        } else {
            $rateID_err = "Please select a shipping rate.";
        }

        if (empty($SName_err) && empty($SPhone_err) && empty($SAddress_err) && empty($SCity_err) && empty($SState_err) && empty($SPostcode_err) && empty($RName_err) && empty($RPhone_err) && empty($RAddress_err) && empty($RCity_err) && empty($RState_err) && empty($RPostcode_err) && empty($Weight_err) && empty($Description_err) && empty($rateID_err)) {
            $sql1 = "INSERT INTO sender (senderName, senderPhoneNo, addressLine1, city, state, postcode) VALUES (?, ?, ?, ?, ?, ?)";
            $sql2 = "INSERT INTO recipient (name, phoneNo, addressLine1, city, state, postcode) VALUES (?, ?, ?, ?, ?, ?)";
            $sql3 = "INSERT INTO orders (senderID, recipientID, parcelWeight, insurance, shipRateID, status) VALUES (?, ?, ?, ?, ?, 'Out for Delivery')";

            if ($stmt1 = mysqli_prepare($dbCon, $sql1)) {
                mysqli_stmt_bind_param($stmt1, "sssssi", $SName, $SPhone, $SAddress, $SCity, $SState, $SPostcode);
                if (mysqli_stmt_execute($stmt1)) {
                    $senderID = mysqli_insert_id($dbCon);
                    $message = "Sender details added successfully.";
                } else {
                    $message = "Error adding sender details.";
                }
                mysqli_stmt_close($stmt1);
            }

            if ($stmt2 = mysqli_prepare($dbCon, $sql2)) {
                mysqli_stmt_bind_param($stmt2, "sssssi", $RName, $RPhone, $RAddress, $RCity, $RState, $RPostcode);
                if (mysqli_stmt_execute($stmt2)) {
                    $recipientID = mysqli_insert_id($dbCon);
                    $message = "Recipient details added successfully.";
                } else {
                    $message = "Error adding recipient details.";
                }
                mysqli_stmt_close($stmt2);
            }

            if ($stmt3 = mysqli_prepare($dbCon, $sql3)) {
                mysqli_stmt_bind_param($stmt3, "iidii", $senderID, $recipientID, $Weight, $Insurance, $rateID);
                if (mysqli_stmt_execute($stmt3)) {
                    $message = "Parcel details added successfully.";
                    $success = $message;

                    $orderID = mysqli_insert_id($dbCon);

                    $sql4 = "INSERT INTO tracking_update (orderID, date, category) VALUES ( ?, CURDATE(), 'Order placed')";
                    if($stmt4 = mysqli_prepare($dbCon, $sql4)){
                        mysqli_stmt_bind_param($stmt4, "i", $orderID);
                        if(mysqli_stmt_execute($stmt4)){
                            $message = "Order placed successfully.";
                        }else{
                            $message = "Error adding tracking details.";
                        }
                        mysqli_stmt_close($stmt4);
                    }
                } else {
                    $message = "Error adding parcel details.";
                }
                mysqli_stmt_close($stmt3);
            }
        } else {
            $message = "Please fill all the details.";
        }
    }

    if (!empty($message)) {
        if(!empty($success)){
            echo "<script>
            alert('$success');
            window.location.href = 'paymentForm.html';
            </script>";
        }else{
            echo "<script>alert('$message');</script>";
        }
       
    }
?>

<!DOCTYPE html>
<html>
    <head>
        
        <style>

        :root {
            --bar-width: 30px;
            --bar-height: 4px;
            --hamburger-gap: 4px;
            --foreground: #333;
            --background: white;
            --hamburger-margin: 10px;
            --animation-timing: 200ms ease-in-out;
            --hamburger-height: calc(var(--bar-height) * 3 + var(--hamburger-gap) * 2);
        }

        .header {
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            padding: 10px;
            position: fixed;
            z-index: 1; 
            width: 100%;
            background-color: #4B0606;
            color: white;
            font-size: 35px;
            cursor: pointer;
            padding-left: 40px;
        }

        .header .opt {
            float: left;
            color: white;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            border-radius: 4px;
        }

        .header .logo {
            padding: 0;
            
        }

        .header img {
            height: 50px;
            width: auto;
            margin-left: 40px;
        }

        .header .opt:hover {
            background-color: #85856A;
            color: black;
        }

        .header .opt.active {
            background-color: #2b2b23;
            color: white;
        }

        .header-right {
            float: right;
            padding-right: 1%;
        }

        @media screen and (max-width: 500px) {
            .header .opt {
                float: none;
                display: block;
                text-align: left;
            }

            .header-right {
                float: none;
            }
        }

        .hamburger-menu {
            --x-width: calc(var(--hamburger-height) * 1.41421356237);
            color: white;
            display: flex;
            flex-direction: column;
            gap: var(--hamburger-gap);
            width: max-content;
            position: absolute;
            top: var(--hamburger-margin);
            left: var(--hamburger-margin);
            z-index: 2;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;;
        }

        .hamburger-menu:has(input:checked) {
            --foreground: #333;
            --background: #333;
        }

        .hamburger-menu:has(input:focus-visible)::before,
        .hamburger-menu:has(input:focus-visible)::after,
        .hamburger-menu input:focus-visible {
            border: 1px solid var(--background);
            box-shadow: 0 0 0 1px var(--foreground);
        }

        .hamburger-menu::before,
        .hamburger-menu::after,
        .hamburger-menu input {
            content: "";
            width: var(--bar-width);
            height: var(--bar-height);
            background-color: var(--foreground);
            border-radius: 9999px;
            transform-origin: left center;
            transition: opacity var(--animation-timing), width var(--animation-timing),
                rotate var(--animation-timing), translate var(--animation-timing),
                background-color var(--animation-timing);
        }

        .hamburger-menu input {
            appearance: none;
            padding: 0;
            margin: 0;
            outline: none;
            pointer-events: none;
        }

        .hamburger-menu:has(input:checked)::before {
            rotate: 45deg;
            width: var(--x-width);
            translate: 0 calc(var(--bar-height) / -2);
        }

        .hamburger-menu:has(input:checked)::after {
            rotate: -45deg;
            width: var(--x-width);
            translate: 0 calc(var(--bar-height) / 2);
        }

        .hamburger-menu input:checked {
            opacity: 0;
            width: 0;
        }

        .sidebar {
            transition: translate var(--animation-timing);
            translate: -100%;
            padding-top: calc(var(--hamburger-height) + var(--hamburger-margin) + 1rem);
            background-color: #59593F;
            color: var(--background);
            max-width: 10 rem;
            min-height: 100vh;
            margin-top: 50px;
            position: fixed;
            padding-left: 10px;
            padding-right: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        /* When you mouse over the navigation links, change their color */
        .sidebar a:hover {
            color: black;
        }

        .sidebar .profile {
            text-align: center;
            padding: 10px 0;
        }

        .sidebar .profile img {
            width: 100px;
            border-radius: 50%;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            padding: 10px 20px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar nav ul li.active a {
            background-color: #b30000; /* Slightly lighter red */
        }

        .hamburger-menu:has(input:checked) + .sidebar {
            translate: 0;
        }
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
        :root{
            --primary-color: rgb(11, 78, 179);
        }
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body{
            min-height: 100vh;
            background: #ECE0D1;
            background-size: cover;
            background-position: center;
            overflow-x: hidden;
        }

        .container {
            display: flex;
            flex-direction: column;
        }

        .side-bar{
            background: #1b1a1b;
            backdrop-filter: blur(15px);
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -250px;
            overflow-y: auto;
            transition: 0.6s ease;
            transition-property: left;
            z-index: 1000;
        }

        .side-bar::-webkit-scrollbar {
            width: 0px;
        }

        .side-bar.active{
            left: 0;
        }

        header h1{
            text-align: center;
            font-weight: 500;
            font-size: 25px;
            padding-bottom: 13px;
            font-family: sans-serif;
            letter-spacing: 2px;
        }

        .side-bar .menu{
            width: 100%;
            margin-top: 30px;
        }

        .side-bar .menu .item{
            position: relative;
            cursor: pointer;
        }

        .side-bar .menu .item a{
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            display: block;
            padding: 5px 30px;
            line-height: 60px;
        }

        .side-bar .menu .item a:hover{
            background: #33363a;
            transition: 0.3s ease;
        }

        .side-bar .menu .item i{
            margin-right: 15px;
        }

        .side-bar .menu .item a .dropdown{
            position: absolute;
            right: 0;
            margin: 20px;
            transition: 0.3s ease;
        }

        .side-bar .menu .item .sub-menu{
            background: #262627;
            display: none;
        }

        .side-bar .menu .item .sub-menu a{
            padding-left: 80px;
        }

        .rotate{
            transform: rotate(90deg);
        }

        .close-btn{
            position: absolute;
            color: #fff;
            font-size: 23px;
            right:  0px;
            margin: 15px;
            cursor: pointer;
        }

        .menu-btn{
            width: 100%;
            background-color: #4B0606;
            color: white;
            font-size: 35px;
            cursor: pointer;
            padding: 10px;
            padding-left: 40px;
        }


        img{
            width: 100px;
            margin: 15px;
            border-radius: 50%;
            margin-left: 70px;
            border: 3px solid #b4b8b9;
        }

        header{
            background: #33363a;
        }

        .section{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .progressbar-wrap{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .progressbar{
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
            margin: 2rem 0 4rem;
            width: 20%;
            margin-top: 100px;
        }

        .progressbar::before, .progress{
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%; 
            background-color: #414040;
            z-index: -1;
        }

        .progress{
            background-color: rgb(11, 169, 11);
            width: 0%;
        }

        .progress-step{
            width: 50px;
            height: 50px;
            border: 3px solid #414040;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .progress-step::before{
            counter-increment: step;
            content: counter(step);
        }

        .progress-step::after{
            content: attr(data-title);
            position: absolute;
            top: calc(100% + 0.5rem);
            font-size: 18px;
            color: #666;
            font-weight: bold;
        }

        .progress-step-active{
            background-color: rgb(11, 169, 11);
            color: #fff;
            border: none;
            back
        }

        *::before,
        *::after {
            box-sizing: border-box;
        }

        label{
            display: block;
            padding-left: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        .width-50{
            width: 50%;
        }

        .ml-auto{
            margin-left: auto;
        }

        .text-center{
            text-align: center;
        }

        .input-group input[type="text"], 
        .input-group2 input[type="text"],
        .input-group3 input[type="text"],
        .input-group4 input[type="text"],.input-group select{
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
        .input-group4 input[type="checkbox"]{
            margin-left: 20px;
        }
        .input-group input[type="textarea"]{
            width: 100%;
            height: 100px;
            padding: 10px;
            border-radius: 20px;
            outline: none;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        select{
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            width: 270px;
        }
        .form{
            width: 700px;
            margin: 0 auto;
            border: 3px solid #4B0606;
            border-radius: 20px;
            padding-left: 50px;
            padding-right: 50px;
            padding-top: 20px;
            padding-bottom: 20px;

        }
        .form h1{
            padding-left: 10px;
            padding-bottom: 15px;
            font-size: 25px;
        }
        .form-step{
            display: none;
        }

        .form-step-active{
            display: block;
        }

        .input-group{
            margin-bottom: 10px;
        }
        .input-group2, .input-group3, .input-group4, .input-group4{
            display: inline-block;
            margin-bottom: 10px;
        }
        .input-group4{
            margin-left: 40px;
        }
        .input-group2{
            width: 50%;
            margin-right: 20px;
        }
        
        .btns-group{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        .btns-group input[type="submit"]
        {
            border: none;
        }
        .btn{
            padding: 0.75rem;
            display: block;
            text-decoration : none;
            background-color: var(--primary-color);
            color: #f3f3f3;
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn:hover{
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
        }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
    <?php include("CHeader.php")?>
        <div class="container">
        <div class="section">
            <div class="progressbar-wrap">
                <div class="progressbar">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title="Sender"></div>
                    <div class="progress-step" data-title="Receipent"></div>
                    <div class="progress-step" data-title="Parcel"></div>
                    <!-- <div class="progress-step" data-title="Submit"></div> -->
                </div>
            </div>
            
            <form id="orderForm" class="form" method="POST" action="orderForm.php">
                <!-- <h1 class="text-center">Booking Form</h1> -->

                <div class="form-step form-step-active">
                    <h1>Sender Details</h1>
                    <div class="input-group">
                        <label for="SName">Name</label>
                        <input name="SName" id="SName" type="text" value="<?php echo isset($SName) ? $SName : ''?>">
                     
                    </div>
                    <div class="input-group">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="SPhone" id="SPhone" value="<?php echo isset($SPhone) ? $SPhone : ''?>" >
                    </div>
                    <div class="input-group">
                        <label for="SAddress">Address</label>
                        <input type="text" name="SAddress" id="SAddress" value="<?php echo isset($SAddress) ? $SAddress : ''?>" >
                    </div>
                    <div class="input-group2">
                        <label for="SCity">City</label>
                        <input type="text" name="SCity" id="SCity"  value="<?php echo isset($SCity) ? $SCity : ''?>" >
                    </div>
                    <div class="input-group3">
                        <label for="state">State</label>
                        <input name="SState" id="SState" type="text" value="<?php echo isset($SState) ? $SState : ''?>" >
                    </div>
                    <div class="input-group">
                        <label for="SPostcode">Postcode</label>
                        <input type="text" name="SPostcode" id="SPostcode"  value="<?php echo isset($SPostcode) ? $SPostcode : ''?>" >
                    </div>
       
                    <div class="">
                        <a href="#" class="btn btn-next width-50 ml-auto">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <h1>Recipient Details</h1>
                    <div class="input-group">
                        <label for="recipient">Name</label>
                        <input type="text" name="RName" id="RName" value="<?php echo isset($RName) ? $RName : ''?>" >
                    </div>
                    <div class="input-group">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="RPhone" id="RPhone" value="<?php echo isset($RPhone) ? $RPhone : ''?>" >
                    </div>
                    <div class="input-group">
                        <label for="address">Address</label>
                        <input type="text" name="RAddress" id="RAddress" value="<?php echo isset($RAddress) ? $RAddress : ''?>" >
                    </div>
                    <div class="input-group2">
                        <label for="city">City</label>
                        <input type="text" name="RCity" id="RCity" value="<?php echo isset($RCity) ? $RCity : ''?>" >
                    </div>
                    <div class="input-group3">
                        <label for="state">State</label>
                        <input type="text" name="RState" id="RState" value="<?php echo isset($RState) ? $RState : ''?>" >
                    </div>
                    <div class="input-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="RPostcode" id="postcode" value="<?php echo isset($RPostcode) ? $RPostcode : ''?>" >
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Previous</a>
                        <a href="#" class="btn btn-next">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <div class="input-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="text" name="weight" id="weight" value="<?php echo isset($Weight) ? $Weight : ''?>" required>
                    </div>
                    <div class="input-group">
                        <label for="description">Description</label>
                        <input type="textarea" name="description" id="description" value="<?php echo isset($Description) ? $Description : ''?>" required>
                    </div>
                    <div class="input-group3">
                        <label for="rate">Shipping Rate</label>
                        <select name="shipRateID" id="shipRateID" required>
                            <option value="" disabled selected>Select shipping rate</option>
                        <?php
							$sql = "SELECT * FROM shipping_rate";
							$result = mysqli_query($dbCon, $sql);
							while($row = mysqli_fetch_array($result)){
								$rateID = $row['shipRateID'];
								$rate = $row['shipRateName'];
								$selected = ($rateID == $_POST['shipRateID']) ? 'selected' : '';
								echo "<option value='$rateID'>$rate</option>";
							}
						?>
                        </select>
                    </div>
                    <div class="input-group4">
                        <b>Insurance</b>
                        <input type="checkbox" name="insurance" id="insurance">
                    </div>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Previous</a>
                        <input type="submit" value="Submit" class="btn">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            // Side bar toggle
            $(".menu-btn").click(function(){
                $(".side-bar").addClass("active");
                $(".menu-btn").css("visibility", "hidden");
            });

            $(".close-btn").click(function(){
                $(".side-bar").removeClass("active");
                $(".menu-btn").css("visibility", "visible");
            });

            // Sub menu toggle
            $(".sub-btn").click(function(){
                $(this).next(".sub-menu").slideToggle();
                $(this).find(".dropdown").toggleClass("rotate");
            });
        });
        const prevBtns = document.querySelectorAll(".btn-prev");
        const nextBtns = document.querySelectorAll(".btn-next");
        const progress = document.getElementById("progress");
        const formSteps = document.querySelectorAll(".form-step");
        const progressSteps = document.querySelectorAll(".progress-step");

        let formStepsNum = 0;

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum++;
                updateFormSteps();
                updateProgressbar();
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressbar();
            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep) => {
                formStep.classList.contains("form-step-active") &&
                formStep.classList.remove("form-step-active");
            });
            formSteps[formStepsNum].classList.add("form-step-active");
        }

        function updateProgressbar() {
            progressSteps.forEach((progressStep, idx) => {
                if (idx <= formStepsNum) {
                    progressStep.classList.add("progress-step-active");
                } else {
                    progressStep.classList.remove("progress-step-active");
                }
            });
            const progressActive = document.querySelectorAll(".progress-step-active");
            progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
        }
    </script>
    </body>
</html>