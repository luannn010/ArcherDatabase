<?php
// Retrieve the values from URL parameters
$arrow1 = isset($_GET['arrow1']) ? $_GET['arrow1'] : '';
$arrow2 = isset($_GET['arrow2']) ? $_GET['arrow2'] : '';
$arrow3 = isset($_GET['arrow3']) ? $_GET['arrow3'] : '';
$arrow4 = isset($_GET['arrow4']) ? $_GET['arrow4'] : '';
$arrow5 = isset($_GET['arrow5']) ? $_GET['arrow5'] : '';
$arrow6 = isset($_GET['arrow6']) ? $_GET['arrow6'] : '';

// Display the values
echo "<h2>Pushed Values:</h2>";
echo "<ul>";
echo "<li>Arrow 1: " . htmlspecialchars($arrow1) . "</li>";
echo "<li>Arrow 2: " . htmlspecialchars($arrow2) . "</li>";
echo "<li>Arrow 3: " . htmlspecialchars($arrow3) . "</li>";
echo "<li>Arrow 4: " . htmlspecialchars($arrow4) . "</li>";
echo "<li>Arrow 5: " . htmlspecialchars($arrow5) . "</li>";
echo "<li>Arrow 6: " . htmlspecialchars($arrow6) . "</li>";
echo "</ul>";
?>
