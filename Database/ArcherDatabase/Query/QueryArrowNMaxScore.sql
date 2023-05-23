SELECT
    RoundName,
    (LEFT(Arrows90m, LENGTH(Arrows90m) - 1)
    + LEFT(Arrows70m, LENGTH(Arrows70m) - 1)
    + LEFT(Arrows60m, LENGTH(Arrows60m) - 1)
    + LEFT(Arrows50m, LENGTH(Arrows50m) - 1)
    + LEFT(Arrows40m, LENGTH(Arrows40m) - 1)
    + LEFT(Arrows30m, LENGTH(Arrows30m) - 1)
    + LEFT(Arrows20m, LENGTH(Arrows20m) - 1)
    + LEFT(Arrows10m, LENGTH(Arrows10m) - 1)) AS TotalArrows,
    ((LEFT(Arrows90m, LENGTH(Arrows90m) - 1)
    + LEFT(Arrows70m, LENGTH(Arrows70m) - 1)
    + LEFT(Arrows60m, LENGTH(Arrows60m) - 1)
    + LEFT(Arrows50m, LENGTH(Arrows50m) - 1)
    + LEFT(Arrows40m, LENGTH(Arrows40m) - 1)
    + LEFT(Arrows30m, LENGTH(Arrows30m) - 1)
    + LEFT(Arrows20m, LENGTH(Arrows20m) - 1)
    + LEFT(Arrows10m, LENGTH(Arrows10m) - 1)) * 10) AS MaxScore
FROM Rounds;
