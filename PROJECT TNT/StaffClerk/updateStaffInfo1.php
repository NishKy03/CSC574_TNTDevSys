<?php
$staffName = "DANISH";
	
?>

<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="initial-scale=1, width=device-width">
  	
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  	<style>
 
body {
  	margin: 0;
  	line-height: normal;
}

        .update-staff-info-child {
  	position: absolute;
  	top: 0px;
  	left: 0px;
  	background-color: #4b0606;
  	width: 273px;
  	height: 1080px;
}
.update-staff-info-item {
  	position: absolute;
  	top: 232px;
  	left: 35px;
  	border-radius: 50%;
  	width: 200px;
  	height: 200px;
  	object-fit: cover;
}
.hi {
  	margin: 0;
}
.hi-lee-chin-container {
  	position: absolute;
  	top: 141px;
  	left: 44px;
  	font-size: 24px;
  	display: inline-block;
  	width: 191px;
  	height: 84px;
}
.update-staff-info-inner {
  	position: absolute;
  	top: 575px;
  	left: 0px;
  	background-color: #7a5961;
  	width: 273px;
  	height: 57px;
}
.profile {
  	position: absolute;
  	top: 466px;
  	left: 44px;
  	display: inline-block;
  	width: 200px;
  	height: 47px;
}
.staff {
  	position: absolute;
  	top: 580px;
  	left: 44px;
  	display: inline-block;
  	width: 200px;
  	height: 47px;
}
.orders {
  	position: absolute;
  	top: 523px;
  	left: 44px;
  	display: inline-block;
  	width: 200px;
  	height: 47px;
}
.navi {
  	position: absolute;
  	top: 0px;
  	left: 0px;
  	background-color: #4b0606;
  	width: 1920px;
  	height: 98px;
}
.company-logo {
  	position: absolute;
  	top: 0px;
  	left: 98px;
  	width: 196px;
  	height: 98px;
  	object-fit: cover;
}
.menubar-icon {
  	position: absolute;
  	top: 38px;
  	left: 32px;
  	width: 34px;
  	height: 22px;
}
.rectangle-div {
  	position: absolute;
  	top: 183px;
  	left: 494px;
  	border-radius: 20px;
  	background-color: rgba(75, 6, 6, 0.5);
  	width: 1197px;
  	height: 797px;
}
.staff-info {
  	position: absolute;
  	top: 204px;
  	left: 494px;
  	font-size: 64px;
  	display: flex;
  	text-align: center;
  	align-items: center;
  	justify-content: center;
  	width: 1197px;
  	height: 130px;
}
.id {
  	position: absolute;
  	top: 305px;
  	left: 616px;
  	font-size: 24px;
  	display: flex;
  	font-family: Roboto;
  	align-items: center;
  	width: 197px;
  	height: 32px;
}
.name-field {
  	position: absolute;
  	top: 442px;
  	left: 590px;
	padding-left: 20px;
	font-size: 20px;
  	font-weight: 300;
  	border-radius: 20px;
  	background-color: #fff;
  	width: 1005px;
  	height: 55px;
}
.name {
  	position: absolute;
  	top: 409px;
  	left: 616px;
  	font-size: 24px;
  	display: flex;
  	font-family: Roboto;
  	align-items: center;
  	width: 304px;
  	height: 33px;
}
.phone-field {
  	position: absolute;
  	top: 544px;
  	left: 590px;
	padding-left: 20px;
	font-size: 20px;
  	font-weight: 300;
  	border-radius: 20px;
  	background-color: #fff;
  	width: 1005px;
  	height: 54px;
}
.phone-number {
  	position: absolute;
  	top: 502px;
  	left: 616px;
  	font-size: 24px;
  	display: flex;
  	font-family: Roboto;
  	align-items: center;
  	width: 530px;
  	height: 42px;
}
.email-field {
  	position: absolute;
  	top: 639px;
  	left: 590px;
	padding-left: 20px;
	font-size: 20px;
  	font-weight: 300;
  	border-radius: 20px;
  	background-color: #fff;
  	width: 1005px;
  	height: 55px;
}
.position-field {
  	position: absolute;
  	top: 743px;
  	left: 590px;
	padding-left: 20px;
	font-size: 20px;
  	font-weight: 300;
  	border-radius: 20px;
  	background-color: #fff;
  	width: 465px;
  	height: 55px;
}
.update-staff-info-child5 {
	position: absolute;
  	top: 338px;
  	left: 590px;
	font-size: 20px;
  	font-weight: 300;
	border: transparent;
  	border-radius: 20px;
  	background-color: transparent;
  	width: 465px;
  	height: 55px;
}
.email {
  	position: absolute;
  	top: 602px;
  	left: 616px;
  	font-size: 24px;
  	display: flex;
  	font-family: Roboto;
  	align-items: center;
  	width: 304px;
  	height: 33px;
}
.position {
  	position: absolute;
  	top: 708px;
  	left: 616px;
	padding-left: 20px;
  	font-size: 24px;
  	display: flex;
  	font-family: Roboto;
  	align-items: center;
  	width: 304px;
  	height: 32px;
}
.id-val {
	width: 225px;
	position: relative;
	font-size: 32px;
	display: flex;
	padding-left: 20px;
	border: transparent;
  	border-radius: 20px;
	font-family: Poppins;
	color: #000;
	text-align: left;
	align-items: center;
	height: 55px;
}
.lee-chin1 {
  	position: absolute;
  	top: 442px;
  	left: 616px;
  	display: flex;
  	color: #000;
  	align-items: center;
  	width: 225px;
  	height: 54px;
}
.b {
  	position: absolute;
  	top: 544px;
  	left: 616px;
  	display: flex;
  	color: #000;
  	align-items: center;
  	width: 343px;
  	height: 54px;
}
.clerk {
  	position: absolute;
  	top: 744px;
  	left: 616px;
  	display: flex;
  	color: #000;
  	align-items: center;
    width: 343px;
    height: 54px;
    }
