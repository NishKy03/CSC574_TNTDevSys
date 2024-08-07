<?php include 'universalHeader.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            background-image: url('images/bg.jpg'); /* Add the path to your background image */
            background-size: cover; /* Ensures the background image covers the entire body */
            background-position: 0px 50px;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Prevent scrolling */
        }

        .container {
            height: 100vh; /* Ensure container fills the viewport height */
            display: flex;
            justify-content: flex-end; /* Align the contact form to the right */
            align-items: center;
            padding-right: 10vh;
            position: relative;
            z-index: 2; /* Ensure container content stays above the diagonal divider */
        }

        .form-container {
            position: relative;
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(217, 217, 217, 0.9); /* Slight transparency */
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 3; /* Ensure form-container stays above the diagonal divider */
        }

        .form-container h2 {
            color: black;
            margin-bottom: 20px;
            margin-top: 0; /* Remove top margin */
            font-weight: 800;
            font-size: 26px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: black;
            margin-left: 20px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .form-container textarea {
            resize: none;
        }

        .button-submit button {
            width: 50%;
            padding: 10px;
            margin-top: 10px;
            background-color: #b45858;
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth background color and transform transition */
        }

        .button-submit button:hover {
            background-color: #45a049;
            transform: scale(1.1); /* Scale up effect on hover */
        }

        .form-container a {
            text-decoration: none;
            color: #cccccc;
            font-size: 14px;
        }

        .form-container a:hover {
            text-decoration: none; /* Remove underline on hover */
            color: white;
        }

        .diagonal-divider {
            position: absolute;
            top: -10%;
            left: -20%;
            width: 200%;
            height: 200%;
            background: rgba(255, 0, 0, 0.3); /* Red color with transparency */
            clip-path: polygon(0 90%, 0 0, 100% 75%);
            z-index: 1; /* Send it behind other content */
        }

        .icon-container {
            position: absolute;
            top: 30%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: url('images/mail.png') no-repeat center center; /* Local PNG icon */
            background-size: contain;
            z-index: 3; /* Ensure icon-container stays above the diagonal divider */
        }

        header {
            z-index: 4; /* Ensure the header stays above everything */
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            text-align: left;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="diagonal-divider"></div>
        <div class="icon-container"></div>
        <div class="form-container shadow-lg p-4">
            <h2>Contact Us</h2>
            <form action="process_contact_form.php" method="post" id="contactForm" onsubmit="return validateForm()">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required pattern="[A-Za-z\s]{1,50}">
                    <div id="nameError" class="error-message"></div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    <div id="emailError" class="error-message"></div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="desc" name="desc" placeholder="Enter your description (max 250 characters)" rows="5" required maxlength="250"></textarea>
                    <div id="descError" class="error-message"></div>
                </div>
                <div class="button-submit">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        // Check for error message from PHP script
        if (isset($_GET['message'])) {
            if ($_GET['message'] == 'error') {
                echo '<script>Swal.fire("Failed!", "Failed to send message. Please try again later.", "error");</script>';
            } elseif ($_GET['message'] == 'sent') {
                echo '<script>Swal.fire("Success!", "Message sent successfully!", "success");</script>';
            }
        }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to validate form fields on the fly
        function validateForm() {
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var desc = document.getElementById('desc').value.trim();

            var namePattern = /^[A-Za-z\s]{1,50}$/;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            var isValid = true;

            // Validate Name
            if (!name.match(namePattern)) {
                document.getElementById('nameError').innerHTML = 'Please enter a valid name (only letters and spaces, max 50 characters).';
                isValid = false;
            } else {
                document.getElementById('nameError').innerHTML = '';
            }

            // Validate Email
            if (!email.match(emailPattern)) {
                document.getElementById('emailError').innerHTML = 'Please enter a valid email address.';
                isValid = false;
            } else {
                document.getElementById('emailError').innerHTML = '';
            }

            // Validate Description
            if (desc.length > 250) {
                document.getElementById('descError').innerHTML = 'Description should not exceed 250 characters.';
                isValid = false;
            } else {
                document.getElementById('descError').innerHTML = '';
            }

            return isValid;
        }

        // Real-time validation on input change
        document.getElementById('name').addEventListener('input', function() {
            var name = this.value.trim();
            var namePattern = /^[A-Za-z\s]{1,50}$/;

            if (!name.match(namePattern)) {
                document.getElementById('nameError').innerHTML = 'Please enter a valid name (only letters and spaces, max 50 characters).';
            } else {
                document.getElementById('nameError').innerHTML = '';
            }
        });

        document.getElementById('email').addEventListener('input', function() {
            var email = this.value.trim();
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email.match(emailPattern)) {
                document.getElementById('emailError').innerHTML = 'Please enter a valid email address.';
            } else {
                document.getElementById('emailError').innerHTML = '';
            }
        });

        document.getElementById('desc').addEventListener('input', function() {
            var desc = this.value.trim();

            if (desc.length > 250) {
                document.getElementById('descError').innerHTML = 'Description should not exceed 250 characters.';
            } else {
                document.getElementById('descError').innerHTML = '';
            }
        });
    </script>
</body>
</html>
