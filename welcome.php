<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}

    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        // Retrieve the user's name from the database based on their username
        $servername = "sql6.freemysqlhosting.net";
        $username = "sql6634696";
        $password = "ZYsbV2d5f7";
        $dbname = "sql6634696";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the name of the logged-in user
        $username = $_SESSION['username'];
        
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>CancerWebApp</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content=" initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .logo-container {
          display: flex;
          padding: 25px;
          justify-content: center;
          align-items: center;
          flex-direction: column;
          background-image: -webkit-linear-gradient(left, #00AAB0, #0068C8);
        }

        .heading {
          text-align: center;
          margin: 10px;
          font-size: 60px;
          color: black;
          font-family: Times New Roman;
          font-weight: bold;
        }

        .body1 {
          font-size: 40px;
          padding-top: 20px;
          padding-left: 10px;
          padding-right: 10px;
          padding-bottom: 20px;
          background-image: transparent;
        }

        .body2 {
          text-align: justify;
          background-image: transparent;
          font-size: 25px;
          padding-right: 10px;
          padding-left: 10px;
          padding-bottom: 10px;
        }

        .container {
          position: relative;
          overflow: wrap;
        }

        .container::before {
          content: "";
          position: fixed;
          top: -50%;
          left: -100%;
          width: 300%;
          height: 300%;
          background-image: url(https://ohsl.us/sites/default/files/OHSL%20Logo-01-04.png);
          background-repeat: repeat;
          background-size: 10%;
          opacity: 0.15;
          transform: rotate(-45deg);
          pointer-events: none;
          z-index: -1;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="/ohsl_logo.ico">
</head>
<body>
<div class="logo-container">
    <img src="https://ohsl.us/sites/default/files/OHSL%20Logo-01-04.png" style="height: auto; max-width: 23%;">
    <div class="heading">Cancer Treatments</div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="query.php">Cancer Query</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><?php echo $username; ?></a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
        </ul>
    </div>
</nav>
		<div class="container">
		<div class= "body1">
			Welcome,
		</div>
		<div class = "body2">
			<div class="container mt-4">
<h3><?php echo "Welcome ". $_SESSION['username']?> to Cancer Treatments website. Please click on <a href="query.php">Cancer Query (or here)</a> to continue.</h3>
<hr>

</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>
		</div>
	<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<!-- Include jQuery and Select2 library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>
</html>