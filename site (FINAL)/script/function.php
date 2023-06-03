<?php
include("dbconnect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function getRounds()
{
    $conn = getDBConnection();

    $sql = "SELECT ArcherInfo.FirstName, ArcherInfo.LastName, Category.CategoryID
            FROM ArcherInfo
            JOIN Category ON ArcherInfo.ArcherID = Category.ArcherID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form method='post' action='scores.php'>";

        getEquipment();
        echo "<label for='categoryId'>Archer Name</label>";
        
        echo "<select name='categoryId'>";
        
        while ($row = $result->fetch_assoc()) {
            $archerName = $row['FirstName'] . " " . $row['LastName'];
            echo "<option value='" . $row['CategoryID'] . "'>ID: " . $row['CategoryID'] . " " . $archerName . "</option>";
        }
        
        echo "</select>";
        echo "<input type='submit' name='selectCategoryId' value='Select'>";
        echo "</form>";
    } else {
        echo "No Archer Found";
    }

    $conn->close();
}

// Get Archer Equipment
function getEquipment() {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM `EquipmentDescription`";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<lable for='Equipment'>Equipment:</lable>";
        echo "<select name='EquipmentDescription'>";
        while($row = $result->fetch_assoc()) {
            echo "<option value='".$row['EquipmentDescription']."'>".$row['EquipmentDescription']."</option>";
        }
        echo "</select>";
    }
    $conn->close();
}

//get Archer full name
function getArcherFullName($categoryID) {
    $conn = getDBConnection();
    
    $sql = "SELECT ArcherInfo.FirstName, ArcherInfo.LastName
            FROM ArcherInfo
            JOIN Category ON ArcherInfo.ArcherID = Category.ArcherID
            WHERE Category.CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName);
    
    $fullName = null;
    if ($stmt->fetch()) {
        $fullName = $firstName . " " . $lastName;
    }
    
    $stmt->close();
    $conn->close();
    
    return $fullName;
}


function getDistanceForm($categoryId, $equipment) {
    $RoundName = getRoundName($categoryId);
    $ranges = getRanges($categoryId);
    
    echo "<h2>".$RoundName."</h2>";
   
    echo "<h2>" . getArcherFullName($categoryId) . ", " . $equipment . "</h2>";
    
    // Select distance
    echo "<form method='post'>";
    echo "<label for='distance'>Select Distance:</label>";
    echo "<select name='distance'>";
    
    // Iterate over the distances in the $ranges array
    foreach ($ranges as $distance => $data) {
        $targetFaceSize = $data['FaceSize'];
        $distanceNFace = $distance . ' - Target Size: ' . $targetFaceSize;
        echo "<option value='" . $distanceNFace . "'>" . $distanceNFace . "</option>";
    }
    
    echo "</select>";
    echo "<input type='submit' name='selectDistance' value='Select Distance'>";
    echo "</form>";
}

getRounds();



function selectDistance() {
    $selectedCategoryId = null;
    $selectedEquipment = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectCategoryId'])) {
        $selectedCategoryId = $_POST['categoryId'];
        $selectedEquipment = $_POST['EquipmentDescription'];
        getDistanceForm($selectedCategoryId, $selectedEquipment);

        echo "<script>";
        echo "document.getElementsByTagName('form')[0].style.display = 'none';";
        echo "</script>";
    }

    return [$selectedCategoryId, $selectedEquipment];
}

list($selectedCategoryId, $selectedEquipment) = selectDistance();

echo $selectedCategoryId;


function selectEndNo($categoryId,$Equipment) {
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectDistance'])) {
    $selectedDistance = $_POST['distance'];
    

    var_dump($categoryId, $Equipment, $selectedDistance);
    echo "<h2>".getRoundName($categoryId)."</h2>";

    echo "<h2>" . getArcherFullName($categoryId) . ", " . $Equipment . "</h2>";
    echo "<h2>Selected Distance: " . $selectedDistance . "</h2>";

    
    // Close the first form
    echo "</form>";
    
    // Create form for selecting End No List
    echo "<form method='post'>";
    echo "<label for='endNoList'>Select End No:</label>";
    echo "<select name='endNoList'>";
    
    $endNumbers = endNoList($ranges[$selectedDistance]['EndNoList']);
//NoOfEnds
    foreach ($endNumbers as $endNo) {
        echo "<option value='" . $endNo . "'>" . $endNo . "</option>";
    }
    
    echo "</select>";
    echo "<input type='submit' name='selectEndNo' value='Select End No'>";
    echo "</form>";
    
    echo "<script>";
    echo "document.getElementsByTagName('form')[0].style.display = 'none';";
    echo "</script>";
}
}

function handleEndSelection($categoryId, $equipment) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectEndNo'])) {
        $selectedEnd = $_POST['endNoList'];
        $archerName = getArcherFullName($categoryId);

        echo "<h2>".getRoundName($categoryId)."</h2>";
        echo "<h2>" . $archerName . ", " . $equipment . "</h2>";
        echo "<h2>Selected End: " . $selectedEnd . "</h2>";
    }
}

// getRounds();

// list($selectedCategoryId, $selectedEquipment) = selectDistance();

selectEndNo($selectedCategoryId, $selectedEquipment);

handleEndSelection($selectedCategoryId, $selectedEquipment);









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

function endNoList($number) {
    $Ends = array();

    for ($i = 1; $i <= $number; $i++) {
        $Ends[] = "End" . $i;
    }

    return $Ends;
}


function getRanges($categoryId){
    $roundName = getRoundName($categoryId);
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
            'NoOfEnds' => $ends,
            'EndNoList' => endNoList($ends)
        );

    }
}
 return $ranges; 
 }
}

$ranges = getRanges($selectedCategoryId);
echo "<pre>";
print_r($ranges);
echo "</pre>";


?>