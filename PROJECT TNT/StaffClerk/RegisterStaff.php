<?php
require_once("../dbConfig.php");

$message = "";
$name = $phone = $email = $position = $password = $confirm_password = "";
$name_err = $phone_err = $email_err = $position_err = $password_err = $confirm_password_err = "";

// Fetch the next staffID
$nextStaffID = 2000001; // Default if there are no staff records
$sql = "SELECT MAX(staffID) AS maxStaffID FROM STAFF";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row['maxStaffID']) {
        $nextStaffID = $row['maxStaffID'] + 1;
    }
}

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate phone
    if (empty(trim($_POST["phone-number"]))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST["phoneNumber"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate position
    if (empty(trim($_POST["position"]))) {
        $position_err = "Please select a position.";
    } else {
        $position = trim($_POST["position"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password and confirm password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($phone_err) && empty($email_err) && empty($position_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO STAFF (staffID, password, staffName, staffPhoneNo, staffEmail, position) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isssss", $param_staffID, $param_password, $param_name, $param_phone, $param_email, $param_position);
            $param_staffID = $nextStaffID;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password
            $param_name = $name;
            $param_phone = $phone;
            $param_email = $email;
            $param_position = $position;

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Successfully created a new staff');</script>";
                echo "<script>location.href='login.php';</script>";
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
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
            line-height: normal;
            font-family: 'Poppins', sans-serif;
            background-color: #ece0d1;
        }

        .sidebar {
            background-color: #4b0606;
            height: 100vh;
        }

        .sidebar .profile-section img {
            border-radius: 50%;
        }

        .sidebar .nav-link {
            font-size: 1.5rem;
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: #7a5961;
        }

        .main-content {
            background-color: rgba(75, 6, 6, 0.5);
            border-radius: 20px;
            padding: 30px;
            margin-top: 150px;
        }

        .header {
            background-color: #4b0606;
            padding: 10px;
        }

        .header .company-logo {
            height: 98px;
        }

        .header .menu-icon {
            height: 34px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 20px;
            font-size: 1.2rem;
            padding: 10px;
        }

        .btn-register {
            background-color: #b45858;
            border-radius: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 15px 30px;
        }

        .nav-item {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            

            <!-- Main content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <!-- Header -->
                <div class="header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                            <img src="menubar.png" alt="Menu Icon" class="menu-icon mr-3">
                        </button>
                        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
                            <div class="offcanvas-header">
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <nav class="d-none d-md-block bg-red sidebar">
                                    <div class="profile-section text-center py-4">
                                        <img src="../images/picture.png" alt="Profile Image" class="img-fluid">
                                        <h4 class="text-white mt-3">LEE CHIN</h4>
                                    </div>
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="list-group-item list-group-item-action" href="myProfileStaff.php">Profile</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Staff</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="RegisterStaff.php">Register</a></li>
                                                    <li><a class="dropdown-item" href="staffList.php">Staff List</a></li>
                                                </ul>
                                            </li>
                                            <li class="nav-item">
                                                <a class="list-group-item list-group-item-action" href="orders.php">Orders</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <img src="../images/take-away.png" alt="Company Logo" class="company-logo">
                    </div>
                </div>

                <div class="main-content">
                    <h2 class="text-center text-white">Register Staff</h2>
                    <form action="RegisterStaff.php" method="POST">
                        <div class="form-group">
                            <label for="name" class="text-white">Name:</label>
                            <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $name; ?>" required>
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone-number" class="text-white">Phone Number:</label>
                            <input type="tel" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" id="phoneNumber" name="phone-number" value="<?php echo $phone; ?>" required>
                            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-white">Email:</label>
                            <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" required>
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="position" class="text-white">Position:</label>
                            <select class="form-control <?php echo (!empty($position_err)) ? 'is-invalid' : ''; ?>" id="position" name="position" required>
                                <option value="Manager" <?php echo ($position == "Regular Staff") ? 'selected' : ''; ?>>Regular Staff</option>
                                <option value="Cashier" <?php echo ($position == "Delivery Staff") ? 'selected' : ''; ?>>Delivery Staff</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $position_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-white">Password:</label>
                            <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" name="password" required>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="text-white">Confirm Password:</label>
                            <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" required>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-register">Register</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
