<?php
	include ("../dbConnect.php");

	$message = "";
	$SName = $SPhone = $SAddress = $SCity = $SState = $SPostcode = $RName = $RPhone = $RAddress = $RCity = $RState = $RPostcode = $Weight = $Description = $Insurance = $rate = "";
	$SName_err = $SPhone_err = $SAddress_err = $SCity_err = $SState_err = $SPostcode_err = $RName_err = $RPhone_err = $RAddress_err = $RCity_err = $RState_err = $RPostcode_err = $Weight_err = $Description_err = $Insurance_err = $rate_err = "";


	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Sender Details
		if(empty(trim($_POST["SName"]))){
			$SName_err = "Please enter the sender's name.";
		} else{
			$SName = trim($_POST["SName"]);
		}
		if(empty(trim($_POST["SPhone"]))){
			$SPhone_err = "Please enter the sender's phone number.";
		} else{
			$SPhone = trim($_POST["SPhone"]);
		}
		if(empty(trim($_POST["SAddress"]))){
			$SAddress_err = "Please enter the sender's address.";
		} else{
			$SAddress = trim($_POST["SAddress"]);
		}
		if(empty(trim($_POST["SCity"]))){
			$SCity_err = "Please enter the sender's city.";
		} else{
			$SCity = trim($_POST["SCity"]);
		}
		if(empty(trim($_POST["SState"]))){
			$SState_err = "Please enter the sender's state.";
		} else{
			$SState = trim($_POST["SState"]);
		}
		if(empty(trim($_POST["SPostcode"]))){
			$SPostcode_err = "Please enter the sender's postcode.";
		} else{
			$SPostcode = trim($_POST["SPostcode"]);
		}
		//Recipient Details
		if(empty(trim($_POST["RName"]))){
			$RName_err = "Please enter the recipient's name.";
		} else{
			$RName = trim($_POST["RName"]);
		}
		if(empty(trim($_POST["RPhone"]))){
			$RPhone_err = "Please enter the recipient's phone number.";
		} else{
			$RPhone = trim($_POST["RPhone"]);
		}
		if(empty(trim($_POST["RAddress"]))){
			$RAddress_err = "Please enter the recipient's address.";
		} else{
			$RAddress = trim($_POST["RAddress"]);
		}
		if(empty(trim($_POST["RCity"]))){
			$RCity_err = "Please enter the recipient's city.";
		} else{
			$RCity = trim($_POST["RCity"]);
		}
		if(empty(trim($_POST["RState"]))){
			$RState_err = "Please enter the recipient's state.";
		} else{
			$RState = trim($_POST["RState"]);
		}
		if(empty(trim($_POST["RPostcode"]))){
			$RPostcode_err = "Please enter the recipient's postcode.";
		} else{
			$RPostcode = trim($_POST["RPostcode"]);
		}
		//Parcel Details
		if(empty(trim($_POST["Weight"]))){
			$Weight_err = "Please enter the parcel's weight.";
		} else{
			$Weight = floatval($_POST["Weight"]);
		}
		if(empty(trim($_POST["Description"]))){
			$Description_err = "Please enter the parcel's description.";
		} else{
			$Description = trim($_POST["Description"]);
		}
		if(isset($_POST["insurance"])){
			$Insurance = 1.0;
		} else{
			$Insurance = 0.0;
		}
		if(isset($_POST["shippingRate"]) && !empty(trim($_POST["shippingRate"]))){
			$rate = trim($_POST["shippingRate"]);
		} else{
			$rate_err = "Please select a shipping rate.";
		}
	}
		if(empty($SName_err) && empty($SPhone_err) && empty($SAddress_err) && empty($SCity_err) && empty($SState_err) && empty($SPostcode_err) && empty($RName_err) && empty($RPhone_err) && empty($RAddress_err) && empty($RCity_err) && empty($RState_err) && empty($RPostcode_err) && empty($Weight_err) && empty($Description_err)){
			$sql = "INSERT INTO orders (senderID,recipientID,parcelWeight,insurance,shipRateID) VALUES (?, ?, ?, ?, ?)";
			if($stmt = mysqli_prepare($dbCon, $sql)){
				mysqli_stmt_bind_param($stmt, "iiddi", $SName, $RName, $Weight, $Insurance, $rate);



				if(mysqli_stmt_execute($stmt)){
					$message = "Parcel details added successfully.";
				} else{
					$message = "Error adding parcel details.";
				}
			}
		} else{
			$message = "Please Fill All the Details.";
		}
			
