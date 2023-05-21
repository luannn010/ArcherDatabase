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

    <?php
    include('script/function.php');
    $selectedCategoryId = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        if (isset($_POST['selectedCategoryId'])) {
            $selectedCategoryId = $_POST['selectedCategoryId'];
            echo $selectedCategoryId; // Echo the selected category ID
        }
    }
    ?>

    <div>
        <h2>Archer Information</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="ArcherInfo">Archer Name:</label>
            <?php echo getArcherName(); ?><br>

            <!-- Add a hidden input field to store the selected category ID -->
            <input type="hidden" name="selectedCategoryId" value="<?php echo $selectedCategoryId; ?>">

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>