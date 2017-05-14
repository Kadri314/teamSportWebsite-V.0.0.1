create table records (
numberOfGoals int,
numberOfMatchesPlayed int,
recordNumber int not null AUTO_INCREMENT,
startDate date,
primary key (recordNumber)
);



create table awards(
awardName varchar(50) not null,
recordNumber int not null,
primary key(recordNumber,awardName),
foreign key (recordNumber) references records (recordNumber) on delete cascade
);
create table members(
age int,
id int not null AUTO_INCREMENT,
firstName varchar(50),
lastName varchar(50),
primary key(id),
unique(firstName,lastName)
);
create table club(
president varchar(50),
clubName varchar(100) not null,
dateofCreation date,
location varchar(200),
primary key(clubName)
);
create table team(
id int not null AUTO_INCREMENT,
teamName varchar(50) unique,
clubName varchar(50),
sportName varchar(50),
primary key(id),
foreign key (clubName) references club (clubName)
);
create table player(
teamPosition varchar(50),
teamRole varchar(50),
id int not null,
teamId int,
primary key(id),
foreign key (id) references members (id) on delete cascade,
foreign key (teamId) references team (id) on delete set null
);

create table playersMatchHistory(
playerId int,
teamAId int,
teamBId int,
score int,
playedDate date,
primary key(teamAId,teamBId,playerId),
foreign key (playerId) references player (id),
foreign key (teamAId) references team (id) on delete cascade,
foreign key (teamBId) references team (id) on delete cascade
);


create table playerRecord(
height int,
weight int,
yearsOfExperience int,
recordNumber int not null,
playerId int,
numberOfAssists int,
primary key(recordNumber),
foreign key (playerId) references player (id) on delete cascade,
foreign key (recordNumber) references records (recordNumber) on delete cascade
);
create table teamRecord(
teamId int not null,
numberOfWins int,
numberOfLosses int,
recordNumber int not null ,
primary key(recordNumber),
foreign key (recordNumber) references records (recordNumber) on delete cascade,
foreign key (teamId) references team (id) on delete cascade
);
create table court(
clubName varchar(100),
courtType varchar(50),
courtCondition varchar(50),
courtSize decimal(7,4),
courtName varchar(50) not null,
primary key(courtName),
foreign key (clubName) references club (clubName)
);
create table staff(
role varchar(50),
id int not null ,
teamId int,
primary key(id),
foreign key (teamId) references team (id) on delete set null,
foreign key (id) references members (id) on delete cascade

);

ALTER TABLE members AUTO_INCREMENT=20170000;



create table matchLocation(
teamId int not null,
courtName varchar(50) not null,
primary key(teamId,courtName),
foreign key (teamId) references team (id) on delete cascade,
foreign key (courtName) references court (courtName)
);

create table teamVsTeam(
gameDate date not null,
teamAId int not null,
teamBId int  not null,
scoreA int,
scoreB int,
primary key(gameDate,teamAId,teamBId),
foreign key (teamAId) references team (id) on delete cascade,
foreign key (teamBId) references team (id) on delete cascade
);



create table tournament(
numberOfRounds int,
prizePool int,
tournamentType varchar(50),
startDate date not null,
endDate date,
tournamentName varchar(50) not null,
primary key(startDate,tournamentName)
);
create table tournamentHeldInCourt(
courtName varchar(100) not null,
tournamentName varchar(50) not null,
tournamentStartDate date not null,
primary key(courtName,tournamentName,tournamentStartDate),
foreign key (courtName) references court (courtName),
   foreign key (tournamentStartDate,tournamentName) references tournament (startDate,tournamentName) on delete cascade

);
create table TeamParticipatedIntournament(
teamId int not null,
tournamentName varchar(50) not null,
tournamentStartDate date not null,
primary key(teamId,tournamentName,tournamentStartDate),
foreign key (teamId) references team (id)on delete cascade,
   foreign key (tournamentStartDate,tournamentName) references tournament (startDate,tournamentName) on delete cascade

);
create table sponsor(
sponsorName varchar(100) not null,
tournamentName varchar(50) not null,
tournamentStartDate date not null,
primary key(sponsorName,tournamentName,tournamentStartDate),
   foreign key (tournamentStartDate,tournamentName) references tournament (startDate,tournamentName) on delete cascade

);

create table webusers(
userName varchar(50) primary key,
email varchar(50) unique not null,
password varchar(50),
isAdmin boolean
);
insert into webusers (userName,email,password,isAdmin)
values 
('kadri','kadri314@hotmail.com','0000',1);

