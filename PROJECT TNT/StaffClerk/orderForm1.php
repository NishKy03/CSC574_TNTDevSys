<!DOCTYPE html>
<html>
    <head>
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
        </style>
    </head>
	<body>
		<div>
			<?php include("../CnavIn.php")?>
		</div>
		nothing here
		<div class="bendo">

		</div>
		
		<form data-multi-step class="multi-step-form">
		<h1>ORDER</h1>
			<div class="frame" data-step>
				<p class="title">Sender Details</p>
				<div class="form-group">
					<label for="name">Name:</label>
					<input class="form-control" type="text" name="name-field" value="<?php echo isset($row1['senderName'])? row1['senderName'] : ''?>" >
				</div>
				<div class="form-group">
					<label for="phone">Phone Number:</label>
					<input class="form-control" type="text" name="phone-field" value="<?php echo isset($row1['senderPhoneNo']) ? $row1['senderPhoneNo'] : ''?>" >
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<input class="form-control" type="text" name="address-field" value="<?php echo isset($row1['addressLine1']) ? $row1['addressLine1'] : ''?>" >
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="city">City:</label>
						<input class="form-control" type="text" id="city" name="city-field" value="<?php echo isset($row1['city']) ? $row1['city'] : ''?>">
					</div>
					<div class="form-group">
						<label for="state">State:</label>
						<input class="form-control" type="text" id="state" name="state-field" value="<?php echo isset($row1['state']) ? $row1['state'] : ''?>">
					</div>
				</div>
				<div class="form-group">
					<label for="postcode">Postcode:</label>
					<input class="form-control" type="text" name="postcode-field" value="<?php echo isset($row1['postcode']) ? $row1['postcode'] : ''?>">
				</div>
				<button type="button" data-next>Next</button>
			</div>

		<!--Recipient Frame-->

			<div class="frame" data-step>
				<p class="title">Recipient Details</p>
				<div class="form-group">
					<label for="name">Name:</label>
					<input class="form-control" type="text" name="Rname-field" value="<?php echo isset($row2['name']) ? $row2['name'] : ''?>">
				</div>
				<div class="form-group">
					<label for="phone">Phone Number:</label>
					<input class="form-control" type="text" name="Rphone-field" value="<?php echo isset($row2['phoneNo']) ? $row2['phoneNo'] : ''?>">
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<input class="form-control" type="text" name="Raddress-field" value="<?php echo isset($row2['adressLine1']) ? $row2['addressLine1'] : ''?>">
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="city">City:</label>
						<input class="form-control" type="text" id="city" name="city-field" value="<?php echo isset($row2['city']) ? $row2['city'] : ''?>">
					</div>
					<div class="form-group">
						<label for="state">State:</label>
						<input class="form-control" type="text" id="state" name="state-field" value="<?php echo isset($row2['state']) ? $row2['state'] : ''?>">
					</div>
				</div>				
				<div class="form-group">
					<label for="postcode">Postcode:</label>
					<input class="form-control" type="text" name="Rpostcode-field" value="<?php echo isset($row2['postcode']) ? $row2['postcode'] : ''?>">
				</div>
				<button type="button" data-previous>Previous</button>
				<button type="button" data-next>Next</button>
			</div>


		<!--parcel-->
			<div class="frame" data-step>
				<p class="title">Parcel Details</p>
				<div class="form-group">
					<label for="parcel-weight">Weight (KG)</label><br>
					<input class="form-control" type="text" name="PWeight-field" value="<?php echo isset($row3['parcelWeight']) ? $row3['parcelWeight'] : ''?>"/>
				</div>
				<div class="form-group">
					<label clas="label-details" class="label-details">Description</label><br>
					<textarea cols="50" rows="5"></textarea>
				</div>		
				<button type="button" data-previous>Previous</button>
				<button type="submit">Submit</button>			
			</div>
		</form>	
		

		<script>
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