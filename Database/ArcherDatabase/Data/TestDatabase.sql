-- Drop trigger

Drop trigger category_default_equipment_trigger;
Drop trigger calculate_rangescore;
Drop Trigger insert_rangescore ;

-- Drop table
Drop Table Scores_Table;
Drop Table Ranges_Table;
Drop Table Ends_Table;
Drop Table Daterange;
Drop Table Category;
Drop Table DefaultEquipment;
Drop Table EquipmentDescription;
Drop Table Rounds;
Drop Table ArcherInfo;

-- TABLES
-- ArcherInfo_Table
-- CREATE TABLE ArcherInfo (
--     ArcherID INT NOT NULL AUTO_INCREMENT,
--     FirstName VARCHAR(255),
--     LastName VARCHAR(255),
--     Gender ENUM('M','F'),
--     DOB DATETIME,
--     PRIMARY KEY(ArcherID)
-- );


-- Round_Table
-- CREATE TABLE Rounds(
--     RoundName VARCHAR(255) NOT NULL,
--     Arrows90m CHAR(10) DEFAULT 0,
--     Arrows70m CHAR(10) DEFAULT 0,
--     Arrows60m CHAR(10) DEFAULT 0,
--     Arrows50m CHAR(10) DEFAULT 0,
--     Arrows40m CHAR(10) DEFAULT 0,
--     Arrows30m CHAR(10) DEFAULT 0,
--     Arrows20m CHAR(10) DEFAULT 0, 
--     Arrows10m CHAR(10) DEFAULT 0,
--     TotalArrows INT GENERATED ALWAYS AS (LEFT(Arrows90m, LENGTH(Arrows90m) -1) + LEFT(Arrows70m, LENGTH(Arrows70m) -1) + LEFT(Arrows60m, LENGTH(Arrows60m) -1) + LEFT(Arrows50m, LENGTH(Arrows50m) -1) + LEFT(Arrows40m, LENGTH(Arrows40m) -1) + LEFT(Arrows30m, LENGTH(Arrows30m) -1) + LEFT(Arrows20m, LENGTH(Arrows20m) -1) + LEFT(Arrows10m, LENGTH(Arrows10m) -1)) STORED,
--     MAXSCORE INT GENERATED ALWAYS AS (TotalArrows * 10) STORED,
--     PRIMARY KEY (RoundName)
-- );
-- Equipment description
-- CREATE TABLE EquipmentDescription(
-- 	Equipment VARCHAR(5) NOT NULL,
--     Equip_Desc VARCHAR(255) NOT NULL,
--     PRIMARY KEY (Equipment)
-- );
-- Default Equipment
-- CREATE TABLE DefaultEquipment(
-- 	RoundName VARCHAR (255) NOT NULL,
-- 	Category VARCHAR(255) NOT NULL ,
--     DefaultEquipment VARCHAR(4) NOT NULL,
--     FOREIGN KEY (RoundName) REFERENCES Rounds(RoundName)
-- );
-- Category
-- CREATE TABLE Category (
-- 	CategoryID INT NOT NULL AUTO_INCREMENT,
--     ArcherID INT NOT NULL,
--     RoundName VARCHAR(255) NOT NULL,
--     Class VARCHAR(255) NOT NULL,
--     Equipment VARCHAR(255),
--     
--     PRIMARY KEY (CategoryID),
--     FOREIGN KEY (RoundName) REFERENCES Rounds(RoundName),
--     FOREIGN KEY (ArcherID) REFERENCES ArcherInfo(ArcherID)
--     
--     
-- );

-- Date Range
-- CREATE TABLE DateRange(
-- 	DateID INT AUTO_INCREMENT,
-- 	ArcherID INT NOT NULL,
--     RoundName VARCHAR(255) NOT NULL,
--     Distance ENUM('20m', '30m', '40m', '50m', '60m', '70m', '90m'),
--     DateRange Date,
--     PRIMARY KEY (DateID),
--     FOREIGN KEY (ArcherID) REFERENCES ArcherInfo(ArcherID),
--     FOREIGN KEY (RoundName) REFERENCES Rounds(RoundName)
--     
--     

-- );


