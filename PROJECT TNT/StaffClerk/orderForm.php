<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
        <style>
        body {
            margin: 0;
			background-color: #ECE0D1;
        }

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
            height: 50px;
            overflow: hidden;
            background-color: #4b0606;
            font-family: 'Poppins', sans-serif;
            padding: 10px 10px;
            position: fixed;
            width: 100%;
            z-index: 1; /* Added this to make sure the header is above the sidebar */
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
            background-color: #FFFFFF;
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
            background-color: #4b0606;
            color: var(--background);
            width: 350px;
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
		.process-div {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background-color: rgba(75, 6, 6, 0.5);
            z-index: 1;
        }

        .progress {
            position: relative;
            width: 673.9px;
            height: 93px;
            margin: 0 auto;
            text-align: center;
            font-size: 32px;
            color: #414040;
        }


		.circle-1 {
			position: absolute;
			top: 0px;
			left: 0px;
			width: 140.1px;
			height: 93px;
			color: #000;
		}
		.circle-2 {
			position: absolute;
			top: 1.27px;
			left: 282.82px;
			width: 109.6px;
			height: 91.7px;
		}
		.circle-3 {
			position: absolute;
			top: 0px;
			left: 547.81px;
			width: 126.1px;
			height: 93px;
		}

		.cont-1 {
			position: absolute;
			top: 0px;
			left: 38.22px;
			border-radius: 50%;
			border: 3px solid #000;
			box-sizing: border-box;
			width: 63.7px;
			height: 63.7px;
		}
		.cont-2 {
			position: absolute;
			top: 0px;
			left: 22.93px;
			border-radius: 50%;
			border: 3px solid #414040;
			box-sizing: border-box;
			width: 63.7px;
			height: 63.7px;
		}
		.cont-3 {
			position: absolute;
			top: 0px;
			left: 31.85px;
			border-radius: 50%;
			border: 3px solid #414040;
			box-sizing: border-box;
			width: 63.7px;
			height: 63.7px;
		}

		.line-1-2 {
			position: absolute;
			top: 31.78px;
			left: 99.59px;
			border-top: 3px solid #414040;
			box-sizing: border-box;
			width: 208.2px;
			height: 3px;
		}
		.line-2-3 {
			position: absolute;
			top: 30.35px;
			left: 367.95px;
			border-top: 3px solid #414040;
			box-sizing: border-box;
			width: 213.2px;
			height: 3px;
		}

		.order-title{
			font-size: 64px;
			display: flex;
			color: #4b0606;
			text-align: center;
			align-items: center;
			vertical-align: text-top;
			justify-content: center;
			width: 1440px;
			height: 115px;
			padding-left: 30%;
		}

		.payment-title{
			font-size: 64px;
			display: flex;
			color: #4b0606;
			text-align: center;
			align-items: center;
			justify-content: center;
			width: 1440px;
			height: 115px;
			padding-left: 33%;
			padding-top: 7%;

		}

		.parcel-title{
			font-size: 64px;
			display: flex;
			color: #4b0606;
			text-align: center;
			align-items: center;
			justify-content: center;
			width: 1440px;
			height: 115px;
			padding-left: 33%;
			padding-top: 7%;
		}

		.ordering{
			margin-top: 70%;
			top:8%;
		}

		.frame-sender{
			position: absolute;
			top: 270px;
			margin-left: 26%;
			border-radius: 20px;
			border: 3px solid #4b0606;
			box-sizing: border-box;
			width: 1059px;
			height: 651px;
		}
		.frame-recipient{
			position: absolute;
			top: 970px;
			margin-left: 26%;
			border-radius: 20px;
			border: 3px solid #4b0606;
			box-sizing: border-box;
			width: 1059px;
			height: 651px;
		}

		.frame-parcel{
			position: absolute;
			top: 1670px;
			margin-left: 26%;
			padding-bottom: 30px;
			border-radius: 20px;
			border: 3px solid #4b0606;
			box-sizing: border-box;
			width: 1059px;
			height: 501px;
		}
		
		
		.top-details {
			position: absolute;
			font-size: 36px;
			font-weight: 600;
			display: flex;
			align-items: center;
			width: 885px;
			height: 115px;
			padding-left: 5%;
		}

		.fielding-1{
			padding-top: 9%;
			padding-left: 3%;
			padding-right: 3%;
		}
		.fielding-2{
			padding-top: 1%;
			padding-left: 3%;
			padding-right: 3%;
		}
		.fielding-3{
			padding-top: 1%;
			padding-left: 3%;
			padding-right: 3%;
			width: 350px;

		}

		.fielding-4{
			padding-left: 10%;
		}
		
        .form-row {
            display: flex;
            justify-content: space-between;
			padding-left: 3.5%;
			padding-right: 7%;
			padding-top: 1%;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }
		.label-details {
			position: absolute;
			font-weight: 700;
			font-size: 26px;
			display: flex;
			align-items: center;
			width: 269px;
			height: 29px;
			padding-bottom: 1%;
		}

		
        </style>
    </head>
    <body>
		<!--Navigation Part-->
		<div class="header">
			<a href="#default"><img src="../images/tntlogo.png"></a>
			<div class="header-right">
				<a class="opt" href="#about">Logout</a>
			</div>
		</div>
		<label class="hamburger-menu">
			<input type="checkbox" />
		</label>
		<aside class="sidebar">
			<div class="profile">
				<h3>Hi,</h3>
				<h3><?php echo $_SESSION['staffID']; ?></h3>
				<img src="../images/picture.png" alt="Profile Picture">
			</div>
			<nav>
				<ul>
					<li><a href="CProfile.php">Profile</a></li>
					<li><a href="orders.php">Orders</a></li>
					<li><a href="staffList.php">Staff</a></li>
				</ul>
			</nav>
		</aside>
		<!--End of Navigation-->

		<div class="process-div">
			<div class="progress">
				<div class="line-1-2">
				</div>
				<div class="line-2-3">
				</div>
				<div class="circle-1">
					<div class="cont-1">
					</div>
					<b class="b">1</b>
					<b class="order1">ORDER</b>
				</div>
				<div class="circle-2">
					<div class="cont-2">
					</div>
					<b class="b2">2</b>
					<b class="payment">PAYMENT</b>
				</div>
				<div class="circle-3">
					<div class="cont-3">
					</div>
					<b class="b1">3</b>
					<b class="statement">STATEMENT</b>
				</div>
			</div>
		</div>
		<form id="orderForm">
			<ul class="nav nav-tabs" id="orderTabs" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="sender-tab" data-bs-toggle="tab" data-bs-target="#sender-pane" type="button" role="tab" aria-controls="sender-pane" aria-selected="true">Sender</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="recipient-tab" data-bs-toggle="tab" data-bs-target="#recipient-pane" type="button" role="tab" aria-controls="recipient-pane" aria-selected="false">Recipient</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="parcel-tab" data-bs-toggle="tab" data-bs-target="#parcel-pane" type="button" role="tab" aria-controls="parcel-pane" aria-selected="false">Parcel</button>
				</li>
			</ul>
						<!--Tab Content-->
				<div class="tab-content" id="myTabContent">
					<!-- Sender Frame-->
					<div class="tab-pane fade show active" id="sender-pane" role="tabpanel" aria-labelledby="sender-tab">
						<div class="frame-sender">
							<p class="top-details">Sender Details</p>
							<div class="fielding-1">
								<label for="name" class="label-details">Name:</label><br>
								<input class="form-control" type="text" name="name-field" value="<?php echo isset($row1['senderName'])? row1['senderName'] : ''?>" required>
							</div>
							<div class="fielding-2">
								<label for="phone" class="label-details">Phone Number:</label><br>
								<input class="form-control" type="text" name="phone-field" value="<?php echo isset($row1['senderPhoneNo']) ? $row1['senderPhoneNo'] : ''?>" required>
							</div>
							<div class="fielding-2">
								<label for="address" class="label-details">Address:</label><br>
								<input class="form-control" type="text" name="address-field" value="<?php echo isset($row1['addressLine1']) ? $row1['addressLine1'] : ''?>" required>
							</div>
							<div class="form-row">
								<div class="form-group">
									<label for="city" class="label-details">City:</label><br>
									<input class="form-control" type="text" id="city" name="city-field" value="<?php echo isset($row1['city']) ? $row1['city'] : ''?>" required>
								</div>
								<div class="form-group">
									<label for="state" class="label-details">State:</label><br>
									<input class="form-control" type="text" id="state" name="state-field" value="<?php echo isset($row1['state']) ? $row1['state'] : ''?>">
								</div>
							</div>
							<div class="fielding-3">
								<label for="postcode" class="label-details">Postcode:</label><br>
								<input class="form-control" type="text" name="postcode-field" value="<?php echo isset($row1['postcode']) ? $row1['postcode'] : ''?>">
							</div><br>
							<div class="nav-buttons" style="padding-left:3%;">
								<button type="button" id="nextBtn" class="btn btn-primary" onclick="navigate(1)">Next</button>
							</div>
						</div>
					</div>

					<!--Recipient Frame-->
					 <div class="tab-pane fade" id="recipient-pane" role="tabpanel" aria-labelledby="recipient-tab">
						<div class="frame-recipient">
							<p class="top-details">Recipient Details</p>
							<div class="fielding-1">
								<label for="name" class="label-details">Name:</label><br>
								<input class="form-control" type="text" name="Rname-field" value="<?php echo isset($row2['name']) ? $row2['name'] : ''?>">
							</div>
							<div class="fielding-2">
								<label for="phone" class="label-details">Phone Number:</label><br>
								<input class="form-control" type="text" name="Rphone-field" value="<?php echo isset($row2['phoneNo']) ? $row2['phoneNo'] : ''?>">
							</div>
							<div class="fielding-2">
								<label for="address" class="label-details">Address:</label><br>
								<input class="form-control" type="text" name="Raddress-field" value="<?php echo isset($row2['adressLine1']) ? $row2['addressLine1'] : ''?>">
							</div>
							<div class="form-row">
								<div class="form-group">
									<label for="city" class="label-details">City:</label>
									<input class="form-control" type="text" id="city" name="city-field" value="<?php echo isset($row2['city']) ? $row2['city'] : ''?>">
								</div>
								<div class="form-group">
									<label for="state" class="label-details">State:</label>
									<input class="form-control" type="text" id="state" name="state-field" value="<?php echo isset($row2['state']) ? $row2['state'] : ''?>">
								</div>
							</div>				
							<div class="fielding-3">
								<label for="postcode" class="label-details">Postcode:</label><br>
								<input class="form-control" type="text" name="Rpostcode-field" value="<?php echo isset($row2['postcode']) ? $row2['postcode'] : ''?>">
							</div><br>
							<div class="nav-buttons">
								<button type="button" id="prevBtn" class="btn btn-secondary" onclick="navigate(-1)" style="display: none;">Back</button>
								<button type="button" id="nextBtn" class="btn btn-primary" onclick="navigate(1)">Next</button>
							</div>
						</div>
					</div>

					<!--parcel-->
					<div class="tab-pane fade" id="parcel-pane" role="tabpanel" aria-labelledby="parcel-tab">
						<div class="frame-parcel">
							<p class="top-details">Parcel Details</p>
							<div class="fielding-1">
								<label for="parcel-weight" class="label-details">Weight (KG)</label><br>
								<input class="form-control" type="text" name="PWeight-field" value="<?php echo isset($row3['parcelWeight']) ? $row3['parcelWeight'] : ''?>"/>
							</div>
							<div class="fielding-2">
								<label clas="label-details" class="label-details">Description</label><br>
								<textarea cols="50" rows="5"></textarea><br><br>
							</div>					
							<div class="d-grid gap-2 d-md-flex justify-content-md-start" style="padding-left:2%;">
								<button type="button" id="prevBtn" class="btn btn-secondary" onclick="navigate(-1)" style="display: none;">Back</button>
								<button type="button" id="submitBtn" class="btn btn-primary">Submit Order</button>
							</div>
						</div>
					</div>
				</div>
			</form>	
    </body>
</html>