-- create view section

create view playerAwards as
  select concat(m.firstName,' ',m.lastName) as fullName, a.awardName
  from records r,playerRecord pr , awards a, player p, members m
  where
    pr.recordNumber=r.recordNumber and
    a.recordNumber=r.recordNumber and
    pr.playerId=p.id and
    m.id= p.id;

create view playerInfo as
select  CONCAT(m.firstName, ' ',m.lastName) as fullName, m.age, t.teamName, p.teamPosition, p.teamRole, r.height, r.weight, r.yearsOfExperience, records.numberOfGoals
from player p, members m, team t, playerRecord r, records
where p.id=m.id and
p.teamId=t.Id and
records.recordNumber=r.recordNumber and
r.playerId=p.Id;

create view clubTeams as
  select t.teamName, t.sportName, c.clubName, count(t.id) as totalPlayers
          from club c, team t, player p
          where
           c.clubName=t.clubName and
           p.teamId=t.id
          group by t.teamName, t.sportName, t.id;


create view staffInfo  as
select m.firstName, m.lastName, m.age, s.role, t.teamName
from staff s, team t, members m
where
      s.id=m.Id  and
      t.Id=s.teamId;

      create view clubCourts as
        select courtName, courtType, courtCondition, courtSize, club.clubName
                from club, court
                where
  club.clubName=court.clubName;




create view PlayerMatches as
  select ta.teamName as teamA, tb.teamName as teamB, ph.score, CONCAT(m.firstName, ' ',m.lastName) as fullName
  from team ta, team tb, player p, members m, playersMatchHistory ph
  where
  ph.teamAId=ta.id and
  ph.teamBId=tb.id and
  ph.playerId=p.id and
  ph.playerId=m.id;

  -- creating indexes ...

  CREATE INDEX teamPosition
ON player (teamPosition);

CREATE INDEX location
ON club (location);

CREATE INDEX sportName
ON team (sportName);

CREATE INDEX name
ON members (firstName,lastName);

-- CREATE INDEX teamName
-- ON team (teamName);

 -- Inserting dumpy Data


INSERT INTO club (president,clubName,dateofCreation,location)
     VALUES ('Rabih Idriss','AUB Soccer','1972-10-21', 'Beirut' ),
            ('Karim Kenaan','AUB Basket', '1973-03-17', 'Beirut' ),
            ('Karim Kenaan','AUB Futsal', '1996-01-01', 'Beirut' ),
            ('Ali Hachem','LAU Soccer', '1983-08-03', 'Beirut' ),
            ('Marin Njeim','LAU Basket', '1985-05-08', 'Beirut' ),
            ('Karim Taleb','LAU Futsal', '2001-03-06', 'Beirut' ),
            ('Michelle Aalia','BALAMAND Basket','1998-12-12', 'Balamand' );
INSERT INTO team (clubName, id, sportName , teamName)
     VALUES ( 'AUB Soccer' ,1, 'Soccer','AUB Varsity Soccer - Men'),
( 'AUB Soccer' ,2, 'Soccer','AUB Varsity Soccer - Women'),
( 'AUB Basket' ,3, 'Basket','AUB Varsity Basket - Men'),
( 'AUB Basket' ,4, 'Basket','AUB Varsity Basket - Women'),
( 'AUB Futsal' ,5, 'Futsal','AUB Varsity Futsal - Men'),
( 'LAU Soccer' ,6, 'Soccer','LAU Varsity Soccer - Men'),
( 'LAU Soccer' ,7, 'Soccer','LAU Varsity Soccer - Women'),
( 'LAU Basket' ,8, 'Basket','LAU Varsity Basket - Men'),
( 'LAU Basket' ,9, 'Basket','LAU Varsity Basket - Women'),
( 'LAU Futsal' ,10, 'Futsal','LAU Varsity Futsal - Men'),
( 'BALAMAND Basket' ,11, 'Basket','BALAMAND Varsity Basket - Men'),
( 'BALAMAND Basket' ,12, 'Basket','BALAMAND Varsity Basket - Women');
INSERT INTO court (clubName, courtType, courtCondition, courtSize, courtName )
     VALUES ('AUB Soccer', 'Football Field' , 'Good', 500 , 'AUB Greenfield' ),
            ('AUB Basket', 'Basketball Court' , 'Good', 200 , 'AUB Hostler Basketball Court' ),
            ('AUB Futsal', 'Futsal Court' , 'Good', 300 , 'AUB Hostler Futsal Court' ),
            ('LAU Soccer', 'Football Field' , 'Good', 500 , 'LAU Soccer Field' ),
            ('LAU Basket', 'Basketball Court' , 'Good', 200 , 'LAU Basketball Court' ),
            ('LAU Futsal', 'Futsal Court' , 'Good', 300 , 'LAU Futsal Court' ),
            ('BALAMAND Basket', 'Basketball Court' , 'Good', 200 , 'Balamand Basketball Court' );
