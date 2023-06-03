<?php
include('dbconnect.php');


// Get Archer Full Name from CategoryID
function ArcherFullName($categoryId){
    $conn = getDBConnection();

    $sql = "SELECT ArcherInfo.FirstName, ArcherInfo.LastName
            FROM ArcherInfo
            JOIN Category ON ArcherInfo.ArcherID = Category.ArcherID
            WHERE Category.CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
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

// Get Round Name from CategoryID
function RoundName($categoryId) {
    $conn = getDBConnection();

    $sql = "SELECT Category.RoundName FROM Category WHERE Category.CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $stmt->bind_result($roundName);

    $roundNameValue = null;
    if ($stmt->fetch()) {
        $roundNameValue = $roundName;
    }

    $stmt->close();
    $conn->close();

    return $roundNameValue;
}
// Get Round Data from Round Name
function RoundData($roundName) {
    $conn = getDBConnection();

    $sql = "SELECT * FROM Rounds WHERE RoundName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roundName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
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

        $conn->close();

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
        $conn->close();
        return null;
    }
}
// Get the Ranges from CategoryID
    // Split Arrows from the Arrow per Distance
    function Arrows($arrowNFace) {
        $arrow = substr($arrowNFace, 0, 2);
        return $arrow;
    }
    // Split TargetFaceSize from Arrow per Distance
    function TargetFaceSize($arrow) {
        $char = substr($arrow, 2);
        $conn = getDBConnection();
        $sql = "SELECT FaceDesc FROM TargetFaceSizeDescription WHERE Target = '$char'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $faceSize = $row['FaceDesc'];
            return $faceSize;
        }
    
        $conn->close();
        return null;
    }    // Get Number of Ends from arrows per distance
    function NoOfEnds($arrow) {
        $arrow = intval($arrow);
        $noOfEnds = $arrow / 6;
        return $noOfEnds;
    }
        // Get End Number List from the No of Ends
    function endNoList($number) {
        $ends = array();
    
        for ($i = 1; $i <= $number; $i++) {
            $ends[] = "End" . $i;
        }
    
        return $ends;
    }    // Ranges
    function Ranges($categoryId) {
        $roundName = RoundName($categoryId);
    
        if ($roundName) {
            $roundData = RoundData($roundName);
            $ranges = array();
    
            for ($distance = 10; $distance <= 90; $distance += 10) {
                if ($distance === 80) {
                    continue;
                }
    
                $attribute = $distance . "m";
    
                if ($roundData['arrows' . $attribute] != 0) {
                    $arrows = Arrows($roundData['arrows' . $attribute]);
                    $faceSize = TargetFaceSize($roundData['arrows' . $attribute]);
                    $ends = NoOfEnds($arrows);
    
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
    
        return null;
    }
function selectArcherEquipment(){
{
    $conn = getDBConnection();

    $sql = "SELECT * FROM `EquipmentDescription`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<label for='Equipment'>Equipment:</label>";
        echo "<select name='EquipmentDescription'>";

        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['EquipmentDescription'] . "'>" . $row['EquipmentDescription'] . "</option>";
        }

        echo "</select>";
    }

    $conn->close();
}
}
// Create A First From to get CategoryID and The Equipment
function selectCategoryAndEquipmentForm()
{
    $conn = getDBConnection();

    $sql = "SELECT ArcherInfo.FirstName, ArcherInfo.LastName, Category.CategoryID
            FROM ArcherInfo
            JOIN Category ON ArcherInfo.ArcherID = Category.ArcherID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form method='get' action='scores.php'>";
        
        echo "<label for='categoryId'>Archer Name</label>";
        echo "<select name='categoryId'>";

        while ($row = $result->fetch_assoc()) {
            $archerName = $row['FirstName'] . " " . $row['LastName'];
            echo "<option value='" . $row['CategoryID'] . "'>ID: " . $row['CategoryID'] . " " . $archerName . "</option>";
        }

        echo "</select>";
        selectArcherEquipment();
        echo "<input type='submit' name='selectCategoryId' value='Select'>";
        echo "</form>";
    } else {
        echo "No Archer Found";
    }

    $conn->close();
}

