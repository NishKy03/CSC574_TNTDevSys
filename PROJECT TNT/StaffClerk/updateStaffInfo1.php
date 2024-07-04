<?php
include("dbConfig.php");


session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: ../Home/login.php");
	exit;
}

$username = $_SESSION["staffID"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$staffID = $_POST['staffID'];
	$staffName = $_POST['staffName'];
	$staffPhoneNo = $_POST['staffPhoneNo'];
	$staffEmail = $_POST['staffEmail'];
	$position = $_POST['position'];
	$branchID = $_POST['branchID'];

	$sql = "UPDATE staff SET
			staffName = $staffName, staffPhoneNo = $staffPhoneNo, staffEmail = $staffEmail, position=$position, branchID = $branchID
			WHERE staffID = $staffID";

			if($conn->query($sql) === TRUE){
				echo "<div class='alert alert-success'>Record upated successfully</div>";
			} else{
				echo "<div class='alert alert-danger'>Error updating reocrd: " . $conn->error > "</div>";
			}

			$conn->close();
} else{
	if(isset($_GET['id'])){
		$staffID = $_GET['id'];
		$sql = "SELECT * FROM staff WHERE staffID = '$staffID'";
		$result = $conn->query($sql);

		if($result->num_rows>0){
			$row = $result->fetch_assoc();
		} else{
			echo "<div class='alert alert-danger'>Staff did not found.</div>";
			exit;
		} 
	} else {
		echo "<div class='alert alert-danger'>Staff ID not provided. </div>";
		exit;
	}
}
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
	padding:0;
	background-color: #ECE0D1;

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

.container-fluid{
    
	background: #4B0606;
}
.navbar {
    padding: 0; /* Ensure navbar itself has no padding */
}

.navbar-button{
	background-color: transparent;
	border:none;
	color: white;
}

.update-form-container{
	background:#CEA66080;
	height: 600px;
	width:1200px;
	padding: 2%;
	margin:6%;
	border-radius: 6%;
}
</style>
</head>
<body>

	<nav class="navbar bg-body-tertiary sticky-top">
		<div class="container-fluid">
			<div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
				<div class="bg-dark p-4">
					<h5 class="text-body-emphasis h4">Collapsed content</h5>
					<span class="text-body-secondary" Toggleable via the brand.></span>
				</div>
			</div>
			<div class="btn-group" role="group" aria-label="Basic outlined example">
				<button class="navbar-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
					<span class="navbar-toggler"><img style="height:20px; width:30px; dark" src="menubar.png"></span>
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
			<ul class="nav justify-content-end">
				<li class="nav-item">
					<a class="nav-link disabled" aria-disabled="true">Welcome <?php echo isset($row['staffName']) ? $row['staffName'] : "" ; ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="#">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#"><img style="height:30px; width:40px; dark" src="https://s3-alpha-sig.figma.com/img/7474/d914/25d81f8e0ad6f9ab3656fb0111aa2227?Expires=1720396800&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=WOR-xsWA5ji0F~GkaPHW2Ti5VJ6ki56A1w2a-UD3ZEWVjnOovapEDuotwuhn5c9~QJLbGJWLTOTfTg~gx2isNuWX3WejRw5q4sC4NAQK-FbOd6QZGaznXBwj6Fds0G7BmgzWhS4PYR4mtsfI1DbOmGTVv5WIGZjlfP0UPXFEiPNYXYAja2PvcjvBQIgmHF15G-PwMqDqKvUOCipy8K45ak1w93K36REzQ6t-TGmA5tKQ-of8JQAv1iySwrRBl1fY9F-mc6S8I035NljJ~ZKg8qWU6NlricBJEpTvP3ccBUllD4V1xD5mr~cuNQRkWDeAUOyZ9iegsNmoKfER4g1oCw__"></a>
				</li>
			</ul>
		</div>
	</nav>
	<br><br>
	<div class="container">
		<div class="update-form-container">
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
					<option value="Regular Staff">Regular Staff</option>
					<option value="Delivery Staff">Delivery Staff</option>
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
			<br>
			<button type="submit" class="btn btn-primary">Update Staff</button>
		</form>
		</div>	
	</div>
</body>
</html>
