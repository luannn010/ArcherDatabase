<?php
ob_start();
include ('dbconnect.php');

function getEquipmentUsage() {
  $conn = getDBConnection();

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Equipment, COUNT(*) as Count FROM Category GROUP BY Equipment";
  $result = $conn->query($sql);

  $equipmentLabels = [
    'B' => 'Recurve/Compound Barebow',
    'C' => 'Compound',
    'L' => 'Longbow',
    'R' => 'Recurve'
  ];

  $data = [];
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $equipment = $row['Equipment'];
      $equipmentNames = [];
      for ($i = 0; $i < strlen($equipment); $i++) {
        $code = $equipment[$i];
        if (isset($equipmentLabels[$code])) {
          $equipmentNames[] = $equipmentLabels[$code];
        } else {
          // Fetch the equipment description from the EquipmentDescription table
          $equipmentDesc = getEquipmentDescription($conn, $code);
          $equipmentNames[] = $equipmentDesc ? $equipmentDesc : $code;
        }
      }
      $row['Equipment'] = implode("/", $equipmentNames);
      $data[] = $row;
    }
  }
  header('Content-Type: application/json');
  echo json_encode($data);
  ob_end_flush();

  $conn->close();
}

function getEquipmentDescription($conn, $equipmentCode) {
  $sql = "SELECT EquipmentDescription FROM EquipmentDescription WHERE Equipment = '$equipmentCode'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['EquipmentDescription'];
  }

  return null;
}

getEquipmentUsage();
?>