INSERT INTO matchlocation (teamId, courtName)
     VALUES ( 1, 'AUB Greenfield' ),
            ( 2 , 'AUB Greenfield' ),
            ( 3, 'AUB Hostler Basketball Court' ),
            ( 4, 'AUB Hostler Basketball Court' ),
            ( 5, 'AUB Hostler Futsal Court' ),
            ( 6, 'LAU Soccer Field' ),
            ( 7, 'LAU Soccer Field' ),
            ( 8, 'LAU Basketball Court' ),
            ( 9, 'LAU Basketball Court' ),
            ( 10, 'LAU Futsal Court' ),
       ( 11, 'Balamand Basketball Court' ),
       ( 12, 'Balamand Basketball Court' );
INSERT INTO tournament (numberOfRounds , prizePool , tournamentType, endDate, startDate, tournamentName)
     VALUES ( 4 , 1000, 'Soccer', '2015-01-15', '2015-01-01' , 'Lebanese National Soccer Tournament' ),
       ( 6 , 2000, 'Basketball', '2016-09-10', '2015-09-01' , 'Lebanese National Basketball Tournament' ),
       ( 4 , 1000, 'Soccer', '2011-10-05', '2015-09-29' , 'Universities Soccer Tournament' ),
       ( 2 , 500, 'Futsal', '2014-02-25', '2015-01-20' , 'Lebanese Futsal Tournament' ),
       ( 4 , 4000, 'Basketball', '2013-04-16', '2015-04-01' , 'Universities Basketball Tournament' );
INSERT INTO tournamentheldincourt (courtName, tournamentStartDate , tournamentName)
     VALUES ( 'AUB Greenfield', '2015-01-01' , 'Lebanese National Soccer Tournament' ),
       ( 'AUB Hostler Basketball Court', '2015-09-01' , 'Lebanese National Basketball Tournament' ),
       ('AUB Greenfield' , '2015-09-29' , 'Universities Soccer Tournament' ),
       ( 'AUB Hostler Futsal Court', '2015-01-20' , 'Lebanese Futsal Tournament' ),
       ( 'Balamand Basketball Court', '2015-04-01' , 'Universities Basketball Tournament' );
INSERT INTO teamparticipatedintournament (teamId, tournamentStartDate , tournamentName)
     VALUES ( 1, '2015-01-01' , 'Lebanese National Soccer Tournament' ),
( 2, '2015-01-01' , 'Lebanese National Soccer Tournament' ),
( 6, '2015-01-01' , 'Lebanese National Soccer Tournament' ),
( 7, '2015-01-01' , 'Lebanese National Soccer Tournament' ),
       ( 3, '2015-09-01' , 'Lebanese National Basketball Tournament' ),
( 4, '2015-09-01' , 'Lebanese National Basketball Tournament' ),
( 8, '2015-09-01' , 'Lebanese National Basketball Tournament' ),
( 9, '2015-09-01' , 'Lebanese National Basketball Tournament' ),
( 11, '2015-09-01' , 'Lebanese National Basketball Tournament' ),
( 12, '2015-09-01' , 'Lebanese National Basketball Tournament' ),
       ( 1, '2015-09-29' , 'Universities Soccer Tournament' ),
( 2, '2015-09-29' , 'Universities Soccer Tournament' ),
( 6, '2015-09-29' , 'Universities Soccer Tournament' ),
( 7, '2015-09-29' , 'Universities Soccer Tournament' ),
       ( 5, '2015-01-20' , 'Lebanese Futsal Tournament' ),
( 10, '2015-01-20' , 'Lebanese Futsal Tournament' ),
       ( 3, '2015-04-01' , 'Universities Basketball Tournament' ),
( 4, '2015-04-01' , 'Universities Basketball Tournament' ),
( 9, '2015-04-01' , 'Universities Basketball Tournament' ),
( 11, '2015-04-01' , 'Universities Basketball Tournament' );
INSERT INTO sponsor (sponsorName, tournamentStartDate , tournamentName)
     VALUES ( 'Bank Audi', '2015-01-01' , 'Lebanese National Soccer Tournament' ),
