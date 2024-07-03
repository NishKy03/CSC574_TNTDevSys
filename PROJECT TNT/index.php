<?php include 'Home/universalHeader.php'; ?>
<style>   
body {
    overflow:hidden;
}  
.about-container {
    min-height: 100vh; /* Ensures the container covers the full height of the viewport */
    padding: 50px;
    text-align: center;
    background-image: url('images/bg.jpg'); /* Add the path to your background image */
    background-size: cover; /* Ensures the background image covers the entire body */
    background-position: 0px 0px;
    background-repeat: no-repeat;
    color: white; /* Ensure text color is white for better contrast */

}

.about {
    background-color: rgba(108, 80, 80, 0.8); /* Adding transparency */
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    color: white;
    
}

.vision-mission {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.vision, .mission {
    background-color: rgba(108, 80, 80, 0.8); /* Adding transparency */
    padding: 20px;
    border-radius: 10px;
    width: 48%;
    color: white;
}

h2 {
    font-size: 30px;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    line-height: 1.5;
}
</style>
</head>
<body>

<div class="about-container">
    <div class="about">
        <h2>About Us</h2>
        <p>At TNT Company, we pride ourselves on delivering more than just packages – we deliver peace of mind. 
            With years of experience in the industry, our dedicated team is committed to providing reliable and 
            efficient courier services tailored to meet the unique needs of our clients. From same-day deliveries
             to international shipments, we handle every package with care and precision, ensuring it reaches its 
             destination safely and on time. Our commitment to excellence drives us to continuously innovate and 
             optimize our processes, utilizing cutting-edge technology and a network of trusted partners to streamline 
             deliveries and exceed customer expectations. Whether you’re a small business or a large corporation, 
             you can trust TNT Company to be your reliable logistics partner every step of the way.</p>
    </div>
    <div class="vision-mission">
        <div class="vision">
            <h2>Vision</h2>
            <p>To become the leading choice for reliable and efficient courier services worldwide, constantly innovating
                 to exceed customer expectations and prioritizing customer satisfaction.</p>
        </div>
        <div class="mission">
            <h2>Mission</h2>
            <p>To provide seamless, reliable delivery solutions with innovation, professionalism, and environmental 
                responsibility, ensuring customer satisfaction and peace of mind.</p>
        </div>
    </div>
</div>
</body>
</html>
