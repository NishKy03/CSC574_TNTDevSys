<?php
include("../dbConfig.php");
// session_start();

// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["userlevel"] !== '1') {
//     header("location: login.php");
//     exit;
// }

// $username = $_SESSION["username"];

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Query to get total number of records
$countQuery = "SELECT COUNT(*) AS total FROM staff";
$countResult = $conn->query($countQuery);
$countRow = $countResult->fetch_assoc();
$totalRecords = $countRow['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $limit);

// Retrieve staff data for the current page
$sql = "SELECT * FROM staff LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="initial-scale=1, width=device-width">
  	
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" />
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" />
  	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  	<style>
        
    body {
    margin: 0%;
	padding: 0%;
    line-height: normal;
	background-color: #ECE0D1;
    }

        .images2-1-icon {
  	position: absolute;
  	top: 98px;
  	left: 273px;
  	width: 1647px;
  	height: 982px;
  	object-fit: cover;
}
.staff-child {
  	position: absolute;
  	top: 0px;
  	left: 0px;
  	background-color: #4b0606;
  	width: 273px;
  	height: 1080px;
}
.staff-item {
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
.staff-inner {
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
.staff1 {
  	position: absolute;
  	top: 580px;
  	left: 44px;
  	display: inline-block;
  	width: 200px;
  	height: 47px;
}
.register {
  	position: absolute;
  	top: 689px;
  	left: 63px;
  	color: rgba(255, 255, 255, 0.29);
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
.staff2 {
  	position: absolute;
  	top: 119px;
  	left: 448px;
  	font-size: 64px;
  	font-weight: 900;
  	color: #38040e;
  	text-align: center;
  	display: inline-block;
  	width: 1295px;
  	height: 83px;
}
.group-child {
  	position: absolute;
  	top: 1px;
  	left: 0px;
  	width: 31px;
  	height: 31px;
}
.group-item {
  	position: absolute;
  	top: 0px;
  	left: 44px;
  	width: 31px;
  	height: 31px;
}
.group-parent {
  	position: absolute;
  	top: 454px;
  	left: 1275px;
  	width: 75px;
  	height: 32px;
}
.group-container {
  	position: absolute;
  	top: 530px;
  	left: 1275px;
  	width: 75px;
  	height: 32px;
}
.rectangle-div {
  	position: absolute;
  	top: 0px;
  	left: 0px;
  	border-radius: 15px;
  	background-color: #af4a4a;
  	width: 1105.2px;
  	height: 347.3px;
}
.rectangle-icon {
  	position: absolute;
  	top: 45.5px;
  	left: 51.05px;
  	width: 249.7px;
  	height: 249.7px;
  	object-fit: cover;
}
.name-abdullah-phone-container {
  	position: absolute;
  	top: 120.96px;
  	left: 329.58px;
  	letter-spacing: -0.02em;
  	line-height: 150%;
  	display: inline-block;
  	width: 705.8px;
  	height: 175.3px;
}
.id-t00187546 {
  	position: absolute;
  	top: 45.5px;
  	left: 329.58px;
  	font-size: 48px;
  	letter-spacing: -0.02em;
  	line-height: 150%;
  	display: inline-block;
  	width: 467.2px;
  	height: 105.4px;
}
.image-1-icon {
  	position: absolute;
  	top: 134.27px;
  	left: 873.32px;
  	width: 177.5px;
  	height: 73.2px;
  	object-fit: cover;
}
.rectangle-parent {
  	position: absolute;
  	top: 244.39px;
  	left: 543.43px;
  	box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  	width: 1105.2px;
  	height: 347.3px;
  	font-size: 26px;
  	color: #ece0d1;
}
.name-danish-phone-container {
  	position: absolute;
  	top: 123.17px;
  	left: 329.58px;
  	letter-spacing: -0.02em;
  	line-height: 150%;
  	display: inline-block;
  	width: 705.8px;
  	height: 172px;
}
.image-1-icon1 {
  	position: absolute;
  	top: 137.6px;
  	left: 873.32px;
  	width: 177.5px;
  	height: 73.2px;
  	object-fit: cover;
}
.rectangle-group {
  	position: absolute;
  	top: 658.31px;
  	left: 543.43px;
  	box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  	width: 1105.2px;
  	height: 347.3px;
  	font-size: 26px;
  	color: #ece0d1;
}
.list {
  	position: absolute;
  	top: 637px;
  	left: 63px;
  	display: inline-block;
  	width: 200px;
  	height: 47px;
}
.home {
  	position: absolute;
  	top: 23px;
  	left: 1506px;
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
  	left: 1676px;
  	font-size: 40px;
  	display: inline-block;
  	font-family: Roboto;
  	text-align: center;
  	width: 191px;
  	height: 51px;
}
.staff {
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

.profile-image{
	width:200px;
	height:250px;
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

.table table-striped{
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
			
			
			<div class="offcanvas offcanvas-start" style="background: #4B0606;" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
				<div class="offcanvas-header">
					<h5 class="offcanvas-title" id="offcanvasNavbarLabel">Welcome <?php echo $staffName?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="#">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Orders</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle active" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Staff
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="RegisterStaff.php">Register Staff</a></li>
								<hr class="dropdown-divider">
								<li><a class="dropdown-item active" href="#">Staff List</a></li>
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

	<div class="container mt-5">
    <h2>Staff Lists</h2>
    <button class="btn btn-warning" onclick="location.href='RegisterStaff.php'">Register Staff</button><br><br>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<table class="table table-striped">';
            echo '<tbody>';
            echo '<tr>';
            echo '<td style="vertical-align: top;"><img class="profile-image" src="../images/picture.png"></td>';
            echo '<td style="vertical-align: middle; ">';
            echo '<table>';
            echo '<tr><td>ID:</td><td>' . $row["staffID"] . '</td></tr>';
            echo '<tr><td>Name:</td><td>' . $row["staffName"] . '</td></tr>';
            echo '<tr><td>Phone Number:</td><td>' . $row["staffPhoneNo"] . '</td></tr>';
            echo '<tr><td>Email:</td><td>' . $row["staffEmail"] . '</td></tr>';
            echo '<tr><td>Position:</td><td>' . $row["position"] . '</td></tr>';
            echo '</table>';
            echo '</td>';
            echo '<td style="vertical-align: middle;">';
            echo '<button class="btn btn-tertiary me-2" onclick="location.href=\'updateStaffInfo1.php?id=' . $row["staffID"] . '\'"><img src="edit.png"></button>';
            echo '<button class="btn btn-tertiary me-2" onclick="location.href=\'deleteStaff.php?id=' . $row["staffID"] . '\'"><img src="delete.png"></button>';
            echo '</td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
        }
    } else {
        echo "0 results";
    }
    ?>

    <nav aria-label="Page navigation middle">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</body>
</html>