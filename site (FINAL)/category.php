<!DOCTYPE html>
<html>
    <head>
        <title>Archer Category</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <nav>
            <a href="index.php">Archer Info</a>
            <a href="scores.php">Scores</a>
            <a href="rounds.php">Rounds</a>
            <a href="category.php">Category</a>
        </nav>
    
        <!-- Category Form -->




        <?php
       include ('dbconnect.php');

       function getRounds() {
        $conn = getDBConnection();
    
        $sql = "SELECT * FROM Rounds";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
           
            echo "<select name='RoundName'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['RoundName']."'>".$row['RoundName']."</option>";
            }
            echo "</select>";
           


        }
    
        $conn->close();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['RoundName'])) {
        $selectedRound = $_POST['RoundName'];
        // Fetch details of the selected round and display it for editing
    }
 ?>
 <?php
    function getCompetition() {
        $conn = getDBConnection();
        
        $sql = "SELECT * FROM ClubCompetition";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='CompetitionID'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['CompetitionID']."'>".$row['CompetitionName']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CompetitionID'])) {
    $selectedComp = $_POST['CompetitionID'];
}


    function getArcherName() {
        $conn = getDBConnection();
        
        $sql = "SELECT * FROM ArcherInfo";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='ArcherID'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['ArcherID']."'> ".$row['FirstName']." ".$row['LastName']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ArcherID'])) {
    $selectedName = $_POST['ArcherID'];
}

    function getEquipment() {
        $conn = getDBConnection();
        
        $sql = "SELECT * FROM `EquipmentDescription`";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='Equipment'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['Equipment']."'>".$row['EquipmentDescription']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Equipment'])) {
    $selectedEquipment = $_POST['Equipment'];
}

    function getClass() {
        $conn = getDBConnection();
        
        $sql = "SELECT DISTINCT Category
        FROM DefaultEquipment";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='Class'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['Category']."'>".$row['Category']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Class'])) {
    $selectedClass = $_POST['Class'];
}

function getYears() {
    // Generate options for years
    $options = "";
    $currentYear = date("Y");
    $startYear = 1980; // Set the start year
    
    for ($year = $currentYear; $year >= $startYear; $year--) {
        $options .= "<option value='$year'>$year</option>";
    }
    
    echo "<select name='Year'>$options</select>";
}

    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Year'])) {
        $selectedYear = $_POST['Year'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitCategory'])) {
        $conn = getDBConnection();
        $selectedYear = $_POST['Year'];
        
        // Insert the data into the Category table
        $sql = "INSERT INTO Category (ArcherID, CompetitionID, RoundName, Class, Equipment, RegisterYear) VALUES ('$selectedName', '$selectedComp', '$selectedRound', '$selectedClass', '$selectedEquipment', '$selectedYear')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Category added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }
 ?>
 
        <div>
            <h2>Add Category</h2>
            <form method = "post" action="category.php">
                <lable for="RoundName">Round name:</lable>
                <?php echo getRounds();?><br>
                <lable for="Competition">Competition:</lable>
                <?php echo getCompetition();?><br>
                <lable for="ArcherInfo">Archer Name:</lable>
                <?php echo getArcherName();?><br>
                <lable for="Equipment">Equipment:</lable>
                <?php echo getEquipment();?><br>
                <lable for="Class">Class:</lable>
                <?php echo getClass();?><br>
                <label for="Year">Year:</label>
                <?php echo getYears(); ?><br>
                <input type="submit" name="submitCategory" value="Add Category">
            </form>
                

            <!-- Other content here -->
        </div>
    </body>
</html>
