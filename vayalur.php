<!DOCTYPE html>
<html>
<head>
    <title>VAYALUR MURUGAN TEMPLE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("background.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            font-family: georgia, ' times new roman';
        }

        .carousel-item img {
        width: 100%;
        height: 50%;
    }

    h2 {
        text-align: center;
        background-color: gold;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: gold;
    }

    .container {
        margin-top: 30px;
    }

    .details-container {
        background-color: ivory;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
    }

    h1 {
        text-align: center;
    }

    .navigation ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navigation ul li {
            display: inline-block;
            margin: 0 10px;
        }

        .navigation ul li a {
            color: #0c0b0b;
            text-decoration: none;
        }
        .navigation {
            background-color: skyblue;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fef6f6;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #bdbbbb;
        }
</style>
</head>
<body>
    <header>
        <h1>VAYALUR MURUGAN TEMPLE</h1>
    </header>
    <div class="navigation">
        <ul>
            <li><a href="home.php">HOME</a></li>
            <li class="dropdown">
                <a href="#">AUDIO GUIDE</a>
                <div class="dropdown-content">
                    <a href="Kapaleeshwarar audio (1).mp3">TAMIL LANGUAGE</a>
                    <a href="">ENGLISH LANGUAGE</a>
                </div>
             <li><a href="https://www.google.com/maps/@10.8288097,78.6238137,3a,75y,281.3h,96.6t/data=!3m6!1e1!3m4!1sUjbdybM4WOiGsePVHQk18A!2e0!7i13312!8i6656?entry=ttu">VIRTUAL TOUR</a></li>
            <li><a href="darshanbooking.php">BOOK TICKETS</a></li>
            <li><a href="poojabooking.php">POOJA BOOKING</a></li>
            <li><a href="donation.php">DONATION</a></li>
            <li><a href="vayalurcontact.php">CONTACT</a></li>
      
                
                    

                </div>
        </ul>
    
        
    </div>
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="vayalur1.jpg" alt="Temple 1" style="width: 100%; height: 500px">
                </div>
                <div class="carousel-item">
                    <img src="vayalur2.jpg" alt="Temple 2" style="width: 100%; height: 500px;">
                </div>
                <div class="carousel-item">
                    <img src="vayalur3.jpg" alt="Temple 3" style="width: 100%; height: 500px;">
                </div>
                <div class="carousel-item">
                    <img src="vayalur4.jpg" alt="Temple 4" style="width: 100%; height: 500px;">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="details-container">
            <h3>HISTORY</h3>
            <p>Vayalur Murugan Temple, located in Trichy, is a revered shrine dedicated to Lord Murugan. The temple has a rich history and is believed to be several centuries old. The sanctum sanctorum of the temple houses a magnificent idol of Lord Murugan, attracting devotees from far and wide. The temple's serene atmosphere and beautiful surroundings make it a perfect place for spiritual solace and divine blessings. Visit the Vayalur Murugan Temple to experience the sacredness and immerse yourself in devotion.</p>
        </div>
    </div>
    <div class="container">
        <div class="details-container">
            <h4>OPENING HOURS</h4>
            <p>5:30 AM - 1:00 PM</p>
            <p>2.00 PM - 8:30 PM</p>
        </div>
    </div>
    <div class="container">
        <div class="details-container">
            <h4>POOJA TIMINGS</h4>
            <p>5:30 am to 6:00 am - Viswaroopa Darshan (Ushakalam)</p>
            <p>6:00 am to 8:30 am - Darshan</p>
            <p>8:30 am to 9:00 am - Kalasandhi Pooja</p>
            <p>9:00 am to 11:30 am - Darshan</p>
            <p>11:30 am to 12:00 pm - Uchikalam Pooja</p>
            <p>12:00 pm to 1:00 pm - Darshan</p>
            <p>1:00 pm - Temple closing Hours</p>
            <p>1:00 pm to 2:00 pm - Temple remains closed</p>
            <p>2:00 pm - Temple reopens</p>
            <p>2:00 pm to 4:30 pm - Darshan</p>
            <p>4:30 pm 5:00 pm - Sayaratchai Pooja</p>
            <p>5:00 pm to 7:30 pm - Darshan</p>
            <p>7:30 pm to 8:00 pm - Ardha Jama Pooja</p>
            <p>8:00 pm to 8:30 pm - Darshan</p>
        </div>
    </div>
    <div class="container">
        <div class="details-container">
            <h4>LOCATION</h4>
            <p>Vayalur Murugan Temple, Trichy - 620102, Tamil Nadu, India.</p>
        </div>
    </div>
    <div class="container">
        <div class="details-container">
            <h4>FESTIVALS</h4>
            <p>Thai Poosam</p>
            <p>Panguni Uthiram</p>
            <p>Karthigai Deepam</p>
            <p>Skanda Shashti</p>
            <p>Thirukarthigai</p>
            <p>Vaikasi Visakam</p>
            <p>Aadi Krithigai</p>
            <p>Thai Poosam</p>
        </div>
    </div>
    <div class="container">
        <div class="details-container">
            <h4>WAYS TO REACH</h4>
            <p>By Auto-rickshaw or Taxi: The most convenient way to reach Vayalur Murugan Temple is by hiring an auto-rickshaw or a taxi. The temple is located approximately 10 kilometers from Trichy. You can find auto-rickshaws and taxis easily in Trichy, and they can take you directly to the temple entrance.</p>

<p>By Bus: Trichy has a well-connected bus network, and you can take a local bus to reach Vayalur Murugan Temple. Look for buses that are heading towards Vayalur or Viralimalai, as these buses will pass by or near the temple. You can board the bus from the nearest bus stop and inform the conductor or driver that you want to get off at Vayalur Murugan Temple.</p>

<p>By Own Vehicle: If you have your own vehicle or are renting one, you can drive to Vayalur Murugan Temple. The temple is located off the Trichy-Pudukkottai Highway (NH38). You can use GPS navigation or follow signboards to reach the temple.</p>
        </div>
    </div>
    <!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>