( 'Nike', '2015-01-01' , 'Lebanese National Soccer Tournament' ),
       ( 'Nike', '2015-09-01' , 'Lebanese National Basketball Tournament' ),
       ('Adidas' , '2015-09-29' , 'Universities Soccer Tournament' ),
       ( 'Khoury Home', '2015-01-20' , 'Lebanese Futsal Tournament' ),
       ( 'RedBull', '2015-04-01' , 'Universities Basketball Tournament' );
Insert into members (age, id, firstName, lastName)
Values
(20, 100, 'Fawaz', 'Bilal'),
(19, 101, 'Hammoud', 'Ahmad'),
(21, 102, 'Lionel', 'Messi'),
(23, 103, 'Mohamad', 'Salah'),
(24, 104, 'Mohamad', 'ElNeni'),
(20, 105, 'Muslmani', 'Slimani'),
(19, 106, 'Vardy', 'Jamie'),
(21, 107, 'Riad', 'Mahrez'),
(23, 108, 'Sabra', 'Ali'),
(24, 109, 'Mortada', 'Ayman'),
(20, 110, 'El-hajj', 'Ribal'),
(19, 111, 'Barazi', 'Wassim'),
(21, 112, 'Fanous', 'Wissam'),
(23, 113, 'Ahalaf', 'Amro'),
(24, 114, 'Rafeh', 'Angelo'),
(20, 115, 'Cristiano', 'Ronaldo'),
(19, 116, 'Marta', 'Barbara'),
(21, 117, 'Alli', 'Delle'),
(23, 118, 'Houghton', 'Steph'),
(24, 119, 'Carli', 'Lloyd'),
(20, 120, 'Morgan', 'Alex'),
(19, 121, 'Hope', 'Solo'),
(21, 122, 'Rodriguez', 'James'),
(23, 123, 'Dwayne', 'Wayde'),
(24, 124, 'Ilcarnon', 'Isco'),
(20, 125, 'Dwayne', 'Johnson'),
(19, 126, 'Ricardo', 'Kaka'),
(21, 127, 'Lucy', 'Bronze'),
(23, 128, 'Carney', 'Karen'),
(24, 129, 'Hope', 'Powell'),
(20, 130, 'Kelly', 'Smith'),
(19, 131, 'Jill', 'Scott'),
(21, 132, 'Alex', 'Scott'),
(23, 133, 'Marta', 'Rosengard'),
(24, 134, 'Diego', 'Costa'),
(20, 135, 'Eden', 'Hazard'),
(19, 136, 'Cesc', 'Fabregas'),
(21, 137, 'Kante', 'Ngolo'),
(23, 138, 'Thibaut', 'Courtois'),
(24, 139, 'Mohamad', 'Zidane'),
(20, 140, 'Rami', 'Benatia'),
(19, 141, 'Adel', 'Rami'),
(21, 142, 'Tim', 'Cahill'),
(23, 143, 'David', 'Luiz'),
(24, 144, 'Ashley', 'Cole'),
(20, 145, 'Cole', 'Joe'),
(19, 146, 'Jimmy', 'Buttler'),
(21, 147, 'Hamm', 'Mia'),
(23, 148, 'Toni', 'Duggan'),
(24, 149, 'Casey', 'Stoney'),
(20, 150, 'Nadine', 'Angerer'),
(19, 151, 'Asllani', 'Kosrovare'),
(21, 152, 'Lilly', 'Sharapova'),
(23, 153, 'Eniola', 'Aluko'),
(24, 154, 'Laura', 'Bassett'),
(20, 155, 'Fara', 'Williams'),
(19, 156, 'Karen', 'Bardsley'),
(21, 157, 'Claire', 'Rafferty'),
(23, 158, 'Anja', 'Mittag'),
(24, 159, 'Kim', 'Little'),
(30, 160, 'Jose', 'Mourinho'),
(39, 161, 'Marko', 'Abrahmovic'),
(31, 162, 'Arnautovic', 'Javier'),
(33, 163, 'Arsene', 'Wenger'),
(34, 164, 'Gareth', 'Barry'),
(30, 165, 'Mohamad', 'Ali'),
(39, 166, 'Antonio', 'Conte'),
(31, 167, 'Rish', 'Asfour'),
(33, 168, 'Akhdar', 'Bale'),
(34, 169, 'Harry', 'Kane'),
(30, 170, 'Charlie', 'Puth'),
(39, 171, 'Joachim', 'Low'),
(31, 172, 'Christian', 'Eriksen'),
(33, 173, 'Kurt', 'Zouma'),
(34, 174, 'Van', 'Der-Vart'),
(30, 175, 'Samuel', 'Umtiti'),
(39, 176, 'Shakira', 'Pique'),
(31, 177, 'Lucas', 'Vasquez'),
(33, 178, 'Mark', 'Clattenburg'),
(34, 179, 'Oliver', 'Kahn'),
(30, 180, 'Tom', 'Hanks'),
(39, 181, 'Han', 'Solo'),
(31, 182, 'Olivier', 'Giroud'),
(33, 183, 'Michael', 'Jordan'),
(34, 184, 'Ilaramendi', 'Xhaka'),
(30, 185, 'Theo', 'Walcott'),
(39, 186, 'Tyson', 'Fury'),
(31, 187, 'Mike', 'Tyson'),
(33, 188, 'Mesut', 'Ozil'),
(34, 189, 'Eric', 'Dier'),
(30, 190, 'Diego', 'Simeone'),
(39, 191, 'West', 'Bromich'),
(31, 192, 'South', 'Hampton'),
(33, 193, 'Conor', 'Mcgregor'),
(34, 194, 'Philipe', 'Coutinho'),
(30, 195, 'Sergi', 'Busquets'),
(39, 196, 'Jonin', 'Nioh'),
(31, 197, 'Marcus', 'Rashford'),
(33, 198, 'Marlon', 'Navas'),
(34, 199, 'Thomas', 'Muller'),
(30, 200, 'Marco', 'Ancelotti'),
(39, 201, 'Ron', 'Potter'),
(31, 202, 'Harry', 'Weasley'),
(30, 203, 'Pele', 'Maradona'),
(39, 204, 'Santiago', 'Muniez'),
(31, 205, 'Bryan', 'Zues'),
(30, 206, 'Zagalo', 'Agentez'),
(39, 207, 'Garinsha', 'Cafu'),
(31, 208, 'Alvaro', 'Negredo'),
(30, 209, 'Diego', 'Alvarez'),
(39, 210, 'Michy', 'Batshuyai'),
(31, 211, 'Di', 'Stefano'),
(30, 212, 'De', 'Mateo'),
(39, 213, 'Antonio', 'Belloti'),
(31, 214, 'Paul', 'Pogba'),
(30, 215, 'Esteban', 'Drinkwater'),
(39, 216, 'Platini', 'Rondon'),
(31, 217, 'Alvaro', 'Moratien'),
(30, 218, 'Nacho', 'Rodriguez'),
(39, 219, 'Foret', 'Michele');





