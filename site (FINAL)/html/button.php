<!DOCTYPE html>
<html>
<head>
    <title>Push Value to Blank Square</title>
    <link rel="stylesheet" href="style.css">
    <script src="buttonfunction.js"></script>
</head>
<body>
    <form method="get" action="">
        <div class="blankSquareContainer">
            <div class="blankSquare"><input type="hidden" name="arrow1" value=""></div>
            <div class="blankSquare"><input type="hidden" name="arrow2" value=""></div>
            <div class="blankSquare"><input type="hidden" name="arrow3" value=""></div>
            <div class="blankSquare"><input type="hidden" name="arrow4" value=""></div>
            <div class="blankSquare"><input type="hidden" name="arrow5" value=""></div>
            <div class="blankSquare"><input type="hidden" name="arrow6" value=""></div>
        </div>
        <div id="totalContainer">
            <div id="totalLabel">Total:</div>
            <div id="totalValue">
                <?php // Display total value or perform other calculations ?>
            </div>
        </div>
        <button id="submitButton" type="submit">Submit</button>
    </form>

    <div id="buttonContainer">
        <button class="score scoreX" onclick="pushValue(10)">X</button>
        <button class="score score10" onclick="pushValue(10)">10</button>
        <button class="score score9" onclick="pushValue(9)">9</button>
        <button class="score score8" onclick="pushValue(8)">8</button>
        <button class="score score7" onclick="pushValue(7)">7</button>
        <button class="score score6" onclick="pushValue(6)">6</button>
        <button class="score score5" onclick="pushValue(5)">5</button>
        <button class="score score4" onclick="pushValue(4)">4</button>
        <button class="score score3" onclick="pushValue(3)">3</button>
        <button class="score score2" onclick="pushValue(2)">2</button>
        <button class="score score1" onclick="pushValue(1)">1</button>
        <button class="score scoreM" onclick="pushValue(0)">M</button>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include('score.php');
    }
    ?>
</body>
</html>
