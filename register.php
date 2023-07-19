

<?php
require_once "config.php";   //connects config.php
//variables
$username = $password = $confirm_password = $State =$City= "";
  //error variables
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
  $City = $_POST['City'];
  $State = $_POST['State'];
    // $sql = "INSERT INTO users (username, password,City,State) VALUES (?, ?,?,?)";
    $sql = "INSERT INTO users (username, password, City, State) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        // mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $City, $State);


        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);  
        //makes the password hidden

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    // mysqli_stmt_close($stmt);
    // mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $City, $State);

}
mysqli_close($conn);
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
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="body1">Register</div>
    <div class="body2">
        <div class="container mt-4">
            <h3>Please Register Here:</h3>
            <hr>
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Username</label>
                        <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" name="password" id="inputPassword4"
                               placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword4">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="inputPassword"
                           placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <label for="inputAddress2">Address 2</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity" name="City">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" class="form-control" name="State">
                            <option selected>Choose...</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Check me out
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
        </div>
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

<script>
    $(document).ready(function() {
          // Array of Indian states and union territories
          var states = [
            "Andaman and Nicobar Islands",
            "Andhra Pradesh",
              "Arunachal Pradesh",
              "Assam",
                "Bihar",
                "Chandigarh",
                  "Chhattisgarh", "Dadra and Nagar Haveli and Daman and Diu (merged)",
                  "Delhi (National Capital Territory of Delhi)", 
                  "Goa",
                    "Gujarat", 
                    "Haryana", 
                    "Himachal Pradesh",
                    "Jammu and Kashmir" ,
                      "Jharkhand",
                      "Karnataka", 
                      "Kerala",
                        "Ladakh ",
                        "Lakshadweep", 
                        "Madhya Pradesh", 
                        "Maharashtra", 
                        "Manipur", 
                        "Meghalaya", 
                        "Mizoram", 
                        "Nagaland", 
                        "Odisha ", 
                        "Puducherry ", 
                        "Punjab", 
                        "Rajasthan", 
                        "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal"
            // Add more states here...
          ];

          // Initialize Select2 on the dropdown element
          $('#inputState').select2({
            data: states,
            placeholder: "Choose..."
          });
        });
</script>
</body>
</html>