.leechin97gmailcom {
position: absolute;
top: 640px;
left: 616px;
font-weight: 700;
color: #000;
display: flex;
align-items: center;
width: 475px;
height: 54px;
text-decoration: none;
}
.login-child {
position: absolute;
top: 0px;
left: 6.08px;
border-radius: 10px;
background-color: #b45858;
width: 276.2px;
height: 81.4px;
}
.update {
position: absolute;
top: 11.3px;
left: 0px;
display: flex;
align-items: center;
justify-content: center;
width: 287.1px;
height: 59.9px;
}
.login {
position: absolute;
top: 833.04px;
left: 1307.96px;
box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
width: 287.1px;
height: 81.4px;
text-align: center;
font-size: 48px;
font-family: Roboto;
}
.list {
position: absolute;
top: 637px;
left: 66px;
display: inline-block;
width: 200px;
height: 47px;
}
.register {
position: absolute;
top: 689px;
left: 66px;
color: rgba(255, 255, 255, 0.29);
display: inline-block;
width: 200px;
height: 47px;
}
.chevron-icon {
position: absolute;
height: 1.39%;
width: 1.56%;
top: 74.35%;
right: 30.89%;
bottom: 24.26%;
left: 67.55%;
max-width: 100%;
overflow: hidden;
max-height: 100%;
}
.home {
position: absolute;
top: 23px;
left: 1521px;
font-size: 40px;
display: inline-block;
font-family: Roboto;
text-align: center;
width: 144px;
height: 51px;
}
.log-out {
position: absolute;
top: 23px;
left: 1691px;
font-size: 40px;
display: inline-block;
font-family: Roboto;
text-align: center;
width: 191px;
height: 51px;
}
.vector-icon {
position: absolute;
top: 211px;
left: 1614px;
width: 43px;
height: 41px;
}
.update-staff-info {
width: 100%;
position: relative;
background-color: #ece0d1;
height: 1080px;
overflow: hidden;
text-align: left;
font-size: 32px;
color: #fff;
font-family: Poppins;
}

