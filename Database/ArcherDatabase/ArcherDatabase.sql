-- Drop table
DROP TABLE IF EXISTS EndScores;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS ClubCompetition;
DROP TABLE IF EXISTS DefaultEquipment;
DROP TABLE IF EXISTS EquipmentDescription;
DROP TABLE IF EXISTS TargetFaceSizeDescription;
DROP TABLE IF EXISTS Rounds;
DROP TABLE IF EXISTS ArcherInfo;

-- TABLES
-- ArcherInfo_Table
CREATE TABLE ArcherInfo (
    ArcherID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Gender ENUM('M', 'F'),
    DOB DATE
) AUTO_INCREMENT=10000;

-- Round_Table
CREATE TABLE Rounds(
    RoundName VARCHAR(255) NOT NULL,
    Arrows90m CHAR(10) DEFAULT '0',
    Arrows70m CHAR(10) DEFAULT '0',
    Arrows60m CHAR(10) DEFAULT '0',
    Arrows50m CHAR(10) DEFAULT '0',
    Arrows40m CHAR(10) DEFAULT '0',
    Arrows30m CHAR(10) DEFAULT '0',
    Arrows20m CHAR(10) DEFAULT '0', 
    Arrows10m CHAR(10) DEFAULT '0',
    PRIMARY KEY (RoundName)
);

CREATE TABLE TargetFaceSizeDescription(
    Target CHAR(1),
    FaceDesc VARCHAR(255),
    PRIMARY KEY (Target)
);

-- Equipment description
CREATE TABLE EquipmentDescription(
    Equipment VARCHAR(5) NOT NULL,
    EquipmentDescription VARCHAR(255) NOT NULL,
    PRIMARY KEY (Equipment)
);

-- Default Equipment
CREATE TABLE DefaultEquipment(
    RoundName VARCHAR(255) NOT NULL,
    Category VARCHAR(255) NOT NULL ,
    DefaultEquipment VARCHAR(4) NOT NULL,
    FOREIGN KEY (RoundName) REFERENCES Rounds(RoundName)
);

-- Club Competition
CREATE TABLE ClubCompetition(
    CompetitionID INT NOT NULL AUTO_INCREMENT,
    CompetitionName VARCHAR(255),
    Championship VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (CompetitionID)
) AUTO_INCREMENT = 10000;

-- Category
CREATE TABLE Category (
    CategoryID INT NOT NULL AUTO_INCREMENT,
    ArcherID INT NOT NULL,
    CompetitionID INT NOT NULL,
    RoundName VARCHAR(255) NOT NULL,
    Class VARCHAR(255) NOT NULL,
    Equipment VARCHAR(255),
    RegisterYear YEAR,
    PRIMARY KEY (CategoryID),
    FOREIGN KEY (ArcherID) REFERENCES ArcherInfo(ArcherID),
    FOREIGN KEY (CompetitionID) REFERENCES ClubCompetition(CompetitionID),
    FOREIGN KEY (RoundName) REFERENCES Rounds(RoundName)
) AUTO_INCREMENT = 30000;

-- ArrowScore_Table
CREATE TABLE EndScores(
    ScoreID INT NOT NULL AUTO_INCREMENT,
    EndNo ENUM('1','2','3','4','5','6','7','8','9','10','11','12'),
    CategoryID INT NOT NULL,
    Equipment VARCHAR(255),
    Distance ENUM('20m', '30m', '40m', '50m', '60m', '70m', '90m'),
    Arrow1 INT NOT NULL,
    Arrow2 INT NOT NULL,
    Arrow3 INT NOT NULL,
    Arrow4 INT NOT NULL,
    Arrow5 INT DEFAULT NULL,
    Arrow6 INT DEFAULT NULL,
    PRIMARY KEY (ScoreID),
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
) AUTO_INCREMENT = 100000;
