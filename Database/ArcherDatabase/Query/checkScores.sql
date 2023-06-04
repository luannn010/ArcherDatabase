SELECT
    ArcherInfo.FirstName,
    ArcherInfo.LastName,
    SUM(EndScores.Arrow1 + EndScores.Arrow2 + EndScores.Arrow3 + EndScores.Arrow4) AS OverallScore
FROM
    EndScores
INNER JOIN
    Category ON EndScores.CategoryID = Category.CategoryID
INNER JOIN
    ArcherInfo ON Category.ArcherID = ArcherInfo.ArcherID
GROUP BY
    ArcherInfo.ArcherID
ORDER BY
    OverallScore DESC;