.tntlogo{
	width: 100px;
	height: 50px;

}
</style>
</head>
<body>

	<nav class="navbar bg-body-tertiary">
		<div class="container-fluid">
			<div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
				<div class="bg-dark p-4">
					<h5 class="text-body-emphasis h4">Collapsed content</h5>
					<span class="text-body-secondary" Toggleable via the brand.></span>
				</div>
			</div>
			<div class="btn-group" role="group" aria-label="Basic outlined example">
				<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="btn btn-tertiary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
					<img class="tntlogo" src="../images/tntlogo.png">
				</a>
			</div>
			
			
			<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
				<div class="offcanvas-header">
					<h5 class="offcanvas-title" id="offcanvasNavbarLabel">Welcome <?php echo $staffName?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Orders</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Staff
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#">Register Staff</a></li>
								<hr class="dropdown-divider">
								<li><a class="dropdown-item" href="#">Staff List</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<span class="navbar-text">
				<a href="#">Home</a>
				<a href="#">Logout</a>
			</span>
		</div>
	</nav>

	<div class="container">
		<h2>Update Staff Information</h2>
		<form method="POST" action="upateStaffInfo1.php">
			<input type="hidden" name="staffID" value="<?php echo isset($row['staffID']) ? $row['staffID']: ""; ?>">
			
			<div class="mb-3">
				<label for="staffName" class="form-label">Name: </label>
				<input type="text" class="form-control" id="staffName" name="staffName" value="<?php echo isset($row['staffName']) ? $row['staffName'] : "" ; ?>" required>
			</div>
			<div class="mb-3">
				<label for="phoneNo" class="form-label">Phone No: </label>
				<input type="text" class="form-control" id="staffPhoneNo" name="staffPhoneNo" value="<?php echo isset($row['staffPhoneNo']) ? $row['staffPhoneNo'] : "" ; ?>" required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email: </label>
				<input type="text" class="form-control" id="email" name="email" value="<?php echo isset($row['staffEmail']) ? $row['staffEmail'] : "" ; ?>" required>
			</div>
			<div class="mb-3">
				<label for="position" class="form-label">Position: </label>
				<select class="form-control" id="position" name="position" required>
					<?php	
						$conn = new mysqli("localhost","root","","tntdb");
						if($conn->connect_error){
							die("Connection Failed: " . $conn->connect_error);
						}

						$sql = "SELECT position FROM staff";
						$result = $conn -> query($sql);
						
						while($staff = $result->fetch_assoc()){
							$selected = (isset($row['position']) && $row['poisition'] == $staff['position']) ? 'selected' : '';
							echo "<option value = '" .htmlspecialchars($staff['position']) . "' $selected>" . htmlspecialchars($staff['position']) . "</option>";
						}

						$conn->close();
					?>
				</select>
			</div>
			<div class="mb-3">
				<label for="branchID" class="form-label">Branch ID: </label>
				<select class="form-control" id="branchID" name="branchID" required>
					<?php	
						$conn = new mysqli("localhost","root","","tntdb");
						if($conn->connect_error){
							die("Connection Failed: " . $conn->connect_error);
						}

						$sql = "SELECT branchID FROM branch";
						$result = $conn -> query($sql);
						
						while($staff = $result->fetch_assoc()){
							$selected = (isset($row['branchID']) && $row['branchID'] == $staff['branchID']) ? 'selected' : '';
							echo "<option value = '" .htmlspecialchars($staff['branchID']) . "' $selected>" . htmlspecialchars($staff['branchID']) . "</option>";
						}

						$conn->close();
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Update Staff</button>
		</form>
	</div>
	
    <!-- <div class="update-staff-info">
		<div class="update-staff-info-child">
		</div>
		<img class="update-staff-info-item" alt="" src="Ellipse 5.png">
		
		<b class="hi-lee-chin-container">
  			<p class="hi">Hi,</p>
  			<p class="hi">LEE CHIN</p>
		</b>
		<div class="update-staff-info-inner">
		</div>
		<div class="profile">
  			<p class="hi">Profile</p>
		</div>
		<div class="staff">Staff</div>
		<div class="orders">Orders</div>
		<div class="navi">
		</div>
		<img class="company-logo" alt="" src="tnt.png">
		
		<img class="menubar-icon" alt="" src="menubar.png">
		
		<form action="staff.html" method="POST">
			<div class="rectangle-div">
			</div>
			<b class="staff-info">STAFF INFO</b>
			<b class="id">ID</b>
			<div class="update-staff-info-child5">
				<select  class="id-val" type="text" placeholder="Enter ID" name="staffid">
					<option>10001</option>
					<option>10002</option>
					<option>10003</option>
					<option>10004</option>
					<option>10005</option>
				</select>
			</div>
			<div class="mb-3">
			<span class="input-group-text" id="inputGroup-sizing-default">Default</span>
			<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
			</div>

			<b class="name">Name</b>
			<div>
				<input class="name-field" type="text" placeholder="Enter Name">
			</div>
			<b class="phone-number">Phone Number</b>
			<div>
				<input class="phone-field" type="text" placeholder="Enter Phone Number">
			</div>
			<b class="email">Email</b>
			<div>
				<input class="email-field" type="text" placeholder="Enter Email">
			</div>
			<b class="position">Position</b>
			<div>
				<select class="position-field" type="text" placeholder="Enter Position" name="position">
					<option value="regular">Regular Staff</option>
					<option value="delivery">Delivery Staff</option>
				</select>
			</div>
			<div class="login">
				  <input type="submit" class="login-child" class="update" value="UPDATE">
			</div>
		</form>
		
		<div class="list"><a href="staff.html">&gt; List</a></div>
		<div class="register"><a href="RegisterStaff.html">&gt; Register</a></div>
		<img class="chevron-icon" alt="" src="Chevron.svg">
        <b class="home"><a href="">HOME</a></b>
		<b class="log-out"><a href=""></a>LOG OUT</b>
		<img class="vector-icon" alt="" src="Vector.svg">
</div> -->
</body>
</html>