Insert into Player (teamPosition, teamRole, id, teamId)
Values
('DF', 'Captain', 100, 1),
('DF', 'Vice Captain', 101, 1),
('MF', 'Third Captain', 102, 1),
('SF', 'Fourth Captain', 103, 1),
('WF', 'Starting', 104, 1),
('DF', 'Captain', 105, 2),
('MF', 'Vice Captain', 106, 2),
('SF', 'Third Captain', 107, 2),
('WF', 'Fourth Captain', 108, 2),
('DF', 'Starting', 109, 3),
('MF', 'Captain', 110, 3),
('SF', 'Vice Captain', 111, 3),
('WF', 'Third Captain', 112, 4),
('DF', 'Fourth Captain', 113, 3),
('MF', 'Starting', 114, 3),
('SF', 'Captain', 115, 4),
('WF', 'Vice Captain', 116, 4),
('DF', 'Third Captain', 117, 4),
('MF', 'Fourth Captain', 118, 4),
('SF', 'Starting', 119, 5),
('WF', 'Captain', 120, 5),
('DF', 'Vice Captain', 121, 5),
('MF', 'Third Captain', 122, 5),
('SF', 'Fourth Captain', 123, 5),
('WF', 'Starting', 124, 5),
('DF', 'Captain', 125, 6),
('MF', 'Vice Captain', 126, 6),
('SF', 'Third Captain', 127, 6),
('WF', 'Fourth Captain', 128, 6),
('DF', 'Starting', 129, 6),
('MF', 'Captain', 130, 7),
('SF', 'Vice Captain', 131, 7),
('WF', 'Third Captain', 132, 7),
('DF', 'Fourth Captain', 133, 7),
('MF', 'Starting', 134, 7),
('SF', 'Captain', 135, 7),
('WF', 'Vice Captain', 136, 8),
('DF', 'Third Captain', 137, 8),
('MF', 'Fourth Captain', 138, 8),
('SF', 'Starting', 139, 8),
('WF', 'Captain', 140, 8),
('DF', 'Vice Captain', 141, 8),
('MF', 'Third Captain', 142, 9),
('SF', 'Fourth Captain', 143, 9),
('WF', 'Starting', 144, 9),
('DF', 'Captain', 145, 9),
('MF', 'Vice Captain', 146, 9),
('SF', 'Third Captain', 147, 10),
('WF', 'Fourth Captain', 148, 10),
('DF', 'Starting', 149, 10),
('MF', 'Captain', 150, 10),
('SF', 'Vice Captain', 151, 11),
('WF', 'Third Captain', 152, 11),
('DF', 'Fourth Captain', 153, 11),
('MF', 'Starting', 154, 11),
('SF', 'Captain', 155, 12),
('WF', 'Vice Captain', 156, 12),
('DF', 'Third Captain', 157, 12),
('MF', 'Fourth Captain', 158, 12),
('SF', 'Starting', 159, 12);

