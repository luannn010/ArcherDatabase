<!DOCTYPE html>
<html>
<head>
  <title>Archer Information</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
  <nav>
    <a href="index.php">Archer Info</a>
    <a href="scores.php">Scores</a>
    <a href="rounds.php">Rounds</a>
    <a href="category.php">Category</a>
  </nav>
  
  <!-- Archer Information Form -->
  <div>
    <h2>Archer Information</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label for="firstName">First name:</label>
      <input type="text" name="firstName" id="firstName">
      <br>
      <label for="lastName">Last name:</label>
      <input type="text" name="lastName" id="lastName">
      Gender: 
      <select name="gender">
        <option value="M">Male</option>
        <option value="F">Female</option>
      </select><br>
      Date of Birth: <input type="date" name="dob"><br>
      <input type="submit" name="add" value="Submit">
    </form>
  </div>
  <h2>Update Archer Information</h2>
</body>
</html>

<?php
  include ('dbconnect.php');

  function addArcherInfo($firstName, $lastName, $gender, $dob) {
    $conn = getDBConnection();

    $sql = "INSERT INTO ArcherInfo (FirstName, LastName, Gender, DOB) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $firstName, $lastName, $gender, $dob);

    if ($stmt->execute()) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
  }
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST["add"])) {
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $gender = $_POST["gender"];
  $dob = $_POST["dob"];
  
  addArcherInfo($firstName, $lastName, $gender, $dob);
}

  function displayArcherInfo() {
    $conn = getDBConnection();

    $sql = "SELECT FirstName, LastName, Gender, DOB FROM ArcherInfo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table><tr><th>First Name</th><th>Last Name</th><th>Gender</th><th>Date of Birth</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["FirstName"]."</td><td>".$row["LastName"]."</td><td>".$row["Gender"]."</td><td>".$row["DOB"]."</td></tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }

    $conn->close();
  }

  function displayArcherSelection() {
    $conn = getDBConnection();

    $sql = "SELECT * FROM ArcherInfo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<form method='post' action=''>";
      echo "<select name='archer'>";
      while ($row = $result->fetch_assoc()) {
        echo "<option value='".$row["ArcherID"]."'>".$row["FirstName"]." ".$row["LastName"]."</option>";
      }
      echo "</select>";
      echo "<input type='submit' name='edit' value='Edit'>";
      echo "</form>";
    } else {
      echo "0 results";
    }

    $conn->close();
  }

  function displayEditForm($ArcherID) {
    $conn = getDBConnection();

    $sql = "SELECT * FROM ArcherInfo WHERE ArcherID=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $ArcherID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<form method='post' action=''>";
        echo "First name: <input type='text' name='firstName' value='".$row["FirstName"]."'><br>";
        echo "Last name: <input type='text' name='lastName' value='".$row["LastName"]."'><br>";
        echo "Gender: <input type='text' name='gender' value='".$row["Gender"]."'><br>";
        echo "DOB: <input type='date' name='dob' value='".$row["DOB"]."'><br>";
        echo "<input type='hidden' name='ArcherID' value='".$ArcherID."'>";
        echo "<input type='submit' name='update' value='Update'>";
        echo "<br>";
        echo "<input type='submit' name='delete' value='Delete'>";
        echo "</form>";
    } else {
        echo "No record found";
    }

    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
  $ArcherID = $_POST["ArcherID"];
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $gender = $_POST["gender"];
  $dob = $_POST["dob"];

  updateArcherInfo($ArcherID, $firstName, $lastName, $gender, $dob);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
  $ArcherID = $_POST["ArcherID"];
  deleteArcherInfo($ArcherID);
}

function deleteArcherInfo($ArcherID) {
  $conn = getDBConnection();

  $sql = "DELETE FROM ArcherInfo WHERE ArcherID=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $ArcherID);

  if ($stmt->execute()) {
      echo "Record deleted successfully";
  } else {
      echo "Error deleting record: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}


  function updateArcherInfo($ArcherID, $firstName, $lastName, $gender, $dob) {
    $conn = getDBConnection();

    $sql = "UPDATE ArcherInfo SET FirstName=?, LastName=?, Gender=?, DOB=? WHERE ArcherID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $firstName, $lastName, $gender, $dob, $ArcherID);

    if ($stmt->execute()) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    displayEditForm($_POST["archer"]);
  } else {
    displayArcherSelection();
  }

  displayArcherInfo();
  ?>
