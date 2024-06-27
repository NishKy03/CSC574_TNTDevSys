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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

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
            <main role="main">
                <!-- Header -->
                <div class="header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
						
						<button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><img src="menubar.png" alt="Menu Icon" class="menu-icon mr-3"></button>
						<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
						<div class="offcanvas-header">
							<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
						</div>
						<div class="offcanvas-body">
							<nav class="d-none d-md-block bg-red sidebar">
								<div class="profile-section text-center py-4">
									<img src="Ellipse 5.png" alt="Profile Image" class="img-fluid">
									<h4 class="text-white mt-3">LEE CHIN</h4>
								</div>
								<ul class="nav flex-column">
									<li class="nav-item">
										<a class="nav-link active" href="#">
											Profile
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">
											Staff
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">
											Orders
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">
											List
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">
											Register
										</a>
									</li>
								</ul>
							</nav>
						</div>
						</div>

						<img src="tnt.png" alt="Company Logo" class="company-logo">
                    </div>
                    <div>
                        <a href="#" class="text-white h5 mr-3">HOME</a>
                        <a href="#" class="text-white h5">LOG OUT</a>
                    </div>
                </div>

                <div class="main-content mt-5">
                    <h2 class="text-center text-white">NEW STAFF</h2>

                    <form>
                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name" class="text-white">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                        </div>

                        <!-- Phone Number Field -->
                        <div class="form-group">
                            <label for="phone-number" class="text-white">Phone Number</label>
                            <input type="tel" class="form-control" id="phone-number" name="phone-number" placeholder="Enter phone number" required>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="text-white">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>

                        <!-- Position Field -->
                        <div class="form-group">
                            <label for="position" class="text-white">Position</label>
                            <select class="form-control" id="position" name="position">
                                <option value="regular">Regular Staff</option>
                                <option value="delivery">Delivery Staff</option>
                            </select>
                        </div>

                        <!-- Register Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-register">REGISTER</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