Insert into records (numberOfMatchesPlayed, numberOfGoals, recordNumber, startDate)
Values
(0, 13, 300, '2016-03-07'),
(2, 17, 301, '2015-04-25'),
(3, 19, 302, '2016-03-08'),
(6, 18, 303, '2014-02-06'),
(5, 16, 304, '2017-04-06'),
(8, 34, 305, '2016-03-07'),
(0, 12, 306, '2015-04-25'),
(0, 9, 307, '2016-03-08'),
(0, 15, 308, '2014-02-06'),
(0, 11, 309, '2017-04-06'),
(0, 14, 310, '2016-03-07'),
(1, 15, 311, '2015-04-25'),
(1, 13, 312, '2016-03-08'),
(0, 2, 313, '2014-02-06'),
(0, 3, 314, '2017-04-06'),
(0, 4, 315, '2016-03-07'),
(0, 0, 316, '2016-04-25'),
(2, 11, 317, '2016-03-08'),
(0, 9, 318, '2014-02-06'),
(3, 5, 319, '2017-04-06'),
(6, 12, 320, '2016-03-07'),
(0, 2, 321, '2015-04-25'),
(3, 3, 322, '2016-03-08'),
(2, 3, 323, '2014-02-06'),
(0, 2, 324, '2017-04-06'),
(0, 1, 325, '2016-03-07'),
(0, 12, 326, '2015-04-25'),
(0, 2, 327, '2016-03-08'),
(0, 12, 328, '2014-02-06'),
(0, 12, 329, '2017-04-06'),
(1, 9, 330, '2016-03-07'),
(2, 2, 331, '2015-04-25'),
(5, 10, 332, '2016-03-08'),
(12, 19, 333, '2014-02-06'),
(12, 19, 334, '2017-04-06'),
(15, 18, 335, '2016-03-07'),
(23, 2, 336, '2015-04-25'),
(16, 18, 337, '2016-03-08'),
(23, 18, 338, '2014-02-06'),
(25, 8, 339, '2017-04-06'),
(24, 20, 340, '2016-03-07'),
(29, 20, 341, '2015-04-25'),
(19, 20, 342, '2016-03-08'),
(28, 21, 343, '2014-02-06'),
(15, 21, 344, '2017-04-06'),
(13, 24, 345, '2016-03-07'),
(14, 19, 346, '2015-04-25'),
(16, 15, 347, '2016-03-08'),
(19, 21, 348, '2014-02-06'),
(18, 12, 349, '2017-04-06'),
(13, 10, 350, '2016-03-07'),
(15, 68, 351, '2015-04-25'),
(21, 68, 352, '2016-03-08'),
(12, 15, 353, '2014-02-06'),
(64, 14, 354, '2017-04-06'),
(56, 16, 355, '2014-02-06'),
(20, 15, 356, '2017-04-06'),
(20, 12, 357, '2014-02-06'),
(10, 13, 358, '2017-04-06'),
(12, 22, 359, '2017-04-06'),
(64, 226,    360, '2002-02-06'),
(45, 165,    361, '2003-04-06'),
(31, 97, 362, '2004-03-07'),
(97, 345,    363, '2005-04-25'),
(45, 68, 364, '2006-03-08'),
(543,   126,    365, '2001-02-06'),
(568,   435,    366, '1997-04-06'),
(248,   681,    367, '1998-02-06'),
(312,   358,    368, '2006-04-06'),
(97, 156,    369, '2009-02-06'),
(76,    135,    370, '2004-04-06'),
(161,   358,    371, '2003-04-06');


