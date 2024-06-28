<?php include 'universalHeader.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(110deg, #9c5e5e 0%, #cf8c8c 50%); /* Gradient background */
        }
        
        .container {
            min-height: 100vh; /* Ensure container fills the viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 10vh;
        }
        
        .form-container {
            position: relative;
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: #d9d9d9;
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .form-container h2 {
            color: black;
            margin-bottom: 20px;
            margin-top: 0; /* Remove top margin */
            font-weight: 800;
            font-size: 26px;
            font-family: Arial, sans-serif;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container shadow-lg p-4">
            <h2>Contact Us</h2>
            <form>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="desc" name="desc" placeholder="Enter your description" rows="5"></textarea>
                </div>
                <div class="button-submit">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Handle close button click
        document.querySelector('.close-btn').addEventListener('click', function() {
            window.location.href = 'homepage.php';
        });

        // Add bounce effect to submit button on hover
        document.querySelector('.button-submit button').addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        document.querySelector('.button-submit button').addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>