-- Ends_Table
-- CREATE TABLE Ends_Table (
--     EndID INT NOT NULL AUTO_INCREMENT,
--     DateID INT NOT NULL,
--     ArcherID INT NOT NULL,
--     EndScore INT NOT NULL,
--     PRIMARY KEY (EndID),
--     FOREIGN KEY (ArcherID) REFERENCES ArcherInfo(ArcherID),
--     FOREIGN KEY (DateID) REFERENCES DateRange(DateID)
-- );
-- Ranges_Table
-- CREATE TABLE Ranges_Table (
--     RangeID INT NOT NULL AUTO_INCREMENT,
-- 	DateID INT NOT NULL,
--     ArcherID INT NOT NULL,
--     RangeScore INT NOT NULL,
--     PRIMARY KEY (RangeID),
--     FOREIGN KEY (ArcherID) REFERENCES ArcherInfo(ArcherID),
-- 	FOREIGN KEY (DateID) REFERENCES DateRange(DateID)
--     
-- );
-- Score_Table
-- CREATE TABLE Scores_Table(
-- 	ScoreID INT NOT NULL AUTO_INCREMENT,
-- 	DateID INT NOT NULL,
--     ArcherID INT NOT NULL,
--     SCORE INT NOT NULL,
--     PRIMARY KEY (ScoreID),
--     FOREIGN KEY (ArcherID) REFERENCES ArcherInfo(ArcherID),
--     FOREIGN KEY (DateID) REFERENCES DateRange(DateID)


-- );
-- 	TRIGGERS
-- Insert value to range score when ends is updated
-- DELIMITER $$
-- CREATE TRIGGER insert_rangescore 
-- AFTER INSERT ON Ends_Table
-- FOR EACH ROW
-- BEGIN
--    IF NOT EXISTS (
--       SELECT * FROM Ranges_Table 
--       WHERE DateID = NEW.DateID

--    ) THEN
-- 	INSERT INTO Ranges_Table (DateID, RangeScore)
--       VALUES (NEW.DateID, NEW.EndScore);
--    ELSE
--       UPDATE Ranges_Table 
--       SET RangeScore = RangeScore + NEW.EndScore 
--       WHERE DateID = NEW.DateID 
--      ;
--    END IF;
-- END$$
-- DELIMITER ;

-- Update the calculated score to the rangescore
-- DELIMITER $$
-- CREATE TRIGGER calculate_rangescore 
-- AFTER INSERT ON Ends_Table
-- FOR EACH ROW
-- BEGIN
--    UPDATE Ranges_Table r
-- JOIN (
--    SELECT DateID, SUM(EndScore) AS sum_endscore
--    FROM Ends_Table 
--    WHERE DateID = NEW.DateID
--    GROUP BY DateID
-- ) e ON r.DateID = e.DateID
-- SET r.RangeScore = e.sum_endscore
-- WHERE r.DateID = NEW.DateID;

--    
-- END$$
-- DELIMITER ;

-- Trigger add Default equipment if it is nulled
-- DELIMITER $$
-- CREATE TRIGGER category_default_equipment_trigger
-- BEFORE INSERT ON Category
-- FOR EACH ROW
-- BEGIN
--     IF NEW.Equipment IS NULL THEN
--         SET NEW.Equipment = (
--             SELECT DefaultEquipment.DefaultEquipment 
--             FROM DefaultEquipment 
--             WHERE DefaultEquipment.RoundName = NEW.RoundName 
--             AND DefaultEquipment.Category = NEW.Class
--             LIMIT 1
--         );
--     END IF;
-- END$$
-- DELIMITER ; 
