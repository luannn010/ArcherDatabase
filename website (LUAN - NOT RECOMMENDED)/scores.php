

<!DOCTYPE html>
<html>
<head>
    <title>Database</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Archer Info</a>
        <a href="scores.php">Scores</a>
        <a href="rounds.php">Rounds</a>
        <a href="category.php">Category</a>
    </nav>

    <div>
        <h2>Add Ends Scores</h2>
            
            <div id="selectArcher"></div>
      <script>
        // Use JavaScript to populate the 'selectArcher' div with the selected round details
        function selectArcher(details) {
            document.getElementById('selectArcher').innerHTML = details;
        }
      </script>

        </form>
<?php
    include("script/function.php");
    
?>
    </div>
</body>
</html>
