<!DOCTYPE html>
<html>
<head>
  <title>Archer Information</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://d3js.org/d3.v5.min.js"></script>
</head>
<body>
  <nav>
    <a href="index.php">Archer Info</a>
    <a href="scores.php">Scores</a>
    <a href="rounds.php">Rounds</a>
    <a href="category.php">Category</a>
    <a href='classGraph.php'>Graph 1</a>
    <a href='graphGender.php'>Graph 2</a>
    <a href='equipmentGraph.php'>Graph 3</a>
  </nav>
  <h1>Gender Distribution</h1>
  <div id="genderChart"></div>

  <script>
  d3.json("getGenderDistribution.php").then(function(data) {
  console.log(data);

  // Print out the genders in the console
  var genders = data.map(function(d) {
    return d.Gender;
  });
  console.log("Genders:", genders);

  // Update the gender values in the data
  data.forEach(function(d) {
    if (d.Gender === 'M') {
      d.Gender = 'Male';
    } else if (d.Gender === 'F') {
      d.Gender = 'Female';
    }
  });

  var svgWidth = 1000; // Define the width of the SVG container
  var svgHeight = 500; // Define the height of the SVG container

  var radius = Math.min(svgWidth, svgHeight) / 2;
  var color = d3.scaleOrdinal(d3.schemeCategory10);

  var svg = d3.select("#genderChart")
    .append("svg")
    .attr("width", svgWidth)
    .attr("height", svgHeight)
    .append("g")
    .attr("transform", "translate(" + svgWidth / 2 + "," + svgHeight / 2 + ")");

  var pie = d3.pie()
    .value(function(d) { return d.Count; })
    .sort(null);

  var path = d3.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

  var arc = svg.selectAll(".arc")
    .data(pie(data))
    .enter()
    .append("g")
    .attr("class", "arc");

  arc.append("path")
    .attr("d", path)
    .attr("fill", function(d) { return color(d.data.Gender); });

  arc.append("text")
    .attr("transform", function(d) { 
      var centroid = path.centroid(d);
      return "translate(" + centroid[0] + "," + centroid[1] + ")";
    })
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .text(function(d) { return d.data.Gender; });

  var label = d3.arc().innerRadius(0).outerRadius(radius - 40);

  arc.append("text")
    .attr("transform", function(d) {
      var centroid = path.centroid(d);
      var midAngle = (d.startAngle + d.endAngle) / 2;
      var x = Math.sin(midAngle) * (radius - 20);
      var y = -Math.cos(midAngle) * (radius - 20);
      return "translate(" + x + "," + y + ")";
    })
    .attr("dy", "0.35em")
    .attr("text-anchor", function(d) {
      var midAngle = (d.startAngle + d.endAngle) / 2;
      return (Math.sin(midAngle) > 0) ? "start" : "end";
    })
    .text(function(d) {
      var percent = ((d.endAngle - d.startAngle) / (2 * Math.PI)) * 100;
      return percent.toFixed(1) + "%";
    });

  svg.append("text")
    .attr("x", 0)
    .attr("y", -radius - 20)
    .attr("text-anchor", "middle")
    .text("Distribution of Archer Genders");
})
.catch(function(error) {
  console.log("Error loading data: " + error);
});

  </script>
</body>
</html>
