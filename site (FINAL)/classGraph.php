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
  <h1>Class Distribution of Archers</h1>
  <div id="classChart"></div>

  <script>
    d3.json("getClassDistribution.php").then(function(data) {
      console.log(data);

      var svgWidth = 1000; // Define the width of the SVG container
      var svgHeight = 500; // Define the height of the SVG container
      var margin = { top: 20, right: 20, bottom: 30, left: 60 };
      var width = svgWidth - margin.left - margin.right;
      var height = svgHeight - margin.top - margin.bottom;

      var svg = d3.select("#classChart")
        .append("svg")
        .attr("width", svgWidth)
        .attr("height", svgHeight)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      var x = d3.scaleLinear()
        .range([0, width]);
      var y = d3.scaleBand()
        .range([height, 0])
        .padding(0.1);

      var color = d3.scaleOrdinal(d3.schemeCategory10);

      x.domain([0, d3.max(data, function(d) { return d.Count; })]);
      y.domain(data.map(function(d) { return d.Class; }));

      svg.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("y", function(d) { return y(d.Class); })
        .attr("height", y.bandwidth())
        .attr("x", 0)
        .attr("width", function(d) { return x(d.Count); })
        .attr("fill", function(d) { return color(d.Class); });

      svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

      svg.append("g")
        .call(d3.axisLeft(y));

      // svg.append("text")
      //   .attr("transform", "rotate(-90)")
      //   .attr("y", 0 - margin.left)
      //   .attr("x", 0 - (height / 2))
      //   .attr("dy", "1em")
      //   .style("text-anchor", "middle")
      //   .text("Class");

      svg.append("text")
        .attr("x", width / 2)
        .attr("y", height + margin.bottom)
        .attr("text-anchor", "middle")
        .style("font-size", "14px")
        .text("Count of Archer ID");

      // svg.append("text")
      //   .attr("transform", "translate(" + (width / 2) + " ," + (height / 2) + ") rotate(-90)")
      //   .style("text-anchor", "middle")
      //   .text("Class Distribution of Archers");
    })
    .catch(function(error) {
      console.log("Error loading data: " + error);
    });
  </script>
</body>
</html>
