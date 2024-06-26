<?php
// Start PHP session
session_start();
// Check if staffID is set in session
if (!isset($_SESSION['staffID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
// Include header
include 'headerStaffDelivery.php';
// Database connection
include '../dbConnect.php';

// Initialize variables to avoid null warnings
$staffName = "";
$phone = "";
$email = "";

// Check if staff position is 'courier'
if ($_SESSION['position'] !== 'courier') {
    echo '<div class="access-denied">Access Denied. Only accessible by courier staff.</div>';
    exit();
}

// Handle form submission to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $staffID = $_SESSION['staffID'];
    $staffName = $_POST['staffName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Update the staff information in the database
    $sql = "UPDATE Staff SET staffName = ?, staffPhone = ?, staffEmail = ? WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("ssss", $staffName, $phone, $email, $staffID);

    if ($stmt->execute()) {
        // Update session variable
        $_SESSION['staffName'] = $staffName;
        
        // Redirect to profile page with success message
        header("Location: myProfileStaff.php?update=success");
        exit();
    } else {
        // Redirect to profile page with error message
        header("Location: myProfileStaff.php?update=error");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $dbCon->close();
} else {
    // Fetch staff information from database based on staffID in session
    $staffID = $_SESSION['staffID'];
    $sql = "SELECT * FROM Staff WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("s", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if staff data exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staffName = $row['staffName'];
        $phone = isset($row['staffPhone']) ? $row['staffPhone'] : ""; // Check if phone is set in database result
        $email = isset($row['staffEmail']) ? $row['staffEmail'] : ""; // Check if email is set in database result
    } else {
        // Handle case where staff data is not found
        echo "Staff data not found.";
    }

    // Close database connection
    $stmt->close();
    $dbCon->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../header.css">
    <title>Profile - TNT</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2%;
            padding: 20px;
        }

        .profile-content {
            background-color: #4b0606;
            padding: 30px;
            border-radius: 20px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .profile-details h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-info .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-info label {
            width: 100px;
            font-size: 16px;
            font-weight: bold;
        }

        .profile-info input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
        }

        .profile-info .editable {
            background-color: #fff;
        }

        .profile-info .non-editable {
            background-color: transparent;
            color: #fff;
        }

        .profile-info button {
            padding: 15px;
            background-color: #b45858;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            width: 100%;
        }

        .profile-info button:hover {
            background-color: #4b0606;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-content">
            <div class="profile-details">
                <h1>PROFILE</h1>
                <form action="updateProfile.php" method="post">
                    <div class="profile-info">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" id="id" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" class="non-editable" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>" class="editable">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="editable">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="editable">
                        </div>
                        <button type="submit">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
