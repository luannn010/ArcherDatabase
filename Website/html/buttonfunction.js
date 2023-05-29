var currentIndex = 0; // Track the current index

function pushValue(a) {
    var blankSquares = document.getElementsByClassName("blankSquare");

    if (currentIndex >= blankSquares.length) {
        currentIndex = 0; // Reset the index if it exceeds the number of squares
    }

    var inputField = blankSquares[currentIndex].querySelector('input');
    inputField.value = a; // Set the value in the current blank square's hidden input field
    blankSquares[currentIndex].innerHTML = a; // Set the value in the current blank square
    currentIndex++; // Increment the index for the next square

    calculateSum(); // Calculate and update the sum
}

function calculateSum() {
    var blankSquares = document.getElementsByClassName("blankSquare");
    var sum = 0;

    for (var i = 0; i < blankSquares.length; i++) {
        var value = parseInt(blankSquares[i].innerHTML);
        if (!isNaN(value)) {
            sum += value;
        }
    }

    var totalValue = document.getElementById("totalValue");
    totalValue.innerHTML = sum;
}