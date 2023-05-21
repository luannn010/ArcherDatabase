<!DOCTYPE html>
<html>
    <title>Database</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <head>
      <title>Rounds</title>
    </head>
    <body>
      <nav>
        <a href="index.php">Archer Info</a>
        <a href="scores.php">Scores</a>
        <a href="rounds.php">Rounds</a>
        <a href="category.php">Category</a>
      </nav>
      <!-- Archer Information Form -->
      <?php
    function getRoundsData($roundName){
      $conn = getDBConnection();

// Fetch data from table
$sql = "SELECT * FROM Rounds WHERE RoundName = '$roundName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data and assign values to variables
    $row = $result->fetch_assoc();
    $roundName = $row['RoundName'];
    $arrows10m = $row['Arrows10m'];
    $arrows20m = $row['Arrows20m'];
    $arrows30m = $row['Arrows30m'];
    $arrows40m = $row['Arrows40m'];
    $arrows50m = $row['Arrows50m'];
    $arrows60m = $row['Arrows60m'];
    $arrows70m = $row['Arrows70m'];
    $arrows90m = $row['Arrows90m'];
    
    // Close connection
    $conn->close();

    // Return the variables as an array
    return [
        'roundName' => $roundName,
        'arrows10m' => $arrows10m,
        'arrows20m' => $arrows20m,
        'arrows30m' => $arrows30m,
        'arrows40m' => $arrows40m,
        'arrows50m' => $arrows50m,
        'arrows60m' => $arrows60m,
        'arrows70m' => $arrows70m,
        'arrows90m' => $arrows90m
    ];
    } else {
    // Close connection
    $conn->close();

    // Return null if no data found
    return null;
}
}
    
    ?>









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