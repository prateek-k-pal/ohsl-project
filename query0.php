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

        $sql = "SELECT `Type of Cancer`, `Stages of Cancer`, `Name of Treatment`, `Description of Treatment`, `Chances of Cure`, `Overall Survival Rate`, `Number Possible Side Effects`, `Quality of Life`, `Financial Cost`, `Required Visits to Hospital` FROM dataset3_txt WHERE `Type of Cancer`='$cancerType' AND `Stages of Cancer`='$cancerStage'";
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



        $s1 = "";
        foreach ($preferences as $key => $value) {
            $s1 .= "$key: $value\n";
        }

        $s2 = "These are the preferences or priorities starting with 1 as highest priority and 6 at the lowesst priority when ranking a treatment:";
        $s2.= $s1;

        echo $s2;

//This line is necessary to load the PHP client installed by Composer
        require_once('./vendor/autoload.php');

        //Change the next line to $yourApiKey = MY_OPENAI_KEY; if you didn't use an environment variable and set your key in a separate file
        //$yourApiKey = getenv('MY_OPENAI_KEY');

        //Create a client object
        $client = OpenAI::client('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');


        $conversation = [
            ["role" => "system", "content" => "You are a user."],
            ["role" => "user", "content" => $s2],
            ["role" => "assistant", "content" => "Rank the following treatments based on my priority given with the user role and only give info about the 'Type of Cancer' and 'Stage of cancer' that's given here: " . implode("\n", $treatments)]
        ];
        //The $prompt variable stores our entire prompt
        $response = $client->chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => $conversation,
            "max_tokens" => 2000,
            "temperature" => 0.5
        ]);
        
        // Get the assistant's reply and extract the ranked treatments
        print_r($response);
        $assistant_reply = $response['choices'][0]['message']['content'];
        $ranked_treatments = explode(': ', $assistant_reply)[1];
        $ranked_treatments = explode(', ', $ranked_treatments);
        
        echo "Ranked treatments: " . implode("\n", $ranked_treatments);

        $conn->close();
    }
    ?>
