<?php
include("CHeader.php");
require_once("dbConnect.php");


$message = "";
$name = $phone = $email = $position = $password = $confirm_password = "";
$name_err = $phone_err = $email_err = $position_err = $password_err = $confirm_password_err = "";

// Fetch the next staffID
// $nextStaffID = 2000001; // Default if there are no staff records
// $sql = "SELECT MAX(staffID) AS maxStaffID FROM STAFF";
// $result = mysqli_query($dbCon, $sql);
// if ($result) {
//     $row = mysqli_fetch_assoc($result);
//     if ($row['maxStaffID']) {
//         $nextStaffID = $row['maxStaffID'] + 1;
//     }
// }

// Process form data when submitt
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
        // Check if name contains only alphabets and '@'
        if (!preg_match("/^[A-Za-z@ ]+$/", $name)) {
            $name_err = "Name can only contain alphabets and '@'.";
        }
    }

    // Validate phone
    if (empty(trim($_POST["phoneNumber"]))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST["phoneNumber"]);
        // Check if phone number format is correct ###-#######
        if (!preg_match("/^\d{3}-\d{7}$/", $phone)) {
            $phone_err = "Phone number must be in the format ###-#######.";
        }
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
        $sql = "INSERT INTO STAFF (password, staffName, staffPhone, staffEmail, position) VALUES ( ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_password, $param_name, $param_phone, $param_email, $param_position);
            $param_password = $password; // Encrypt the password
            $param_name = $name;
            $param_phone = $phone;
            $param_email = $email;
            $param_position = $position;

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data has been created.');</script>";
                echo "<script>window.location.href='staffList.php';</script>";
            } else {
                echo "<script>alert(Something went wrong. Please try again later.);</script>";
            }
        } else {
            echo "<script>alert('Something went wrong. Please try again later.');</script>";
        }
      
    } else{
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        .body-register {
            margin: 0;
            line-height: normal;
            font-family: 'Poppins', sans-serif;
            background-color: #ece0d1;
        }

        .main-content-register {
            background-color: rgba(75, 6, 6, 0.5);
            border-radius: 20px;
            padding: 30px;
            margin-top: 5%;
            margin-bottom: 5%;
            width: 1000px;
            margin-left: 20%;
        }

        .form-group label {
            font-weight: bold;
            color: white;
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
    </style>
</head>
<body class="body-register">
    <div class="main-content-register">
        <h2 class="text-center text-white">Register Staff</h2>
        <form action="RegisterStaff.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $name; ?>" pattern="[A-Za-z@ ]+" title="Name can only contain alphabets and '@'." required>
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" id="phoneNumber" name="phoneNumber" value="<?php echo $phone; ?>" required pattern="\d{3}-\d{7}" title="Phone number must be in the format ###-#######">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="position">Position:</label>
                <select class="form-control <?php echo (!empty($position_err)) ? 'is-invalid' : ''; ?>" id="position" name="position" required>
                    <option value="staff" <?php echo ($position == "staff") ? 'selected' : ''; ?>>Staff</option>
                    <option value="courier" <?php echo ($position == "courier") ? 'selected' : ''; ?>>Courier</option>
                </select>
                <span class="invalid-feedback"><?php echo $position_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" name="password" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" required>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-warning">Register</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('phoneNumber').addEventListener('input', function (e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,7})/);
            e.target.value = x[1] + (x[2] ? '-' + x[2] : '');
        });
    </script>
</body>
</html>