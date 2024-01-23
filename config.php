<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/
$host = 'sql6.freemysqlhosting.net';
$username = getenv('db_username');
$password = getenv('db_pwd');
$database = getenv('db_username');

// Create a new mysqli object
$mysqli = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
define('DB_SERVER', 'sql6.freemysqlhosting.net');
define('DB_USERNAME', $username);
define('DB_PASSWORD', $password);
define('DB_NAME', $database);

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
if($conn == false){
    dir('Error: Cannot connect');
}

?>
