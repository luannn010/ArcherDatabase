<?php
ob_start();
include ('dbconnect.php');

function getClassDistribution() {
  $conn = getDBConnection();

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Class, COUNT(*) as Count FROM Category GROUP BY Class";
  $result = $conn->query($sql);

  $data = [];
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
  }
  header('Content-Type: application/json');
  echo json_encode($data);
  ob_end_flush();

  $conn->close();
}

getClassDistribution();
?>
