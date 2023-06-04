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
      <div>
        <h2>Add a Round</h2>
        <form method="post" action="rounds.php">
          <label for="roundName">Round name:</label>
          <input type="text" name="roundName" id="roundName">
          <br>
          <label for="arrows90m">Arrows 90m:</label>
          <input type="text" name="arrows90m" id="arrows90m">
          <br>
          <label for="arrows70m">Arrows 70m:</label>
          <input type="text" name="arrows70m" id="arrows70m">
          <br>
          <!-- Add similar input fields for all other distances -->
          <label for="arrows60m">Arrows 60m:</label>
          <input type="text" name="arrows60m" id="arrows60m">
          <br>
          <label for="arrows50m">Arrows 50m:</label>
          <input type="text" name="arrows50m" id="arrows50m">
          <br>
          <label for="arrows40m">Arrows 40m:</label>
          <input type="text" name="arrows40m" id="arrows40m">
          <br>
          <label for="arrows30m">Arrows 30m:</label>
          <input type="text" name="arrows30m" id="arrows30m">
          <br>
          <label for="arrows20m">Arrows 20m:</label>
          <input type="text" name="arrows20m" id="arrows20m">
          <br>
          <label for="arrows10m">Arrows 10m:</label>
          <input type="text" name="arrows10m" id="arrows10m">
          <br>
          <input type="submit" value="Add Round">
        </form>
      </div>
      <h2>Update Rounds</h2>
      <div id="editRound"></div>
      <script>
        // Use JavaScript to populate the 'editRound' div with the selected round details
        function editRound(details) {
            document.getElementById('editRound').innerHTML = details;
        }
      </script>
    </body>
</html>

<?php
include('dbconnect.php');

function addRound($roundName, $arrows90m, $arrows70m, $arrows60m, $arrows50m, $arrows40m, $arrows30m, $arrows20m, $arrows10m)
{
    $conn = getDBConnection();

    $sql = "INSERT INTO Rounds (RoundName, Arrows90m, Arrows70m, Arrows60m, Arrows50m, Arrows40m, Arrows30m, Arrows20m, Arrows10m) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $roundName, $arrows90m, $arrows70m, $arrows60m, $arrows50m, $arrows40m, $arrows30m, $arrows20m, $arrows10m);

    if ($stmt->execute()) {
        // echo "New round added successfully";
    } else {
        // echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['selectRound'])) {
    $roundName = isset($_POST['roundName']) ? $_POST['roundName'] : '';
    $arrows90m = isset($_POST['arrows90m']) ? $_POST['arrows90m'] : '';
    $arrows70m = isset($_POST['arrows70m']) ? $_POST['arrows70m'] : '';
    $arrows60m = isset($_POST['arrows60m']) ? $_POST['arrows60m'] : '';
    $arrows50m = isset($_POST['arrows50m']) ? $_POST['arrows50m'] : '';
    $arrows40m = isset($_POST['arrows40m']) ? $_POST['arrows40m'] : '';
    $arrows30m = isset($_POST['arrows30m']) ? $_POST['arrows30m'] : '';
    $arrows20m = isset($_POST['arrows20m']) ? $_POST['arrows20m'] : '';
    $arrows10m = isset($_POST['arrows10m']) ? $_POST['arrows10m'] : '';

    if (!empty($roundName)) { // Check if round name is not empty
        addRound($roundName, $arrows90m, $arrows70m, $arrows60m, $arrows50m, $arrows40m, $arrows30m, $arrows20m, $arrows10m);
    }
}

// Display all rounds
function displayRounds()
{
    $conn = getDBConnection();

    $sql = "SELECT * FROM Rounds";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Round Name</th><th>Arrows 90m</th><th>Arrows 70m</th><th>Arrows 60m</th><th>Arrows 50m</th><th>Arrows 40m</th><th>Arrows 30m</th><th>Arrows 20m</th><th>Arrows 10m</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["RoundName"] . "</td><td>" . $row["Arrows90m"] . "</td><td>" . $row["Arrows70m"] . "</td><td>" . $row["Arrows60m"] . "</td><td>" . $row["Arrows50m"] . "</td><td>" . $row["Arrows40m"] . "</td><td>" . $row["Arrows30m"] . "</td><td>" . $row["Arrows20m"] . "</td><td>" . $row["Arrows10m"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No Rounds Found";
    }

    $conn->close();
}

function getRounds()
{
    $conn = getDBConnection();

    $sql = "SELECT * FROM Rounds";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form method='post' action='rounds.php'>";
        echo "<select name='roundId'>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['RoundName'] . "'>" . $row['RoundName'] . "</option>";
        }
        echo "</select>";
        echo "<input type='submit' name='selectRound' value='Select'>";
        echo "</form>";
    } else {
        echo "No Rounds Found";
    }

    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectRound'])) {
    $selectedRound = filter_input(INPUT_POST, 'roundId', FILTER_SANITIZE_STRING);
    // Fetch details of the selected round
    $conn = getDBConnection();
    $sql = "SELECT * FROM Rounds WHERE RoundName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedRound);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the selected round details in an editable form
        echo "<script>document.getElementById('roundForm').style.display = 'none';</script>";
        echo "<form method='post' action='rounds.php' id='editRoundForm'>";
        echo "<label for='roundName'>Round name:</label>";
        echo "<input type='text' name='roundName' id='roundName' value='" . $row['RoundName'] . "'>";

        echo "<label for='arrows90m'>Arrows 90m:</label>";
        echo "<input type='text' name='arrows90m' id='arrows90m' value='" . $row['Arrows90m'] . "'>";

        echo "<label for='arrows70m'>Arrows 70m:</label>";
        echo "<input type='text' name='arrows70m' id='arrows70m' value='" . $row['Arrows70m'] . "'>";

        echo "<label for='arrows60m'>Arrows 60m:</label>";
        echo "<input type='text' name='arrows60m' id='arrows60m' value='" . $row['Arrows60m'] . "'>";

        echo "<label for='arrows50m'>Arrows 50m:</label>";
        echo "<input type='text' name='arrows50m' id='arrows50m' value='" . $row['Arrows50m'] . "'>";

        echo "<label for='arrows40m'>Arrows 40m:</label>";
        echo "<input type='text' name='arrows40m' id='arrows40m' value='" . $row['Arrows40m'] . "'>";

        echo "<label for='arrows30m'>Arrows 30m:</label>";
        echo "<input type='text' name='arrows30m' id='arrows30m' value='" . $row['Arrows30m'] . "'>";

        echo "<label for='arrows20m'>Arrows 20m:</label>";
        echo "<input type='text' name='arrows20m' id='arrows20m' value='" . $row['Arrows20m'] . "'>";

        echo "<label for='arrows10m'>Arrows 10m:</label>";
        echo "<input type='text' name='arrows10m' id='arrows10m' value='" . $row['Arrows10m'] . "'>";
        // Repeat for other distances...
        echo "<input type='submit' name='updateRound' value='Update Round'>";
        echo "<br>";
        echo "<input type='submit' name='deleteRound' value='Delete Round'>";
        echo "</form>";
    } else {
        echo "No round found with the selected ID";
    }
    $conn->close();
}

