<?php

function getDBConnection() {
    $servername = "feenix-mariadb.swin.edu.au";;
    $username = "s103995439";
    $password = "160903";
    $dbname = "s103995439_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

?>

