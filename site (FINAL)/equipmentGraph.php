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
  </nav>
  <h1>Equipment Usage by Archers</h1>
  <div id="equipmentChart"></div>

  <script>
    d3.json("getEquipmentUsage.php").then(function(data) {
      console.log(data);

      var svgWidth = 1000; // Define the width of the SVG container
      var svgHeight = 500; // Define the height of the SVG container
      var margin = { top: 20, right: 20, bottom: 30, left: 60 };
      var width = svgWidth - margin.left - margin.right;
      var height = svgHeight - margin.top - margin.bottom;

      var svg = d3.select("#equipmentChart")
        .append("svg")
        .attr("width", svgWidth)
        .attr("height", svgHeight)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      var x = d3.scaleBand()
        .range([0, width])
        .padding(0.1);
      var y = d3.scaleLinear()
        .range([height, 0]);

      var color = d3.scaleOrdinal(d3.schemeCategory10);

      x.domain(data.map(function(d) { return d.Equipment; }));
      y.domain([0, d3.max(data, function(d) { return d.Count; })]);

      svg.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.Equipment); })
        .attr("width", x.bandwidth())
        .attr("y", function(d) { return y(d.Count); })
        .attr("height", function(d) { return height - y(d.Count); })
        .attr("fill", function(d) { return color(d.Equipment); });

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
      //   .text("Count");

      // svg.append("text")
      //   .attr("x", width / 2)
      //   .attr("y", height + margin.bottom)
      //   .attr("text-anchor", "middle")
      //   .style("font-size", "14px")
      //   .text("Equipment");

      // svg.append("text")
      //   .attr("transform", "translate(" + (width / 2) + " ," + (height / 2) + ") rotate(-90)")
      //   .style("text-anchor", "middle")
      //   .text("Equipment Usage by Archers");
    })
    .catch(function(error) {
      console.log("Error loading data: " + error);
    });
  </script>
</body>
</html>
