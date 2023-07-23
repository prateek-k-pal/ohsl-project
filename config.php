<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/
$host = 'sql6.freemysqlhosting.net';
$username = 'sql6634696';
$password = 'ZYsbV2d5f7';
$database = 'sql6634696';

// Create a new mysqli object
$mysqli = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
define('DB_SERVER', 'sql6.freemysqlhosting.net');
define('DB_USERNAME', 'sql6634696');
define('DB_PASSWORD', 'ZYsbV2d5f7');
define('DB_NAME', 'sql6634696');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
if($conn == false){
    dir('Error: Cannot connect');
}

?>
