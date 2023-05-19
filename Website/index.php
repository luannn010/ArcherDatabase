<!DOCTYPE html>
<html>
    <title>Database</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <head>
      <title>Archer Information</title>
    </head>
    <body>
      <nav>
        <a href="index.php">Archer Info</a>
        <a href="scores.php">Scores</a>
        <a href="rounds.php">Rounds</a>
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
          <input type="submit" value="Submit">
        </form>
      </div>
    </body>
</html>

<?php
include ('dbconnect.php');

function addArcherInfo($firstName, $lastName, $gender, $dob) {
    $conn = getDBConnection();

    $sql = "INSERT INTO ArcherInfo (FirstName, LastName, Gender, DOB) VALUES ('$firstName', '$lastName', '$gender', '$dob')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    
    addArcherInfo($firstName, $lastName, $gender, $dob);
}
?>
