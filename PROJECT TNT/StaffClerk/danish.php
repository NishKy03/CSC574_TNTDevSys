<?php
include ('../dbConnect.php');

$stmt = $dbCon->prepare("SELECT * FROM sender");
$stmt->execute();
$result = $stmt->get_result();

$senders = [];
while ($row = $result->fetch_assoc()) {
    $senders[$row['senderID']] = $row;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
        <style>

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
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            padding: 10px;
            position: fixed;
            z-index: 1; 
            width: 100%;
            background-color: #4B0606;
            color: white;
            font-size: 35px;
            cursor: pointer;
            padding-left: 40px;
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
            color: white;
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
        :root{
            --primary-color: rgb(11, 78, 179);
        }
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body{
            min-height: 100vh;
            background: #ECE0D1;
            background-size: cover;
            background-position: center;
            overflow-x: hidden;
        }

        .container {
            display: flex;
            flex-direction: column;
        }

        .side-bar{
            background: #1b1a1b;
            backdrop-filter: blur(15px);
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -250px;
            overflow-y: auto;
            transition: 0.6s ease;
            transition-property: left;
            z-index: 1000;
        }

        .side-bar::-webkit-scrollbar {
            width: 0px;
        }

        .side-bar.active{
            left: 0;
        }

        header h1{
            text-align: center;
            font-weight: 500;
            font-size: 25px;
            padding-bottom: 13px;
            font-family: sans-serif;
            letter-spacing: 2px;
        }

        .side-bar .menu{
            width: 100%;
            margin-top: 30px;
        }

        .side-bar .menu .item{
            position: relative;
            cursor: pointer;
        }

        .side-bar .menu .item a{
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            display: block;
            padding: 5px 30px;
            line-height: 60px;
        }

        .side-bar .menu .item a:hover{
            background: #33363a;
            transition: 0.3s ease;
        }

        .side-bar .menu .item i{
            margin-right: 15px;
        }

        .side-bar .menu .item a .dropdown{
            position: absolute;
            right: 0;
            margin: 20px;
            transition: 0.3s ease;
        }

        .side-bar .menu .item .sub-menu{
            background: #262627;
            display: none;
        }

        .side-bar .menu .item .sub-menu a{
            padding-left: 80px;
        }

        .rotate{
            transform: rotate(90deg);
        }

        .close-btn{
            position: absolute;
            color: #fff;
            font-size: 23px;
            right:  0px;
            margin: 15px;
            cursor: pointer;
        }

        .menu-btn{
            width: 100%;
            background-color: #4B0606;
            color: white;
            font-size: 35px;
            cursor: pointer;
            padding: 10px;
            padding-left: 40px;
        }


        img{
            width: 100px;
            margin: 15px;
            border-radius: 50%;
            margin-left: 70px;
            border: 3px solid #b4b8b9;
        }

        header{
            background: #33363a;
        }

        .section{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .progressbar-wrap{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .progressbar{
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
            margin: 2rem 0 4rem;
            width: 20%;
            margin-top: 100px;
        }

        .progressbar::before, .progress{
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%; 
            background-color: #414040;
            z-index: -1;
        }

        .progress{
            background-color: rgb(11, 169, 11);
            width: 0%;
        }

        .progress-step{
            width: 50px;
            height: 50px;
            border: 3px solid #414040;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .progress-step::before{
            counter-increment: step;
            content: counter(step);
        }

        .progress-step::after{
            content: attr(data-title);
            position: absolute;
            top: calc(100% + 0.5rem);
            font-size: 18px;
            color: #666;
            font-weight: bold;
        }

        .progress-step-active{
            background-color: rgb(11, 169, 11);
            color: #fff;
            border: none;
            back
        }

        *::before,
        *::after {
            box-sizing: border-box;
        }

        label{
            display: block;
            padding-left: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        .width-50{
            width: 50%;
        }

        .ml-auto{
            margin-left: auto;
        }

        .text-center{
            text-align: center;
        }

        .input-group input[type="text"], 
        .input-group2 input[type="text"],
        .input-group3 input[type="text"],
        .input-group4 input[type="text"],.input-group select{
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
        .input-group4 input[type="checkbox"]{
            margin-left: 20px;
        }
        .input-group input[type="textarea"]{
            width: 100%;
            height: 100px;
            padding: 10px;
            border-radius: 20px;
            outline: none;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        select{
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            width: 270px;
        }
        .form{
            width: 700px;
            margin: 0 auto;
            border: 3px solid #4B0606;
            border-radius: 20px;
            padding-left: 50px;
            padding-right: 50px;
            padding-top: 20px;
            padding-bottom: 20px;

        }
        .form h1{
            padding-left: 10px;
            padding-bottom: 15px;
            font-size: 25px;
        }
        .form-step{
            display: none;
        }

        .form-step-active{
            display: block;
        }

        .input-group{
            margin-bottom: 10px;
        }
        .input-group2, .input-group3, .input-group4, .input-group4{
            display: inline-block;
            margin-bottom: 10px;
        }
        .input-group4{
            margin-left: 40px;
        }
        .input-group2{
            width: 50%;
            margin-right: 20px;
        }
        
        .btns-group{
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        .btns-group input[type="submit"]
        {
            border: none;
        }
        .btn{
            padding: 0.75rem;
            display: block;
            text-decoration : none;
            background-color: var(--primary-color);
            color: #f3f3f3;
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn:hover{
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
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
                    <li><a href="StaffClerk/staffList.php">Staff</a></li>
                </ul>
            </nav>
        </aside>
        <div class="container">
        <div class="section">
            <div class="progressbar-wrap">
                <div class="progressbar">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title="Sender"></div>
                    <div class="progress-step" data-title="Receipent"></div>
                    <div class="progress-step" data-title="Parcel"></div>
                    <!-- <div class="progress-step" data-title="Submit"></div> -->
                </div>
            </div>
            
            <form class="form">
                <!-- <h1 class="text-center">Booking Form</h1> -->

                <div class="form-step form-step-active">
                    <h1>Sender Details</h1>
                    <div class="input-group">
                        <label for="sendername">Name</label>
                        <select name="name" id="name">
                            <option value="" disabled selected>Select sender name</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="SPhone" id="phoneno" value="<?php echo $selectedSender ? $selectedSender['phoneNo'] : '' ?>">
                    </div>
                    <div class="input-group">
                        <label for="address">Address</label>
                        <input type="text" name="SAddress" id="address" value="<?php echo $selectedSender ? $selectedSender['addressLine1'] : '' ?>">
                    </div>
                    <div class="input-group2">
                        <label for="city">City</label>
                        <input type="text" name="SCity" id="city"  value="<?php echo $selectedSender ? $selectedSender['city'] : '' ?>">
                    </div>
                    <div class="input-group3">
                        <label for="state">State</label>
                        <select name="SState" id="state">
                            <option  value="<?php echo $selectedSender ? $selectedSender['state'] : '' ?>"> <?php echo $selectedSender['state']?> </option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="SPostcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode"  value="<?php echo $selectedSender ? $selectedSender['postcode'] : '' ?>">
                    </div>
       
                    <div class="">
                        <a href="#" class="btn btn-next width-50 ml-auto">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <h1>Receipent Details</h1>
                    <div class="input-group">
                        <label for="sendername">Name</label>
                        <input type="text" name="sendername" id="sendername">
                    </div>
                    <div class="input-group">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="phoneno" id="phoneno">
                    </div>
                    <div class="input-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address">
                    </div>
                    <div class="input-group2">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city">
                    </div>
                    <div class="input-group3">
                        <label for="state">State</label>
                        <select name="state" id="state">
                            <option value="perak">perak</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode">
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Previous</a>
                        <a href="#" class="btn btn-next">Next</a>
                    </div>
                </div>

                <div class="form-step">
                    <div class="input-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="text" name="weight" id="weight">
                    </div>
                    <div class="input-group">
                        <label for="details">Details</label>
                        <input type="textarea" name="details" id="details">
                    </div>
                    <div class="input-group3">
                        <label for="rate">Shipping Rate</label>
                        <select name="rate" id="rate">
                            <option value="medium">perak</option>
                        </select>
                    </div>
                    <div class="input-group4">
                        <b>Insurance</b>
                        <input type="checkbox" name="insurance" id="insurance">
                    </div>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Previous</a>
                        <input type="submit" value="Submit" class="btn">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            // Side bar toggle
            $(".menu-btn").click(function(){
                $(".side-bar").addClass("active");
                $(".menu-btn").css("visibility", "hidden");
            });

            $(".close-btn").click(function(){
                $(".side-bar").removeClass("active");
                $(".menu-btn").css("visibility", "visible");
            });

            // Sub menu toggle
            $(".sub-btn").click(function(){
                $(this).next(".sub-menu").slideToggle();
                $(this).find(".dropdown").toggleClass("rotate");
            });
        });
        const prevBtns = document.querySelectorAll(".btn-prev");
        const nextBtns = document.querySelectorAll(".btn-next");
        const progress = document.getElementById("progress");
        const formSteps = document.querySelectorAll(".form-step");
        const progressSteps = document.querySelectorAll(".progress-step");

        let formStepsNum = 0;

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum++;
                updateFormSteps();
                updateProgressbar();
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressbar();
            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep) => {
                formStep.classList.contains("form-step-active") &&
                formStep.classList.remove("form-step-active");
            });
            formSteps[formStepsNum].classList.add("form-step-active");
        }

        function updateProgressbar() {
            progressSteps.forEach((progressStep, idx) => {
                if (idx <= formStepsNum) {
                    progressStep.classList.add("progress-step-active");
                } else {
                    progressStep.classList.remove("progress-step-active");
                }
            });
            const progressActive = document.querySelectorAll(".progress-step-active");
            progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
        }
    </script>
    </body>
</html>