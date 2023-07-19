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

        $sql = "SELECT * FROM dataset3_txt WHERE `Type of Cancer`='$cancerType' AND `Stages of Cancer`='$cancerStage'";
        $result = $conn->query($sql);
        $num_rows = mysqli_num_rows($result);

        $treatments=[];

        while ($row = $result->fetch_assoc()) {
            $treatments[] = $row;
        }

        foreach ($treatments as $item) {
            if (is_array($item)) {
                echo implode(" ", $item);
            } else {
                echo $item;
            }
            echo "\n";
        }

        $preferences = [
            "Chances of Cure" => $preference1,
            "Overall Survival Rate" => $preference2,
            "Number Possible Side Effects" => $preference3,
            "Quality of Life" => $preference4,
            "Financial Cost" => $preference5,
            "Required Visits to Hospital" => $preference6
        ];

        $url = "https://api.openai.com/v1/completions";

        $s1 = "";
        foreach ($preferences as $key => $value) {
            $s1 .= "$key: $value\n";
        }

        echo $s1;

        $params = [
            "prompt" => "Give me a list of cancer treatment options, ranked according to the following preferences:\n $s1.",
            "temperature" => 0.7,
            "max_tokens" => 100,
            "engine" => "davinci-codex",
            "model" => "text-davinci-003",
            //"treatments" => $treatments,
        ];
        $headers = [
            "Authorization: Bearer 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",
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);

        if ($response === false) {
            echo "Error executing the API request: " . curl_error($curl);
            // Handle the error case here
        } else {
            $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            if ($httpStatusCode === 200) {
                // API call was successful, process the response
                $data = json_decode($response, true);
                // ...
            } else {
                echo "API request failed with status code: " . $httpStatusCode;
                // Handle the error case here
            }
        }

        curl_close($curl);

        $data = json_decode($response, true);
        foreach ($data as $item) {
            if (is_array($item)) {
                echo implode(" ", $item);
            } else {
                echo $item;
            }
            echo "\n";
        }
        //$rankedTreatments = $data['choices'];

        // Close connection
        $conn->close();
    }
    ?>



