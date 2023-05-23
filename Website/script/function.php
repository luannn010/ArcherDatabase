<?php
include("dbconnect.php");

function getRounds()
{
    $conn = getDBConnection();

    $sql = "SELECT ArcherInfo.FirstName, ArcherInfo.LastName, Category.CategoryID
            FROM ArcherInfo
            JOIN Category ON ArcherInfo.ArcherID = Category.ArcherID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form method='post' action='scores.php'>";
        echo "<label for='categoryId'>Archer Name</label>";
        echo "<select name='categoryId'>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CategoryID'] . "'>ID: " . $row['CategoryID'] . " " . $row['FirstName'] . " " . $row['LastName'] . "</option>";
        }
        echo "</select>";
        echo "<input type='submit' name='selectCategoryId' value='Select'>";
        echo "</form>";
    } else {
        echo "No Archer Found";
    }

    $conn->close();
}

$selectedCategoryId = null; // Initialize the variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectCategoryId'])) {
    $selectedCategoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_STRING);
}

function getRoundName($categoryId)
{
    $conn = getDBConnection();

    $sql = "SELECT Category.RoundName
            FROM Category
            WHERE Category.CategoryID = $categoryId";

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
// Get Target Face Size
function getTargetFaceSize($arrow){
    $char = substr($arrow,2);
    $conn = getDBConnection();
    $sql = "SELECT FaceDesc
            FROM TargetFaceSizeDescription
            WHERE Target = '$char'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the row from the result set
        $faceSize = $row['FaceDesc'];
        return $faceSize;
    }
    
    $conn->close();
    return null;
}

// Get Number of Ends
function getNoOfEnds($string){
    $integer = intval($string);
    $result = $integer / 6;
    return $result;
}
function splitArrows($x) {
    $arrow = substr($x, 0, 2); // Extract the first two characters representing the distance
   
    return $arrow; // Return an array containing the arrow and char
}
// Call getRounds and displayRounds
getRounds();

$roundName = getRoundName($selectedCategoryId);

// Access the returned roundName and retrieve the round data
if ($roundName) {
    $roundData = getRoundData($roundName);
    $ranges = array(); // Dictionary for storing the ends data
    
    // Print the round data
    $ranges = array(); // Initialize the $ranges array

// Loop from 10m to 90m with a step of 10
for ($distance = 10; $distance <= 90; $distance += 10) {
     // Skip 80m
     if ($distance === 80) {
        continue;
    }
    $attribute = $distance . "m"; // Generate the distance label (e.g., "10m", "20m", etc.)
       
    // Check if the arrows distance is not zero
    if ($roundData['arrows' . $attribute] != 0) {
        $arrows = splitArrows($roundData['arrows' . $attribute]);
        $faceSize = getTargetFaceSize($roundData['arrows' . $attribute]);
        $ends = getNoOfEnds($arrows);

        $ranges[$attribute] = array(
            'Arrow' => $arrows,
            'FaceSize' => $faceSize,
            'NoOfEnds' => $ends
        );
    }
}
  
 } else {
    echo "No round name associated with the selected Category ID.";
}
function endNoList($number) {
    $Ends = array();

    for ($i = 1; $i <= $number; $i++) {
        $Ends[] = "End" . $i;
    }

    return $Ends;
}


echo "<pre>";
print_r($ranges);


?>
