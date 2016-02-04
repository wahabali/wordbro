<?php 

function getDB(){
    $servername = "127.0.0.1";
    $username = "root";
    $password = "lalakhan";
    $db_name = "db_wordbro";


    // Create connection
    $conn = new mysqli($servername, $username, $password,$db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } 
    return $conn; 
}

?>
