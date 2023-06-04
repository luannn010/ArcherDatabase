SELECT
    ArcherInfo.FirstName,
    ArcherInfo.LastName,
    EndScores.Distance,
    EndScores.EndNo,
    EndScores.Arrow1,
    EndScores.Arrow2,
    EndScores.Arrow3,
    EndScores.Arrow4,
    EndScores.Arrows,
    EndScores.Arrow6
FROM
    ArcherInfo
JOIN
    Category ON ArcherInfo.ArcherID = Category.ArcherID
JOIN
    EndScores ON Category.CategoryID = EndScores.CategoryID
WHERE
    ArcherInfo.FirstName = 'Christoph' AND ArcherInfo.LastName = 'Cowie';
