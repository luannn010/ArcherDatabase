<?php 
include('dbconnect.php');

function getArcherName()
{
    $conn = getDBConnection();

    $sql = "SELECT ArcherInfo.FirstName, ArcherInfo.LastName, Category.CategoryID
            FROM ArcherInfo
            JOIN Category ON ArcherInfo.ArcherID = Category.ArcherID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<select name='ArcherID'>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CategoryID'] . "'>ID: " . $row['CategoryID'] . " " . $row['FirstName'] . " " . $row['LastName'] . "</option>";
        }
        echo "</select>";
    }

    $conn->close();
}

$selectedCategoryId = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_POST['selectedCategoryId'])) {
        $selectedCategoryId = $_POST['selectedCategoryId'];
    }
}


function getRoundName($selectedCategoryId)
{
    $conn = getDBConnection();

    $sql = "SELECT Category.RoundName
            FROM Category
            WHERE Category.CategoryID = $selectedCategoryId";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $roundName = $row['RoundName'];
        return $roundName;
    }

    $conn->close();
    return null;
}

function getRoundData($roundName)
{
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

$roundName = getRoundName($selectedCategoryId);

// Access the returned roundName and retrieve the round data
if ($roundName) {
    $roundData = getRoundData($roundName);

    // Print the round data
    if ($roundData) {
        echo "Round Name: " . $roundData['roundName'] . "<br>";
        echo "Arrows at 10m: " . $roundData['arrows10m'] . "<br>";
        echo "Arrows at 20m: " . $roundData['arrows20m'] . "<br>";
        echo "Arrows at 30m: " . $roundData['arrows30m'] . "<br>";
        echo "Arrows at 40m: " . $roundData['arrows40m'] . "<br>";
        echo "Arrows at 50m: " . $roundData['arrows50m'] . "<br>";
        echo "Arrows at 60m: " . $roundData['arrows60m'] . "<br>";
        echo "Arrows at 70m: " . $roundData['arrows70m'] . "<br>";
        echo "Arrows at 90m: " . $roundData['arrows90m'] . "<br>";
    } else {
        echo "No round data found.";
    }
} else {
    echo "No round name associated with the selected Category ID.";
}
?>