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
require_once 'dbConnect.php';

// Initialize variables to avoid null warnings
$staffName = "";
$phone = "";
$email = "";
$question = "";
$answer = "";

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
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Update the staff information in the database
    $sql = "UPDATE Staff SET staffName = ?, staffPhone = ?, staffEmail = ?, staffQuestion = ?, staffAnswer = ?  WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("sssssi", $staffName, $phone, $email, $question, $answer, $staffID);

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
}

// Fetch staff information from database based on staffID in session
$staffID = $_SESSION['staffID'];
$sql = "SELECT * FROM Staff WHERE staffID = ?";
$stmt = $dbCon->prepare($sql);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();

// Check if staff data exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $staffName = $row['staffName'];
    $phone = isset($row['staffPhone']) ? $row['staffPhone'] : ""; // Check if phone is set in database result
    $email = isset($row['staffEmail']) ? $row['staffEmail'] : ""; // Check if email is set in database result
    $question = $row['staffQuestion'];
    $answer = $row['staffAnswer'];
} else {
    // Handle case where staff data is not found
    echo "Staff data not found.";
}

// Close statement and connection
$stmt->close();
$dbCon->close();

// Function to check if a question is selected
function isSelected($currentQuestion, $questionOption) {
    return ($currentQuestion == $questionOption) ? 'selected' : '';
}

// Array of security questions
$securityQuestions = [
    "childhood_nickname" => "What was your childhood nickname?",
    "childhood_friend" => "What is the name of your favorite childhood friend?",
    "oldest_sibling" => "What is your oldest sibling’s birthday month and year? (e.g., January 1900)",
    "pet_name" => "What is your pet's name?",
    "favorite_artist" => "Who is your favorite artist?"
];
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
        background-color: #ECE0D1;
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
        width: 200px; /* Increased width to accommodate longer labels */
        font-size: 16px;
        font-weight: bold;
    }

    .profile-info input,
    .profile-info select { /* Added styling for select elements */
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        width: 100%; /* Ensures inputs and selects take full width */
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

    /* Adjustments for select dropdown */
    .profile-info select {
        width: 100%; /* Full width */
        max-width: 100%; /* Ensure no overflow */
        box-sizing: border-box; /* Include padding in width */
    }
</style>

    <script>
        function validateForm() {
            // Validate name: only letters allowed
            var name = document.getElementById("name").value;
            var namePattern = /^[A-Za-z\s]+$/;
            if (!namePattern.test(name)) {
                alert("Name can only contain letters and spaces.");
                return false;
            }

            // Validate phone: format ###-### ####
            var phone = document.getElementById("phone").value;
            var phonePattern = /^\d{3}-\d{3} \d{4}$/;
            if (!phonePattern.test(phone)) {
                alert("Phone number must be in the format ###-### #### (e.g., 017-970 3786).");
                return false;
            }

            return true;
        }

        function formatPhoneNumber(input) {
            // Strip all non-numeric characters
            var cleaned = ('' + input.value).replace(/\D/g, '');

            // Match cleaned input against phone number pattern
            var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                input.value = match[1] + '-' + match[2] + ' ' + match[3];
            }
        }

        window.onload = function() {
            // Check if the URL contains the 'update=success' parameter
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('update') === 'success') {
                // Display the alert
                alert("Successfully Updated");
            }
        }

        function preventNumbers(event) {
            var charCode = event.which ? event.which : event.keyCode;
            if (charCode >= 48 && charCode <= 57) {
                event.preventDefault();
            }
        }

        function preventAlphabets(event) {
            var charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="profile-content">
            <div class="profile-details">
                <h1>PROFILE</h1>
                <form action="updateProfile.php" method="post" onsubmit="return validateForm()">
                    <div class="profile-info">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" id="id" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>" class="non-editable" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>" class="editable" onkeypress="preventNumbers(event)">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="editable" onkeypress="preventAlphabets(event)" oninput="formatPhoneNumber(this)" maxlength="12">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="editable">
                        </div>
                        <div class="form-group">
                            <label for="question">Security Question</label>
                            <select id="question" name="question" class="editable">
                                <option value="">Select Security Question</option>
                                <?php foreach ($securityQuestions as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>" <?php echo isSelected($question, $key); ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="answer">Security Answer</label>
                            <input type="text" id="answer" name="answer" value="<?php echo htmlspecialchars($answer); ?>" class="editable">
                        </div>
                        <button type="submit">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
