<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $name = $_POST['name'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $cancerType = $_POST['cancer_type'];
        $cancerStage = $_POST['cancer_stage'];

        // Retrieve preference ratings
        $preference1 = $_POST['preference_1'];
        $preference2 = $_POST['preference_2'];
        $preference3 = $_POST['preference_3'];
        $preference4 = $_POST['preference_4'];
        $preference5 = $_POST['preference_5'];
        $preference6 = $_POST['preference_6'];

               
        // Database connection
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
        // Retrieve the username from the session

        if(!isset($_SESSION['username']))
        {
            header("location: login.php");
        }
        $username = $_SESSION['username'];

        // Prepare and execute SQL statement to insert data into the user_data table
        $sql = "INSERT INTO user_data (username, name, state, city, cancer_type, cancer_stage, preference_1, preference_2, preference_3, preference_4, preference_5, preference_6) 
        VALUES ('$username', '$name', '$state', '$city', '$cancerType', '$cancerStage', '$preference1', '$preference2', '$preference3', '$preference4', '$preference5', '$preference6')";


        if ($conn->query($sql) === TRUE) {
            $logMessage = "Data inserted successfully.\n";
            $logFile = 'log.txt';
            $dateTime = date('Y-m-d H:i:s');
            file_put_contents($logFile, "$dateTime $logMessage", FILE_APPEND | LOCK_EX);
        } else {
            echo "Error inserting data: " . $conn->error;
        }

        $sql = "SELECT `Type of Cancer`, `Stages of Cancer`, `Name of Treatment`, `Description of Treatment`, `Chances of Cure`, `Overall Survival Rate`, `Number Possible Side Effects`, `Quality of Life`, `Financial Cost`, `Required Visits to Hospital` FROM dataset3_txt WHERE `Type of Cancer`='$cancerType' AND `Stages of Cancer`='$cancerStage'";
        $result = $conn->query($sql);
        $num_rows = mysqli_num_rows($result);

        $treatments=[];

        while ($row = $result->fetch_assoc()) {
            $treatments[] = $row;
        }

        // foreach ($treatments as $item) {
        //     if (is_array($item)) {
        //         echo implode(" ", $item);
        //     } else {
        //         echo $item;
        //     }
        //     echo "\n";
        // }

        $preferences = [
            "Chances of Cure" => $preference1,
            "Overall Survival Rate" => $preference2,
            "Number Possible Side Effects" => $preference3,
            "Quality of Life" => $preference4,
            "Financial Cost" => $preference5,
            "Required Visits to Hospital" => $preference6
        ];



        $s1 = "";
        foreach ($preferences as $key => $value) {
            $s1 .= "$key: $value\n";
        }

        //echo $s1;

//This line is necessary to load the PHP client installed by Composer
        require_once('./vendor/autoload.php');

        //Change the next line to $yourApiKey = MY_OPENAI_KEY; if you didn't use an environment variable and set your key in a separate file
        //$yourApiKey = getenv('MY_OPENAI_KEY');

        //Create a client object
        $client = OpenAI::client('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');

        error_reporting(E_ERROR | E_PARSE);
        //The $prompt variable stores our entire prompt
        $prompt = "Don't add any information other than what is given in this query, don't repeat data and RANK these treatments that are given in the format Type of Cancer, Stages of Cancer,
        Name of Treatment, Description of Treatment, Chances of Cure, Overall Survival Rate, Number of Possible Side Effects,
        Quality of Life, Financial Cost, Required Visits to Hospital:\n\n" . implode("\n",$treatments) . "\n\n on the basis of the following preferences $s1";
        
        error_reporting(E_ALL);
        //We send our prompt along with parameters to the API
        //It creates a completion task
        $response = $client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 1000
        ]);

        //After a few seconds the response will be stored in $results
        //We can print the text answered by GPT
        //echo $response['choices'][0]['text'];


        // $data = json_decode($response, true);
        // foreach ($data as $item) {
        //     if (is_array($item)) {
        //         echo implode(" ", $item);
        //     } else {
        //         echo $item;
        //     }
        //     echo "\n";
        // }
        //$rankedTreatments = $data['choices'];

        // Close connection
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

        table{
            border-collapse: collapse;
            border: 7px solid #000;
            width: 110%;	
        }

        th, td {
            padding: 8px;
            border: 3px solid #bbb;
            text-align: center;
        }

        th{
            background-color: #f2f2f2;
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
			Cancer Query
		</div>
        <table id="treatmentTable">
        <thead>
            <tr>
                <th>Type of Cancer</th>
                <th>Stages of Cancer</th>
                <th>Name of Treatment</th>
                <th>Description of Treatment</th>
                <th>Chances of Cure</th>
                <th>Overall Survival Rate</th>
                <th>Number Possible Side Effects</th>
                <th>Quality of Life</th>
                <th>Financial Cost</th>
                <th>Required Visits to Hospital</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically generated here -->
        </tbody>
        </table>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
        // Parse the response data
        var responseData = `<?php echo $response['choices'][0]['text']; ?>`;

        // Split the response into rows and columns
        var rows = responseData.split('\n');
        var treatments = [];
        rows.forEach(function(row) {
            var columns = row.split(',');
            treatments.push(columns);
        });

        // Generate the table rows dynamically
        var tableBody = document.querySelector('#treatmentTable tbody');
        treatments.forEach(function(treatment) {
            var row = document.createElement('tr');
            treatment.forEach(function(column) {
                var cell = document.createElement('td');
                cell.textContent = column;
                row.appendChild(cell);
            });
            tableBody.appendChild(row);
        });
</script>
</body>
</html>