Insert Into playerrecord (height, weight, yearsOfExperience, recordNumber, playerId, numberOfAssists)
VALUES
(180, 60, 1, 300, 100, 0),
(182, 61, 2, 301, 101, 0),
(180, 62, 2, 302, 102, 0),
(183, 63, 5, 303, 103, 0),
(185, 64, 4, 304, 104, 0),
(192, 65, 2, 305, 105, 0),
(200, 66, 1, 306, 106, 0),
(188, 67, 2, 307, 107, 0),
(171, 68, 1, 308, 108, 0),
(172, 69, 2, 309, 109, 0),
(176, 70, 3, 310, 110, 0),
(168, 72, 3, 311, 111, 0),
(193, 76, 3, 312, 112, 0),
(202, 60, 4, 313, 113, 0),
(188, 82, 4, 314, 114, 0),
(163, 73, 3, 315, 115, 0),
(185, 79, 6, 316, 116, 0),
(196, 80, 5, 317, 117, 0),
(184, 62, 2, 318, 118, 0),
(184, 63, 1, 319, 119, 0),
(186, 64, 5, 320, 120, 0),
(165, 65, 4, 321, 121, 3),
(175, 66, 8, 322, 122, 2),
(176, 67, 9, 323, 123, 5),
(198, 68, 5, 324, 124, 6),
(186, 69, 2, 325, 125, 8),
(180, 70, 3, 326, 126, 9),
(182, 71, 1, 327, 127, 2),
(181, 72, 5, 328, 128, 0),
(180, 73, 4, 329, 129, 5),
(163, 74, 6, 330, 130, 2),
(189, 75, 3, 331, 131, 3),
(199, 76, 2, 332, 132, 7),
(197, 77, 3, 333, 133, 5),
(195, 78, 2, 334, 134, 2),
(194, 79, 3, 335, 135, 6),
(174, 80, 3, 336, 136, 5),
(178, 81, 2, 337, 137, 2),
(184, 82, 1, 338, 138, 6),
(196, 83, 5, 339, 139, 3),
(162, 84, 4, 340, 140, 4),
(163, 85, 8, 341, 141, 0),
(168, 86, 4, 342, 142, 2),
(194, 87, 2, 343, 143, 10),
(192, 88, 3, 344, 144, 12),
(190, 89, 2, 345, 145, 12),
(203, 90, 1, 346, 146, 23),
(201, 75, 2, 347, 147, 15),
(205, 74, 3, 348, 148, 1),
(213, 68, 2, 349, 149, 2),
(184, 69, 1, 350, 150, 3),
(185, 70, 5, 351, 151, 6),
(186, 71, 2, 352, 152, 5),
(182, 72, 3, 353, 153, 4),
(183, 63, 1, 354, 154, 8),
(180, 64, 2, 355, 155, 7),
(189, 65, 3, 356, 156, 0),
(182, 66, 2, 357, 157, 0),
(184, 67, 6, 358, 158, 0),
(174, 68, 3, 359, 159, 0);

Insert into teamrecord (teamId, numberOfLosses, numberOfWins, recordNumber)
Values
(1, 6, 28, 360),
(2, 10, 24, 361),
(3, 2, 32, 362),
(4, 6, 1, 363),
(5, 34, 0, 364),
(6, 26, 8, 365),
(7, 28, 6, 366),
(8, 11, 23, 367),
(9, 3, 31, 368),
(10,6, 28, 369),
(11,6, 28, 370),
(12,6, 28, 371);



Insert into awards (awardName, recordNumber)
Values
('Top Scorer' , 320),
('Most Assists', 349),
('Most Clean Sheets', 318),
('Most Yellow Cards', 310),
('Most Valuable Player', 339),
('Best Team', 360),
('Red Bull Award', 365),
('Houssam El Deen Hariri Soccer Award', 368),
('Houssam El Deen Hariri Basketball Award', 370);




