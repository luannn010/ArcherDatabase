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
           
            echo "<select name='roundId'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['RoundName']."'>".$row['RoundName']."</option>";
            }
            echo "</select>";
           


        }
    
        $conn->close();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectRound'])) {
        $selectedRound = $_POST['roundId'];
        // Fetch details of the selected round and display it for editing
    }
 ?>
 <?php
    function getCompetition() {
        $conn = getDBConnection();
        
        $sql = "SELECT * FROM ClubCompetition";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='Competition'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['CompetitionID']."'>".$row['CompetitionName']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectComp'])) {
    $selectedComp = $_POST['CompetitionID'];
}

 ?>
 <?php
    function getArcherName() {
        $conn = getDBConnection();
        
        $sql = "SELECT * FROM ArcherInfo";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='ArcherID'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['ArcherID']."'>ID: ".$row['ArcherID']." ".$row['FirstName']." ".$row['LastName']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ArcherID'])) {
    $selectedName = $_POST['ArcherID'];
}

 ?>
  <?php
    function getEquipment() {
        $conn = getDBConnection();
        
        $sql = "SELECT DISTINCT DefaultEquipment
        FROM DefaultEquipment";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            echo "<select name='Equipment'>";
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['DefaultEquipment']."'>".$row['DefaultEquipment']."</option>";
            }
            echo "</select>";
    }
    $conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DefaultEquipment'])) {
    $selectedEquipment = $_POST['DefaultEquipment'];
}

 ?>
   <?php
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

 ?>
 <?php
    function getYears() {
        // Generate options for years
        $options = "";
        $currentYear = date("Y");
        $startYear = $currentYear - 50; // Adjust the range as needed
        
        for ($year = $currentYear; $year >= $startYear; $year--) {
            $options .= "<option value='$year'>$year</option>";
        }
        
        return $options;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Year'])) {
        $selectedYear = $_POST['Year'];
    }


 ?>
        <div>
            <h2>Add Category</h2>
            <form method = "post" action="category.php">
                <lable for="RoundName">Round name:</lable>
                <?php echo getRounds();?>
                <lable for="Competition">Competition:</lable>
                <?php echo getCompetition();?>
                <lable for="ArcherInfo">Archer Name:</lable>
                <?php echo getArcherName();?>
                <lable for="Equipment">Equipment:</lable>
                <?php echo getEquipment();?>
                <lable for="Class">Class:</lable>
                <?php echo getClass();?>
                <label for="Year">Year:</label>
                <?php echo getYears(); ?>
                

            <!-- Other content here -->
        </div>
    </body>
</html>