function selectDistanceForm($categoryId, $equipment, $selectedDistance = null) {
    $roundName = RoundName($categoryId);
    $ranges = Ranges($categoryId);

    echo "<h2>" . $roundName . "</h2>";
    echo "<h2>" . ArcherFullName($categoryId) . ", " . $equipment . "</h2>";
    echo "<form method='get'>";
    echo "<label for='distance'>Select Distance:</label>";
    echo "<select name='distance'>";

    foreach ($ranges as $distance => $data) {
        $targetFaceSize = $data['FaceSize'];
        $distanceNFace = $distance . ' - Target Size: ' . $targetFaceSize;

        // Check if the current distance matches the selected distance
        $selected = ($selectedDistance === $distanceNFace) ? "selected" : "";

        echo "<option value='" . $distanceNFace . "' " . $selected . ">" . $distanceNFace . "</option>";
    }
    echo "</select>";

    echo "<input type='hidden' name='categoryId' value='" . $categoryId . "'>";
    echo "<input type='hidden' name='EquipmentDescription' value='" . $equipment . "'>";
    echo "<input type='submit' name='selectDistance' value='Select Distance'>";
    echo "</form>";
    echo "<script>";
    echo "document.querySelector('form[action=\"scores.php\"]').style.display = 'none';";
    echo "</script>";
}


// Select EnNo list
function extractDistance($distanceNFace)
{
    // Extract the distance portion from the string
    $distance = strtok($distanceNFace, " -");

    // Return the extracted distance
    return $distance;
}


function selectEndsForm($categoryId, $distance)
{
    $ranges = Ranges($categoryId);

    if (isset($ranges[$distance])) {
        $range = $ranges[$distance];
        if (isset($range['EndNoList'])) {
            $endNoList = $range['EndNoList'];
            echo "<form method='get' action=''>";
            echo "<input type='hidden' name='categoryId' value='$categoryId'>";
            echo "<input type='hidden' name='distance' value='$distance'>";
            
            echo "<label for='endNo'>Select End No:</label>";
            echo "<select name='endNo' id='endNo'>";
            foreach ($endNoList as $endNo) {
                echo "<option value='$endNo'>$endNo</option>";
            }
            echo "</select>";
            
            echo "<br>";
            echo "<input type='submit' name='selectEndNo' value='Select End No'>";
            echo "</form>";
        } else {
            echo "No End No List available for distance " . $distance . ".";
        }
    } else {
        echo "No range available for distance " . $distance . ".";
    }
    echo "<script>";
    echo "document.querySelector('form[action=\"scores.php\"]').style.display = 'none';";
    echo "</script>";
}


function checkURL()
{
    
        if (!isset($_GET['distance'])) {
            if (isset($_GET['categoryId']) && isset($_GET['EquipmentDescription'])) {
                $selectedCategoryId = $_GET['categoryId'];
                $selectedEquipment = $_GET['EquipmentDescription'];
                selectDistanceForm($selectedCategoryId, $selectedEquipment);
            }
        } else {
            $selectedCategoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;
            $selectedEquipment = isset($_GET['EquipmentDescription']) ? $_GET['EquipmentDescription'] : null;
            $selectedDistance = $_GET['distance'];
            $roundName = RoundName($selectedCategoryId);
            echo "<h2>" . $roundName . "</h2>";
            echo "<h2>" . ArcherFullName($selectedCategoryId) . ", " . $selectedEquipment . "</h2>";
            echo "<h2>" . $selectedDistance . "</h2>";

            $distance = extractDistance($selectedDistance);
            selectEndsForm($selectedCategoryId, $distance);
        }
    } 





selectCategoryAndEquipmentForm();

checkURL();






    ?>
    

