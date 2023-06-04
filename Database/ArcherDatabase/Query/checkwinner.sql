SELECT
    ClubCompetition.CompetitionName,
    Rounds.RoundName,
    ArcherInfo.FirstName,
    ArcherInfo.LastName,
    SUM(EndScores.Arrow1 + EndScores.Arrow2 + EndScores.Arrow3 + EndScores.Arrow4 + IFNULL(EndScores.Arrow5, 0) + IFNULL(EndScores.Arrow6, 0)) AS TotalScore
FROM
    ClubCompetition
JOIN
    Category ON ClubCompetition.CompetitionID = Category.CompetitionID
JOIN
    ArcherInfo ON Category.ArcherID = ArcherInfo.ArcherID
JOIN
    EndScores ON Category.CategoryID = EndScores.CategoryID
JOIN
    Rounds ON Category.RoundName = Rounds.RoundName
GROUP BY
    ClubCompetition.CompetitionName,
    Rounds.RoundName,
    ArcherInfo.FirstName,
    ArcherInfo.LastName
ORDER BY
    ClubCompetition.CompetitionName,
    Rounds.RoundName,
    TotalScore DESC;
