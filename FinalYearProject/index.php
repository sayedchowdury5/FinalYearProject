<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login_main\login_main.php');
  }

  $username = $_SESSION['username'];
  $sql = "SELECT * FROM register WHERE username='$username'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>IoT based Hydroponics Agriculture</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
  body {
    font: 400 15px/1.8 Lato, sans-serif;
    color: #777;
  }
  h3, h4 {
    margin: 10px 0 30px 0;
    letter-spacing: 10px;      
    font-size: 20px;
    color: #111;
  }
  .container {
    padding: 80px 120px;
  }
  .person {
    border: 10px solid transparent;
    margin-bottom: 25px;
    width: 80%;
    height: 80%;
    opacity: 0.7;
  }
  .person:hover {
    border-color: #f1f1f1;
  }
  .carousel-inner img {
    -webkit-filter: grayscale(90%);
    filter: grayscale(90%); /* make all photos black and white */ 
    width: 100%; /* Set width to 100% */
    margin: auto;
  }
  .carousel-caption h3 {
    color: #fff !important;
  }
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
    }
  }
  .bg-1 {
    background: #2d2d30;
    color: #bdbdbd;
  }
  .bg-1 h3 {color: #fff;}
  .bg-1 p {font-style: italic;}
  .list-group-item:first-child {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
  }
  .list-group-item:last-child {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }
  .thumbnail {
    padding: 0 0 15px 0;
    border: none;
    border-radius: 0;
  }
  .thumbnail p {
    margin-top: 15px;
    color: #555;
  }
  .btn {
    padding: 10px 20px;
    background-color: #333;
    color: #f1f1f1;
    border-radius: 0;
    transition: .2s;
  }
  .btn:hover, .btn:focus {
    border: 1px solid #333;
    background-color: #fff;
    color: #000;
  }
  .modal-header, h4, .close {
    background-color: #333;
    color: #fff !important;
    text-align: center;
    font-size: 30px;
  }
  .modal-header, .modal-body {
    padding: 40px 50px;
  }
  .nav-tabs li a {
    color: #777;
  }
  #googleMap {
    width: 100%;
    height: 400px;
    -webkit-filter: grayscale(100%);
    filter: grayscale(100%);
  }  
  .navbar {
    font-family: Montserrat, sans-serif;
    margin-bottom: 0;
    background-color: #2d2d30;
    border: 0;
    font-size: 11px !important;
    letter-spacing: 4px;
    opacity: 0.9;
  }
  .navbar li a, .navbar .navbar-brand { 
    color: #d5d5d5 !important;
  }
  .navbar-nav li a:hover {
    color: #fff !important;
  }
  .navbar-nav li.active a {
    color: #fff !important;
    background-color: #29292c !important;
  }
  .navbar-default .navbar-toggle {
    border-color: transparent;
  }
  .open .dropdown-toggle {
    color: #fff;
    background-color: #555 !important;
  }
  .dropdown-menu li a {
    color: #000 !important;
  }
  .dropdown-menu li a:hover {
    background-color: red !important;
  }
  footer {
    background-color: #f5f5f5;
    color: #2d2d30;
    padding: 32px;
  }
  footer a {
    color: #f5f5f5;
  }
  footer a:hover {
    color: #777;
    text-decoration: none;
  }  
  .form-control {
    border-radius: 0;
  }
  textarea {
    resize: none;
  }
  .black, .black a {
  color: #2d2d30;
  }
  </style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage"> <?php echo $row['username']; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#myPage">HOME</a></li>
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#contact">CONTACT</a></li>
        <li><a href="monitor.php">MONITOR</a></li>
        <li><a href="control.php">CONTROL</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="images/IMG_3272.jpg" alt="New York" width="1100" height="600">
        <div class="carousel-caption">
          <h3>Dedicated</h3>
          <p>Intensive class to make sure students are learning something</p>
        </div>      
      </div>

      <div class="item">
        <img src="images/IMG_3463.jpg" alt="Chicago" width="1100" height="600">
        <div class="carousel-caption">
          <h3>Alacrity</h3>
          <p>Supportive academic advisor to guide students</p>
        </div>      
      </div>
    
      <div class="item">
        <img src="images/IMG_123.jpg" alt="Los Angeles" width="1100" height="600">
        <div class="carousel-caption">
          <h3>Iconic</h3>
          <p>Great input produce great output</p>
        </div>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>

<!-- Container (About Section) -->
<div id="about" class="container text-center">
  <h3>ABOUT IMCHA</h3>
  <p>IMCHA or IoT-based Monitoring and Controlling Web System for Hydroponics Agriculture is a final year project under faculty of computer science and information technology in UNIMAS by recognising the needs and requirements of a growing entrepreneurs in malaysia, especially Sarawak. IMCHA project is run by Mr Abu Sayed (Student of FCSIT, UNIMAS) with supervison of Profesor Madya Dr. Noor Alamshah B. Bolhassan (Lecturer/Supervisor).</p>
  <p>IMCHA project is a unique innovation with a creative approach and approved methods to build an inclusive  community in the country.</p>
  <br>
  <div class="row">
    <div class="col-sm-6">
      <p class="text-center"><strong>Mr Abu Sayed</strong></p><br>
      <a href="#demo" data-toggle="collapse">
        <img src="images/dp1.jpg" class="img-circle person" alt="Sharnaz Saberi" width="250" height="250">
      </a>
      <div id="demo" class="collapse">
        <!--<p>Runs Prodigy Music Centre</p>-->
        <!--<p>Loves 'Laksa Sarawak' and 'Mi Kolok'</p>-->
        <!--<p>Born on 1975</p>-->
      </div>
    </div>
    <div class="col-sm-6">
      <p class="text-center"><strong>Assoc. Prof. Dr. Noor Alamshah</strong></p><br>
      <a href="#demo2" data-toggle="collapse">
        <img src="images/co-founder.png" class="img-circle person" alt="Co-Founder Image" width="250" height="250">
      </a>
      <div id="demo2" class="collapse">
        <!--<p>Drummer</p>-->
        <!--<p>Loves drummin'</p>-->
        <!--<p>Member since 1988</p>-->
      </div>
    </div>
  </div>
</div>

<!-- Container (Contact Section) -->
<div id="contact" class="bg-1">
  <div class="container">
    <h3 class="text-center">Contact Us</h3>

    <div class="row">
      <div class="col-md-4">
        <p>Have something to ask? Drop a note.</p>
        <p><span class="glyphicon glyphicon-map-marker"></span>Universiti Malaysia Sarawak</p>
        <p><span class="glyphicon glyphicon-phone"></span>Phone: +601110445260</p>

        <p><span class="glyphicon glyphicon-envelope"></span>Email: sayedchowdury5@gmail.com</p>
      </div>
      <div class="col-md-8">
        <form method="POST" action="mail_handler.php">
          <div class="row">
            <div class="col-sm-6 form-group">
              <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
            </div>
            <div class="col-sm-6 form-group">
              <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
            </div>
          </div>
          <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5" required></textarea>
          <br>
          <div class="row">
            <div class="col-md-12 form-group">
              <button class="btn btn-secondary pull-right" type="submit" name="submit">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="text-center">
  <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up black"></span>
  </a><br><br>
  <p>Copyright Reserved. &copy; <?php echo date("Y"); ?></p> 
</footer>

<script>
$(document).ready(function(){
  // Initialize Tooltip
  $('[data-toggle="tooltip"]').tooltip(); 
  
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {

      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
})
</script>

</body>
</html>
