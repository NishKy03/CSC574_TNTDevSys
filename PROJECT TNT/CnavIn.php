<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <style>
        body {
            margin: 0;
        }

        :root {
            --bar-width: 30px;
            --bar-height: 4px;
            --hamburger-gap: 4px;
            --foreground: #333;
            --background: white;
            --hamburger-margin: 10px;
            --animation-timing: 200ms ease-in-out;
            --hamburger-height: calc(var(--bar-height) * 3 + var(--hamburger-gap) * 2);
        }

        .header {
            height: 50px;
            overflow: hidden;
            background-color: #59593F;
            font-family: 'Poppins', sans-serif;
            padding: 10px 10px;
            position: fixed;
            width: 100%;
            z-index: 1; /* Added this to make sure the header is above the sidebar */
        }

        .header .opt {
            float: left;
            color: white;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            border-radius: 4px;
        }

        .header .logo {
            padding: 0;
            
        }

        .header img {
            height: 50px;
            width: auto;
            margin-left: 40px;
        }

        .header .opt:hover {
            background-color: #85856A;
            color: black;
        }

        .header .opt.active {
            background-color: #2b2b23;
            color: white;
        }

        .header-right {
            float: right;
            padding-right: 1%;
        }

        @media screen and (max-width: 500px) {
            .header .opt {
                float: none;
                display: block;
                text-align: left;
            }

            .header-right {
                float: none;
            }
        }

        .hamburger-menu {
            --x-width: calc(var(--hamburger-height) * 1.41421356237);

            display: flex;
            flex-direction: column;
            gap: var(--hamburger-gap);
            width: max-content;
            position: absolute;
            top: var(--hamburger-margin);
            left: var(--hamburger-margin);
            z-index: 2;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;;
        }

        .hamburger-menu:has(input:checked) {
            --foreground: #333;
            --background: #333;
        }

        .hamburger-menu:has(input:focus-visible)::before,
        .hamburger-menu:has(input:focus-visible)::after,
        .hamburger-menu input:focus-visible {
            border: 1px solid var(--background);
            box-shadow: 0 0 0 1px var(--foreground);
        }

        .hamburger-menu::before,
        .hamburger-menu::after,
        .hamburger-menu input {
            content: "";
            width: var(--bar-width);
            height: var(--bar-height);
            background-color: var(--foreground);
            border-radius: 9999px;
            transform-origin: left center;
            transition: opacity var(--animation-timing), width var(--animation-timing),
                rotate var(--animation-timing), translate var(--animation-timing),
                background-color var(--animation-timing);
        }

        .hamburger-menu input {
            appearance: none;
            padding: 0;
            margin: 0;
            outline: none;
            pointer-events: none;
        }

        .hamburger-menu:has(input:checked)::before {
            rotate: 45deg;
            width: var(--x-width);
            translate: 0 calc(var(--bar-height) / -2);
        }

        .hamburger-menu:has(input:checked)::after {
            rotate: -45deg;
            width: var(--x-width);
            translate: 0 calc(var(--bar-height) / 2);
        }

        .hamburger-menu input:checked {
            opacity: 0;
            width: 0;
        }

        .sidebar {
            transition: translate var(--animation-timing);
            translate: -100%;
            padding-top: calc(var(--hamburger-height) + var(--hamburger-margin) + 1rem);
            background-color: #59593F;
            color: var(--background);
            max-width: 10 rem;
            min-height: 100vh;
            margin-top: 50px;
            position: fixed;
            padding-left: 10px;
            padding-right: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        /* When you mouse over the navigation links, change their color */
        .sidebar a:hover {
            color: black;
        }

        .sidebar .profile {
            text-align: center;
            padding: 10px 0;
        }

        .sidebar .profile img {
            width: 100px;
            border-radius: 50%;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            padding: 10px 20px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar nav ul li.active a {
            background-color: #b30000; /* Slightly lighter red */
        }

        .hamburger-menu:has(input:checked) + .sidebar {
            translate: 0;
        }
        </style>
    </head>
    <body>
        <div class="header">
            <a href="#default"><img src="images/tntlogo.png"></a>
            <div class="header-right">
                <a class="opt" href="#about">Logout</a>
            </div>
        </div>
        <label class="hamburger-menu">
            <input type="checkbox" />
        </label>
        <aside class="sidebar">
            <div class="profile">
                <h3>Hi,</h3>
                <h3><?php echo $_SESSION['staffID']; ?></h3>
                <img src="images/picture.png" alt="Profile Picture">
            </div>
            <nav>
                <ul>
                    <li><a href="CProfile.php">Profile</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="staff_list.php">Staff</a></li>
                </ul>
            </nav>
        </aside>
    </body>
</html>