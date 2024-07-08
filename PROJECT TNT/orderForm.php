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
            $sql3 = "INSERT INTO orders (senderID, recipientID, parcelWeight, insurance, shipRateID, status, orderDate) VALUES (?, ?, ?, ?, ?, 'Placed',CURDATE())";

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

                    $orderID = mysqli_insert_id($dbCon);

                    $sql4 = "INSERT INTO tracking_update (branchID, orderID, date, category) VALUES ( ?, ?, CURDATE(), 'Arrival')";
                    if($stmt4 = mysqli_prepare($dbCon, $sql4)){
                        mysqli_stmt_bind_param($stmt4, "si",$staffBranch, $orderID);
                        if(mysqli_stmt_execute($stmt4)){
                            $message = "Order placed successfully."; 
                            $success = $message;
                            $updateID = mysqli_insert_id($dbCon);
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
        if (!empty($success)) {
            // Check if $rateID and $orderID are set and not empty
            if (isset($rateID) && isset($orderID) && !empty($rateID) && !empty($orderID)) {
                echo "<script>
                    alert('$success');
                    window.location.href = 'paymentForm.php?shipRateID=$rateID&orderID=$orderID';
                </script>";
            } else {
                echo "<script>alert('Error: Missing rate ID or order ID');</script>";
            }
        } else {
            echo "<script>alert('$message');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        
        <style>
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

        *::before,
        *::after {
            box-sizing: border-box;
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
            margin-bottom: 20px;

        }
        .form h1{
            padding-left: 10px;
            padding-bottom: 15px;
            font-size: 25px;
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

        
        .btn:hover{
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
        }


        #header1{
            font-weight: 600;
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

        .error {
            color: red;
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
                    <h1 id="header1">ORDER</h1>
                </div>
            </div>
            
            <form id="orderForm" class="form" method="POST" action="orderForm.php">
                <!-- <h1 class="text-center">Booking Form</h1> -->
                <div class="form-step form-step-active">
                <h1>Sender Details</h1>
                    <div class="input-group">
                        <label for="SName">Name</label>
                        <input name="SName" id="SName" type="text" value="<?php echo isset($SName) ? $SName : ''?>" required>
                        <span id="nameError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="SPhone" id="SPhone" value="<?php echo isset($SPhone) ? $SPhone : ''?>" required>
                        <span id="phoneNumberError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="SAddress">Address</label>
                        <input type="text" name="SAddress" id="SAddress" value="<?php echo isset($SAddress) ? $SAddress : ''?>" required>
                        <span id="stateError" class="error"></span>
                    </div>
                    <div class="input-group2">
                        <label for="SCity">City</label>
                        <input type="text" name="SCity" id="SCity"  value="<?php echo isset($SCity) ? $SCity : ''?>" required>
                        <span id="cityError" class="error"></span>
                    </div>
                    <div class="input-group3">
                        <label for="state">State</label>
                        <input name="SState" id="SState" type="text" value="<?php echo isset($SState) ? $SState : ''?>" required>
                        <span id="stateError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="SPostcode">Postcode</label>
                        <input type="text" name="SPostcode" id="SPostcode"  value="<?php echo isset($SPostcode) ? $SPostcode : ''?>" required>
                        <span id="postcodeError" class="error"></span>
                    </div>
                    <hr>
                </div>
                   
                    <h1>Recipient Details</h1>
                    <div class="input-group">
                        <label for="recipient">Name</label>
                        <input type="text" name="RName" id="RName" value="<?php echo isset($RName) ? $RName : ''?>" required>
                        <span id="RNameError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="RPhone" id="RPhone" value="<?php echo isset($RPhone) ? $RPhone : ''?>" required>
                        <span id="RPhoneError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="address">Address</label>
                        <input type="text" name="RAddress" id="RAddress" value="<?php echo isset($RAddress) ? $RAddress : ''?>" required>
                       
                    </div>
                    <div class="input-group2">
                        <label for="city">City</label>
                        <input type="text" name="RCity" id="RCity" value="<?php echo isset($RCity) ? $RCity : ''?>" required>
                         <span id="RCityError" class="error"></span>
                    </div>
                    <div class="input-group3">
                        <label for="state">State</label>
                        <input type="text" name="RState" id="RState" value="<?php echo isset($RState) ? $RState : ''?>" required>
                        <span id="RStateError" class="error"></span>
                    </div>
                    <div class="input-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="RPostcode" id="postcode" value="<?php echo isset($RPostcode) ? $RPostcode : ''?>" required>
                        <span id="RPostcodeError" class="error"></span>
                    </div>
                    
                    <hr>
                    <h1>Parcel Details</h1>
                    <div class="input-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="text" name="weight" id="weight" value="<?php echo isset($Weight) ? $Weight : ''?>" required>
                        <span id="weightError" class="error"></span>
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

                    
                        <input type="submit" value="Submit">
                    
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("orderForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission
            
            // Validation function
            function validateField(value, regex, errorMessageElement, errorMessage) {
                if (!regex.test(value)) {
                    errorMessageElement.textContent = errorMessage;
                    return false;
                } else {
                    errorMessageElement.textContent = "";
                    return true;
                }
            }

            // Regular expressions for validation
            var nameRegex = /^[a-zA-Z@]+$/;
            var phoneNumberRegex = /^\d{3}-\d{7}|\d{3}-\d{6}$/;
            var cityStateRegex = /^[a-zA-Z\s]+$/;
            var postcodeRegex = /^\d{5}$/;
            var weightRegex = /^\d+(\.\d+)?$/;

            // Sender fields
            var senderFields = [
                { id: "name", regex: nameRegex, errorElementId: "nameError", errorMessage: "Name must contain only letters and '@'" },
                { id: "phoneNumber", regex: phoneNumberRegex, errorElementId: "phoneNumberError", errorMessage: "Phone Number must be in format 'XXX-XXXXXXXX' or 'XXX-XXXXXXX'" },
                { id: "city", regex: cityStateRegex, errorElementId: "cityError", errorMessage: "City must contain only letters and spaces" },
                { id: "state", regex: cityStateRegex, errorElementId: "stateError", errorMessage: "State must contain only letters and spaces" },
                { id: "postcode", regex: postcodeRegex, errorElementId: "postcodeError", errorMessage: "Postcode must contain exactly 5 numbers" }
            ];

            // Recipient fields
            var recipientFields = [
                { id: "RName", regex: nameRegex, errorElementId: "RNameError", errorMessage: "Name must contain only letters and '@'" },
                { id: "RPhone", regex: phoneNumberRegex, errorElementId: "RPhoneError", errorMessage: "Phone Number must be in format 'XXX-XXXXXXXX' or 'XXX-XXXXXXX'" },
                { id: "RCity", regex: cityStateRegex, errorElementId: "RCityError", errorMessage: "City must contain only letters and spaces" },
                { id: "RState", regex: cityStateRegex, errorElementId: "RStateError", errorMessage: "State must contain only letters and spaces" },
                { id: "RPostcode", regex: postcodeRegex, errorElementId: "RPostcodeError", errorMessage: "Postcode must contain exactly 5 numbers" }
            ];

            // Weight field
            var weightField = { id: "weight", regex: weightRegex, errorElementId: "weightError", errorMessage: "Weight must contain only numbers and '.'" };

            // Validate all fields
            var allValid = true;

            senderFields.forEach(function(field) {
                var value = document.getElementById(field.id).value.trim();
                if (!validateField(value, field.regex, document.getElementById(field.errorElementId), field.errorMessage)) {
                    allValid = false;
                }
            });

            recipientFields.forEach(function(field) {
                var value = document.getElementById(field.id).value.trim();
                if (!validateField(value, field.regex, document.getElementById(field.errorElementId), field.errorMessage)) {
                    allValid = false;
                }
            });

            var weightValue = document.getElementById(weightField.id).value.trim();
            if (!validateField(weightValue, weightField.regex, document.getElementById(weightField.errorElementId), weightField.errorMessage)) {
                allValid = false;
            }

            // If all fields are valid, submit the form
            if (allValid) {
                document.getElementById("orderForm").submit();
            }
        });
    </script>
    </body>
</html>