?>

<!DOCTYPE html>
<html>
    <head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <style>

		.frame{
			margin-left: 21%;
			border-radius: 20px;
			border: 0.3rem solid #4b0606;
			width: 1059px;
			padding: .5rem;
			height: 551px;
			animation: fade 250ms  ease-in-out forwards;
		}

		.frame.active{
			animation: slide 250ms 125ms ease-in-out both;
		}
		
		.title {
			font-size: 36px;
			font-weight: 600;
			display: flex;
			padding-left: 3%;
		}
		
		.form-row{
			display: flex;
			
		}

        .form-group {
            display:flex;
			flex-direction: column;
			gap: .25rem;
            padding-right: 5%;
			padding-left: 3%;
			margin-bottom: .5rem;
        }
		.form-group > label {
			display: flex;
			font-weight: bold;
			font-size: 26px;
			align-items: center;
			width: 269px;
			height: 29px;

		}

		.form-group > input{
			padding: .25rem;
			border: 1px solid #333;
			border-radius: 0.25em;
			font-size: 1rem;
		}

		.multi-step-form{
			overflow: hidden;
			position: relative;
			background-color: #ECE0D1;
			top: 200px;
			width: 100%;

		}

		.hide{
			display: none;
		}

		@keyframes slide {
			0%{
			
				transform: translateX(200%)
				opacity: 0;
			}
			100%{
				transform: translateX(0);
				opacity: 1;	
			}
		}

		@keyframes fade {
			0%{
			
				transform: scale(1);
				opacity: 1;
			}

			50%{
				transform: scale(.75);
				opacity: 0;
			}

			100%{
				opacity: 0;
				transform: scale(0);
	
			}
		}

		.bendo{
			top: 500px;
			background-color: palevioletred;
			display: flex;
		}
		body{
			display: flex;
			background-color: #ECE0D1;
		}
		
		h1{
			font-size: 36px;
			font-weight: 600;
			padding-left: 46%;
		}

		.button{
			justify-content: center;
			margin-left: 3%;
			padding: 0.4rem;
			width: 7rem;
		}
        </style>
    </head>
	<body>
		<div>
			<?php include("../CnavIn.php")?>
		</div>
		nothing here
		<div class="bendo">

		</div>
		
		<form data-multi-step class="multi-step-form" method="POST">
		<h1>ORDER</h1>
			<div class="frame" data-step>
				<p class="title">Sender Details</p>
				<div class="form-group">
					<label for="name">Name:</label>
					<select class="form-control" name="SName"  id="senderSelect" onchange="this.form.submit()">
						<option value="" disabled>Select Sender Name</option>
						<?php
							$sql = "SELECT * FROM sender";
							$result = mysqli_query($dbCon, $sql);
							while($row = mysqli_fetch_array($result)){
								$senderID = $row['senderID'];
								$senderName = $row['senderName'];
								// Check if this option matches the selected senderID
								$selected = ($senderID == $_POST['SName']) ? 'selected' : '';
								echo "<option value='$senderID' $selected>$senderName</option>";
							}
						?>
					</select>
				</div>
				<?php
					// Assuming form is submitted and $_POST['SName'] contains the selected senderID
					if (isset($_POST['SName'])) {
						$selectedSenderID = $_POST['SName'];
						// Query database to get details of selected sender
						$sql = "SELECT * FROM sender WHERE senderID = $selectedSenderID";
						$result = mysqli_query($dbCon, $sql);
						if ($row = mysqli_fetch_array($result)) {
							$SName = $row['senderName'];
							$SPhone = $row['senderPhoneNo'];
							$SAddress = $row['addressLine1'];
							$SCity = $row['city'];
							$SState = $row['state'];
							$SPostcode = $row['postcode'];
						} else {
							// Handle case where no sender is found with selected ID
							// For example, set default values or show an error message
							$SPhone = '';
							$SAddress = '';
							$SCity = '';
							$SState = '';
							$SPostcode = '';
						}
					} else {
						// Default values when no sender is selected yet
						$SPhone = '';
						$SAddress = '';
						$SCity = '';
						$SState = '';
						$SPostcode = '';
					}
					?>
				<div class="form-group">
					<label for="phone">Phone Number:</label>
					<input class="form-control" type="text" id="SPhone" name="SPhone" value="<?php echo isset($SPhone) ? $SPhone : ''?>" readonly >
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<input class="form-control" type="text" id="SAddress" name="SAddress" value="<?php echo isset($SAddress) ? $SAddress : ''?>"  readonly>
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="city">City:</label>
						<input class="form-control" type="text" id="SCity" name="SCity" value="<?php echo isset($SCity) ? $SCity : ''?>" readonly>
					</div>
					<div class="form-group">
						<label for="state">State:</label>
						<input class="form-control" type="text" id="SState" name="SState" value="<?php echo isset($SState) ? $SState : ''?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="postcode">Postcode:</label>
					<input class="form-control" type="text" name="SPostcode" value="<?php echo isset($SPostcode) ? $SPostcode : ''?>" readonly>
				</div>
				<button type="button" data-next class="button">Next</button>
			</div>

		<!--Recipient Frame-->

			<div class="frame" data-step>
				<p class="title">Recipient Details</p>
				<div class="form-group">
					<label for="name">Name:</label>
					<select class="form-control" type="text" name="RName" id="recipientSelect" onchange="this.form.submit()">
						<option value="" disabled>Select Recipient Name</option>
							<?php
								$sql = "SELECT * FROM recipient";
								$result = mysqli_query($dbCon, $sql);
								while($row = mysqli_fetch_array($result)){
									$recipientID = $row['recipientID'];
									$recipientName = $row['name'];
									// Check if this option matches the selected senderID
									$selected = ($recipientID == $_POST['RName']) ? 'selected' : '';
									echo "<option value='$recipientID' $selected>$recipientName</option>";
								}
							?>
					</select>
				</div>
				<?php
					// Assuming form is submitted and $_POST['RName'] contains the selected recipientID
					if (isset($_POST['RName'])) {
						$selectedRecipientID = $_POST['RName'];
						// Query database to get details of selected recipient
						$sql = "SELECT * FROM recipient WHERE recipientID = $selectedRecipientID";
						$result = mysqli_query($dbCon, $sql);
						if ($row = mysqli_fetch_array($result)) {
							$RName = $row['name'];
							$RPhone = $row['phoneNo'];
							$RAddress = $row['addressLine1'];
							$RCity = $row['city'];
							$RState = $row['state'];
							$RPostcode = $row['postcode'];
						} else {
							// Handle case where no recipient is found with selected ID
							// For example, set default values or show an error message
							$RPhone = '';
							$RAddress = '';
							$RCity = '';
							$RState = '';
							$RPostcode = '';
						}
					} else {
						// Default values when no recipient is selected yet
						$RPhone = '';
						$RAddress = '';
						$RCity = '';
						$RState = '';
						$RPostcode = '';
					}
					?>
				<div class="form-group">
					<label for="phone">Phone Number:</label>
					<input class="form-control" type="text" name="RPhone" value="<?php echo isset($RPhone) ? $RPhone : ''?>" readonly>
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<input class="form-control" type="text" name="RAddress" value="<?php echo isset($RAddress) ? $RAddress : ''?>" readonly>
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="city">City:</label>
						<input class="form-control" type="text" id="city" name="RCity" value="<?php echo isset($RCity) ? $RCity : ''?>" readonly>
					</div>
					<div class="form-group">
						<label for="state">State:</label>
						<input class="form-control" type="text" id="state" name="RState" value="<?php echo isset($RState) ? $RState : ''?>" readonly>
					</div>
				</div>				
				<div class="form-group">
					<label for="postcode">Postcode:</label>
					<input class="form-control" type="text" name="RPostcode" value="<?php echo isset($RPostcode) ? $RPostcode : ''?>" readonly>
				</div>
				<button type="button" data-previous class="button">Previous</button>
				<button type="button" data-next class="button">Next</button>
			</div>


		<!--parcel-->
			<div class="frame" data-step>
				<p class="title">Parcel Details</p>
				<div class="form-group">
					<label for="parcel-weight">Weight (KG)</label><br>
					<input class="form-control" type="text" name="Weight" value="<?php echo isset($Weight) ? $Weight : ''?>"/>
				</div>
				<div class="form-group">
					<label clas="label-details" class="label-details">Description</label><br>
					<textarea cols="50" rows="5" name="Description"></textarea>
				</div>		
				
				<div  class="form-check" style="padding-left:5%;">
					<input type="checkbox" name="insurance" class="form-check-input" justify-content-end><label class="form-check-label">Insurance</label>		
				</div>
				<div class="form-group">
					<label for="shipping-rate">Shipping Rate</label><br>
					<select class="form-control" type="text" name="shippingRate">
						<option value="">Select Shipping Rate</option>
						<?php
							$sql = "SELECT * FROM shipping_rate";
							$result = mysqli_query($dbCon, $sql);
							while($row = mysqli_fetch_array($result)){
								$rateID = $row['shipRateID'];
								$rate = $row['shipRateName'];
								$selected = ($rateID == $_POST['shippingRate']) ? 'selected' : '';
								echo "<option value='$rateID'>$rate</option>";
							}
						?>
					</select>
				</div>
				<button type="button" data-previous class="button">Previous</button>
				<button type="submit" class="button">Submit</button>
				
			</div>
		</form>	
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
			$(document).ready(function() {
			// Handle change event for sender details
			$('#senderSelect').change(function() {
				var senderID = $(this).val();
				if (senderID !== '') {
					$.ajax({
						url: 'getSenderDetails.php',
						type: 'POST',
						data: { senderID: senderID },
						dataType: 'json',
						success: function(response) {
							$('#SPhone').val(response.senderPhoneNo);
							$('#SAddress').val(response.addressLine1);
							$('#SCity').val(response.city);
							$('#SState').val(response.state);
							$('#SPostcode').val(response.postcode);
						},
						error: function(xhr, status, error) {
							console.error('Ajax request failed');
						}
					});
				} else {
					// Clear fields if no sender is selected
					$('#SPhone').val('');
					$('#SAddress').val('');
					$('#SCity').val('');
					$('#SState').val('');
					$('#SPostcode').val('');
				}
			});

			// Handle change event for recipient details
			$('#recipientSelect').change(function() {
				var recipientID = $(this).val();
				if (recipientID !== '') {
					$.ajax({
						url: 'getRecipientDetails.php',
						type: 'POST',
						data: { recipientID: recipientID },
						dataType: 'json',
						success: function(response) {
							$('#RPhone').val(response.phoneNo);
							$('#RAddress').val(response.addressLine1);
							$('#RCity').val(response.city);
							$('#RState').val(response.state);
							$('#RPostcode').val(response.postcode);
						},
						error: function(xhr, status, error) {
							console.error('Ajax request failed');
						}
					});
				} else {
					// Clear fields if no recipient is selected
					$('#RPhone').val('');
					$('#RAddress').val('');
					$('#RCity').val('');
					$('#RState').val('');
					$('#RPostcode').val('');
				}
			});
		});

			const multiStepForm = document.querySelector("[data-multi-step]")
			const formSteps = [...multiStepForm.querySelectorAll("[data-step]")]

			let currentStep = formSteps.findIndex(step=>{
				return step.classList.contains("active")
			})
	
			if(currentStep<0){
				currentStep=0
				showCurrentStep()
			}

			multiStepForm.addEventListener("click", e=> {
				let incrementor
				if(e.target.matches("[data-next]")){
					incrementor = 1
				} else if(e.target.matches("[data-previous]")){
					incrementor = -1
				} 
				
				if(incrementor == null) return

				const inputs = [...formSteps[currentStep].querySelectorAll("input")]
				const allValid = inputs.every(input => input.reportValidity())
				if(allValid){
					currentStep += incrementor
					showCurrentStep()
				}
			})	
			
			formSteps.forEach(step => {
				step.addEventListener("animationend", e => {
					formSteps[currentStep].classList.remove("hide")
					e.target.classList.toggle("hide", !e.target.classList.contains("active"))
				})
			})

			function showCurrentStep(){
				formSteps.forEach((step,index) => {
					step.classList.toggle("active",index === currentStep)
				})
			}
		</script>
    </body>
</html>