<?php
    session_start();
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        // Retrieve the user's name from the database based on their username
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login";

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

        h2 {
            color: #333;
        }

        .form-group {
            margin: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], select, textarea {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #4CAF50;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }

        .form_class{
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }
    </style>
    <script>
        function validateForm() {
                var preferences = [];

                for (var i = 1; i <= 6; i++) {
                    var preference = document.getElementById("preference_" + i).value;
                    if (preference < 1 || preference > 6 || preferences.includes(preference)) {
                        document.getElementById("error_" + i).textContent = "Invalid preference. Please enter a number between 1 and 6 that is not already selected.";
                        return false;
                    }
                    preferences.push(preference);
                    document.getElementById("error_" + i).textContent = "";
                }

                return true;
            }
    </script>
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
			Cancer Query
		</div>
		<div class = "body2">
			<form method="POST" action="query2.php" onsubmit="return validateForm()" class="form_class">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input type="text" id="state" name="state" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="cancer_type">Type of Cancer:</label>
            <select id="cancer_type" name="cancer_type" required>
                <option value="">Select Type</option>
                <option value="Leukaemia">Leukaemia</option>
                <option value="Breast Cancer">Breast Cancer</option>
                <option value="Lung Cancer">Lung Cancer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cancer_stage">Stage of Cancer:</label>
            <select id="cancer_stage" name="cancer_stage" required>
                <option value="">Select Stage</option>
                <option value="Stage 1">Stage 1</option>
                <option value="Stage 2">Stage 2</option>
                <option value="Stage 3">Stage 3</option>
                <option value="Stage 4">Stage 4</option>
            </select>
        </div>
        <br>
            <label>Preferences:</label>
				<br>
            <div>
							<div class="form-group">
                <label for="preference_1">A. Best chance of cure:</label>
                <select id="preference_1" name="preference_1" required>							
                    <option value="">Select Priority</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <span id="error_1" class="error"></span>
									</div>
							<div class="form-group">
                <label for="preference_2">B. Longest overall survival:</label>
                <select id="preference_2" name="preference_2" required>
                    <option value="">Select Priority</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
								</div>
							<div class="form-group">
                <span id="error_2" class="error"></span>
                <label for="preference_3">C. Least possible side effects:</label>
                <select id="preference_3" name="preference_3" required>
                    <option value="">Select Priority</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <span id="error_3" class="error"></span>
								</div>
							<div class="form-group">
                <label for="preference_4">D. Best quality of life:</label>
                <select id="preference_4" name="preference_4" required>
                    <option value="">Select Priority</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <span id="error_4" class="error"></span>
								</div>
                <div class="form-group">
									<label for="preference_5">E. Least financial cost:</label>
                <select id="preference_5" name="preference_5" required>
                    <option value="">Select Priority</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <span id="error_5" class="error"></span>
									</div>
							<div class="form-group">
                <label for="preference_6">F. Requiring least visits to hospital:</label>
                <select id="preference_6" name="preference_6" required>
                    <option value="">Select Priority</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <span id="error_6" class="error"></span>
								</div>
            </div>
            <br>
         <input type="submit" class="btn" name="submit" value="Submit">
				</form>
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