SELECT
    ArcherInfo.FirstName,
    ArcherInfo.LastName,
    Category.Class,
    Category.Equipment,
    Category.RegisterYear,
    ClubCompetition.CompetitionName
FROM
    Category
INNER JOIN
    ArcherInfo ON Category.ArcherID = ArcherInfo.ArcherID
INNER JOIN
    ClubCompetition ON Category.CompetitionID = ClubCompetition.CompetitionID;