function updateRound($roundName, $arrows90m, $arrows70m, $arrows60m, $arrows50m, $arrows40m, $arrows30m, $arrows20m, $arrows10m)
{
    $conn = getDBConnection();

    $sql = "UPDATE Rounds SET Arrows90m=?, Arrows70m=?, Arrows60m=?, Arrows50m=?, Arrows40m=?, Arrows30m=?, Arrows20m=?, Arrows10m=? WHERE RoundName=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $arrows90m, $arrows70m, $arrows60m, $arrows50m, $arrows40m, $arrows30m, $arrows20m, $arrows10m, $roundName);

    if ($stmt->execute()) {
        // echo "Round updated successfully";
    } else {
        // echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function deleteRound($roundName)
{
    $conn = getDBConnection();

    $sql = "DELETE FROM Rounds WHERE RoundName=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roundName);

    if ($stmt->execute()) {
        // echo "Round deleted successfully";
    } else {
        // echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteRound'])) {
    $roundName = isset($_POST['roundName']) ? $_POST['roundName'] : '';
    if (!empty($roundName)) { // Check if round name is not empty
        deleteRound($roundName);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateRound'])) {
    $roundName = isset($_POST['roundName']) ? $_POST['roundName'] : '';
    $arrows90m = isset($_POST['arrows90m']) ? $_POST['arrows90m'] : '';
    $arrows70m = isset($_POST['arrows70m']) ? $_POST['arrows70m'] : '';
    $arrows60m = isset($_POST['arrows60m']) ? $_POST['arrows60m'] : '';
    $arrows50m = isset($_POST['arrows50m']) ? $_POST['arrows50m'] : '';
    $arrows40m = isset($_POST['arrows40m']) ? $_POST['arrows40m'] : '';
    $arrows30m = isset($_POST['arrows30m']) ? $_POST['arrows30m'] : '';
    $arrows20m = isset($_POST['arrows20m']) ? $_POST['arrows20m'] : '';
    $arrows10m = isset($_POST['arrows10m']) ? $_POST['arrows10m'] : '';

    if (!empty($roundName)) { // Check if round name is not empty
        updateRound($roundName, $arrows90m, $arrows70m, $arrows60m, $arrows50m, $arrows40m, $arrows30m, $arrows20m, $arrows10m);
    }
}

// Call getRounds and displayRounds
getRounds();
displayRounds();
?>