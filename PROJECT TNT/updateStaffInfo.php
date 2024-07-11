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
    echo '<div class="access-denied">Access Denied. Only accessible by courier staff.</div>';
    exit();
}

$username = $_SESSION["staffName"]; // Use the correct session variable to display the username

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$staffID = $_POST['staffID'];
	$staffName = $_POST['staffName'];
	$staffPhoneNo = $_POST['staffPhoneNo'];
	$position = $_POST['position'];
	$branchID = $_POST['branchID'];

	$sql = "UPDATE staff SET
    staffName = '$staffName', staffPhone = '$staffPhoneNo', position = '$position', branchID = '$branchID'
    WHERE staffID = $staffID";


			if($dbCon->query($sql) === TRUE){
				echo "<script>alert('Update Record Successful'); window.location.href='staffList.php'</script>";
	
			} else{
				echo "<div class='alert alert-danger'>Error updating reocrd: " . $dbCon->error > "</div>";
			}

} else{
	if(isset($_GET['id'])){
		$staffID = $_GET['id'];
		$sql = "SELECT * FROM staff WHERE staffID = '$staffID'";
		$result = $dbCon->query($sql);

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
	background: rgba(75, 6, 6, 0.5);
	height: 600px;
	width:1200px;
	padding: 2%;
	margin-top: 18%;
	margin-right: 18%;
	border-radius: 1rem;
}

		.button-confirm button {
            width: 20%;
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
            background-color: #a73f3f;
        }
</style>
</head>
<body>
	<?php include('CHeader.php') ?>
	<div class="container">
		<div class="update-form-container">
		<h2>Update Staff Information</h2>
		<form method="POST" action="updateStaffInfo.php">
			<input type="hidden" name="staffID" value="<?php echo isset($row['staffID']) ? $row['staffID']: ""; ?>">
			
			<div class="mb-3">
				<label for="staffName" class="form-label">Name: </label>
				<input type="text" class="form-control" id="staffName" name="staffName" value="<?php echo isset($row['staffName']) ? $row['staffName'] : "" ; ?>" required>
			</div>
			<div class="mb-3">
				<label for="phoneNo" class="form-label">Phone No: </label>
				<input type="text" class="form-control" id="staffPhoneNo" name="staffPhoneNo" value="<?php echo isset($row['staffPhone']) ? $row['staffPhone'] : "" ; ?>" required>
			</div>
			<div class="mb-3">
				<label for="position" class="form-label">Position: </label>
				<select class="form-control" id="position" name="position" required>
					<option value="staff">Staff</option>
					<option value="courier">Courier</option>
				</select>
			</div>
			<div class="mb-3">
				<label for="branchID" class="form-label">Branch ID: </label>
				<select class="form-control" id="branchID" name="branchID" required>
					<?php	
						$dbCon = new mysqli("localhost","root","","courierdb");
						if($dbCon->connect_error){
							die("Connection Failed: " . $dbCon->connect_error);
						}

						$sql = "SELECT branchID FROM branch";
						$result = $dbCon -> query($sql);
						
						while($staff = $result->fetch_assoc()){
							$selected = (isset($row['branchID']) && $row['branchID'] == $staff['branchID']) ? 'selected' : '';
							echo "<option value = '" .htmlspecialchars($staff['branchID']) . "' $selected>" . htmlspecialchars($staff['branchID']) . "</option>";
						}

						$dbCon->close();
					?>
				</select>
			</div>
			<br>
			<div class="button-confirm">
                <button type="submit">SUBMIT</button>
            </div>
		</form>
		</div>	
	</div>
</body>
</html>