Insert into teamvsteam (gameDate, teamAId, teamBId,scoreA, scoreB)
Values
('2014-01-03' , 1 , 6, 2, 1),
('2014-01-04' , 12 , 7, 6, 3),
('2015-01-03' , 1 , 6, 11, 1),
('2015-01-06' , 12 , 7, 90, 63),
('2016-01-09' , 1 , 6, 100, 98),
('2016-01-10' , 12 , 7, 1, 1),
('2014-04-03' , 3 , 8, 3, 4),
('2014-05-04' , 4 , 11, 1, 2),
('2014-08-03' , 4 , 9, 3, 5),
('2014-09-04' , 8 , 4, 4, 2),
('2015-11-03' , 9 , 4, 5, 6),
('2015-10-06' , 3 , 11, 12, 9),
('2015-05-03' , 4 , 12, 7, 1),
('2015-04-06' , 8 , 4, 4, 1),
('2016-02-09' , 9 , 3, 3, 3),
('2016-02-10' , 11 , 4, 2, 2),
('2016-02-09' , 12 , 3, 1, 5),
('2011-11-10' , 12 , 8, 8, 2),
('2012-05-10' , 10 , 5, 3, 4),
('2013-04-10' , 10 , 5, 1, 6),
('2015-05-10' , 10 , 5, 1, 9),
('2016-01-10' , 10 , 5, 90, 103);

insert into staff (role ,id, teamId)
values
('President' ,160, 1),
('Vice President' ,161, 1),
('Manager' ,162, 1),
('Assistant manager' ,163, 1),
('Fitness' ,164, 1),
('President' ,165, 2),
('Vice President' ,166, 2),
('Manager' ,167, 2),
('Assistant manager' ,168, 2),
('Fitness' ,169, 2),
('President' ,170, 3),
('Vice President' ,172, 3),
('Manager' ,173,   3),
('Assistant manager' ,174, 3),
('Fitness' ,175, 3),
('President' ,176, 4),
('Vice President' ,177, 4),
('Manager' ,178, 4),
('Assistant manager' ,179, 4),
('Fitness' ,180, 4),
('President' ,181, 5),
('Vice President' ,182, 5),
('Manager' ,183, 5),
('Assistant manager' ,184, 5),
('Fitness' ,185, 5),
('President' ,186, 6),
('Vice President' ,187, 6),
('Manager' ,188, 6),
('Assistant manager' ,189, 6),
('Fitness' ,190, 6),
('President' ,191, 7),
('Manager' ,192, 7),
('Assistant manager' ,193, 7),
('Fitness' ,194, 7),
('President' ,195, 8),
('Vice President' ,196, 8),
('Manager' ,197, 8),
('Assistant manager' ,198, 8),
('Fitness' ,199, 8),
('President' ,200, 9),
('Vice President' ,201, 9),
('Manager' ,202, 9),
('Assistant manager' ,203, 9),
('Fitness' ,204, 9),
('President' ,205, 10),
('Vice President' ,206, 10),
('Manager' ,207, 10),
('Assistant manager' ,208, 10),
('Fitness' ,209, 10),
('President' ,210, 11),
('Vice President' ,211, 11),
('Manager' ,212, 11),
('Assistant manager' ,213, 11),
('Fitness' ,214, 11),
('President' ,215, 12),
('Vice President' ,216, 12),
('Manager' ,217, 12),
('Assistant manager' ,218, 12),
('Fitness' ,219, 12);


insert into playersMatchHistory (playerId ,teamAId, teamBId, playedDate, score)
values
(100, 1,2,'2015-02-21',2),
(101, 1,3,'2015-03-23',1),
(102, 1,4,'2015-04-23',1),
(103, 1,5,'2015-05-23',2),
(104, 1,6,'2015-06-23',0),
(105, 2,7,'2015-07-23',0),
(106, 2,8,'2015-08-23',1),
(107, 2,9,'2015-09-23',1),
(108, 2,10,'2015-10-23',2),
(109, 3,4,'2015-11-22',3),
(110, 3,12,'2015-02-11',4),
(111, 3,1,'2015-02-27',4),
(112, 4,2,'2015-02-28',1),
(113, 3,2,'2015-02-27',1),
(114, 3,9,'2015-02-20',1),
(115, 4,8,'2011-02-23',1),
(116, 4,7,'2015-02-23',2),
(117, 4,6,'2015-02-23',0),
( 118, 4,4,'2017-02-23',0),
(119, 5,3,'2014-02-23',0),
(120, 5,2,'2000-02-23',0),
(121, 5,10,'2013-02-23',0),
( 122, 5,9,'2015-02-23',4),
(123, 5,8,'2015-02-23',0),
(124, 5,7,'2015-02-23',0),
(125, 6,6,'2015-02-23',0),
(126, 6,5,'2015-02-23',2),
( 127, 6,4,'2015-02-23',2),
(128, 6,2,'2015-02-23',2),
(129, 6,12,'2015-02-23',2),
 (130, 7,12,'2015-02-23',0),
( 131, 7,12,'2012-02-23',0);
