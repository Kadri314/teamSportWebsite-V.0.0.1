<?php
// 1- making connection to the dataBase
$db;
try{
$db= new PDO("mysql:host=localhost;dbname=UniversitySport","root","");
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }catch(PDOException $e) {
   header("HTTP/1.1 400 Invalid Request");
 die("connection failed");
 }
// connection is established successfuly to dataBase
// Deleteing ...
if(isset($_REQUEST["deleteTeam"])){
  $teamName=$db->quote($_REQUEST["teamName"]);
  $recordId;
  //1- get team Record number
  $queryGetRecordId="select tr.recordNumber
          from team t, teamRecord tr
          where t.id=tr.teamid and
          t.teamName=".$teamName;
  $rows=$db->query($queryGetRecordId);
  foreach ($rows as $row) {
    $recordId=$row["recordNumber"];
  }
  //2- delete team main record from record table
  $queryDeleteMainRecord="delete from records  where recordNumber=".$recordId;
  $db->exec($queryDeleteMainRecord);
  //3- delete the team
  $queryDeleteTeaM="delete from team  where teamName=".$teamName;
  $db->exec($queryDeleteTeaM);
  echo $_REQUEST["teamName"]." Has Been Deleted Successfuly";
}
 else if(isset($_REQUEST["deletePlayer"])){
   $playerName=explode(" ",$_REQUEST["playerName"]);
   $firstName=$db->quote($playerName[0]);
   $lastName=$db->quote($playerName[1]);
   $recordId;
   //1- get team Record number
   $queryGetRecordId="select pr.recordNumber
           from player p, playerRecord pr, members m
           where p.id=m.id and
           p.id=pr.playerId and
           m.firstName=".$firstName." and
           m.lastName=".$lastName;
   $rows=$db->query($queryGetRecordId);
   foreach ($rows as $row) {
     $recordId=$row["recordNumber"];
   }
   //2- delete team main record from record table
   $queryDeleteMainRecord="delete from records  where recordNumber=".$recordId;
   $db->exec($queryDeleteMainRecord);
   //3- delete the team
   $queryDeletePlayer="delete from members
          where firstName=".$firstName." and
                lastName=".$lastName;
  $db->exec($queryDeletePlayer);
   echo $_REQUEST["playerName"]." Has Been Deleted Successfuly";

}
 else if(isset($_REQUEST["deleteStaff"])){
   $staffName=explode(" ",$_REQUEST["staffName"]);
   $firstName=$db->quote($staffName[0]);
   $lastName=$db->quote($staffName[1]);
   $query="delete from members
          where firstName=".$firstName." and
                lastName=".$lastName;
  $db->exec($query);
   echo $_REQUEST["staffName"]." Has Been Deleted Successfuly";
}
 else if(isset($_REQUEST["deleteSponsor"])){//
   $sponsorName=$db->quote($_REQUEST["sponsorName"]);
   $query="delete from sponsor  where sponsorName=".$sponsorName;
   $db->exec($query);
   echo $_REQUEST["sponsorName"]." Has Been Deleted Successfuly";
}
 else if(isset($_REQUEST["deleteTournament"])){
   $tournamnetName=$db->quote($_REQUEST["tournamentName"]);
   $query="delete from tournament  where tournamentName=".$tournamnetName;
   $db->exec($query);
   echo $_REQUEST["tournamentName"]." Has Been Deleted Successfuly";
}
// insertion.....
else if(isset($_REQUEST["insertTeam"])){
  $teamName=$db->quote($_REQUEST["teamName"]);
  $clubName=$db->quote($_REQUEST["selectedClub"]);
  $sportName=$db->quote($_REQUEST["sportName"]);
  // Before any thing we check if the teamName exist, then we prevent the insertion since teamName must be unique
  $querycheckUnique="select teamName from team where teamName=".$teamName;
  $result=$db->query($querycheckUnique);
  if($result->rowCount()>0){
    // means the first and last name already exist so we prevent the insertion
    ?>
    <script>
      alert("Falure! <?=$teamName?> already exist! ");
       window.location.href="adminUser.php";
    </script>
    <?php
  }
  else{
    $query="insert into team (clubName, sportName , teamName)
            VALUES ($clubName,$sportName,$teamName)";
    $db->exec($query);
    ?>
    <script>
      alert("Insertion Completed Successfuly!");
       window.location.href="adminUser.php";
    </script>
    <?php

  }
}
else if(isset($_REQUEST["insertClub"])){
  $presidentName=$db->quote($_REQUEST["presidentName"]);
  $clubName=$db->quote($_REQUEST["clubName"]);
  $location=$db->quote($_REQUEST["location"]);
  $foundationDate=$db->quote($_REQUEST["foundationDate"]);
  // Before any thing we check if the clubName exist, then we prevent the insertion since clubName must be unique
  $querycheckUnique="select clubName from club where clubName=".$clubName;
  $result=$db->query($querycheckUnique);
  if($result->rowCount()>0){
    // means the first and last name already exist so we prevent the insertion
    ?>
    <script>
      alert("Falure! <?=$clubName?> already exist! ");
       window.location.href="adminUser.php";
    </script>
    <?php
  }
  else{
    $query="INSERT INTO club (president,clubName,dateofCreation,location)
         VALUES ($presidentName,$clubName,$foundationDate,$location)";
    $db->exec($query);
    ?>
    <script>
      alert("Insertion Completed Successfuly!");
       window.location.href="adminUser.php";
    </script>
    <?php
  }


}
else if(isset($_REQUEST["insertTournament"])){
  $numberOfRounds=$_REQUEST["numberOfRounds"];
  $tournamentName=$db->quote($_REQUEST["tournamentName"]);
  $prize=$_REQUEST["prize"];
  $startingDate=$db->quote($_REQUEST["startingDate"]);
  $endingDate=$db->quote($_REQUEST["endingDate"]);
  $tournamentType=$db->quote($_REQUEST["tournamentType"]);
  // Before any thing we check if the starting date and torunamentName exist, then we prevent the insertion since they must be unique
  $querycheckUnique="select tournamentName from tournament where tournamentName=".$tournamentName." and startDate=".$startingDate;
  $result=$db->query($querycheckUnique);
  if($result->rowCount()>0){
    // means the first and last name already exist so we prevent the insertion
    ?>
    <script>
      alert("Falure! <?=$_REQUEST["tournamentName"]?> that starts in <?=$_REQUEST["startingDate"]?>  already exist! ");
       window.location.href="adminUser.php";
    </script>
    <?php
  }
  else{
    $query="INSERT INTO tournament (numberOfRounds , prizePool , tournamentType, endDate, startDate, tournamentName)
         VALUES ($numberOfRounds,$prize,$tournamentType,$endingDate,$startingDate,$tournamentName )";
    $db->exec($query);
    ?>
    <script>
      alert("Insertion Completed Successfuly!");
       window.location.href="adminUser.php";
    </script>
    <?php
  }
}
else if(isset($_REQUEST["insertPlayer"])){
  $firstName=$db->quote($_REQUEST["firstName"]);
  $lastName=$db->quote($_REQUEST["lastName"]);
  $age=$_REQUEST["age"];
  $teamPosition=$db->quote($_REQUEST["teamPosition"]);
  $teamRole=$db->quote($_REQUEST["teamRole"]);
  $teamName=$db->quote($_REQUEST["teamName"]);
  $teamId;
  // Before any thing we check if the firstName and lstName of player exist we prevent the insertion since first and last name must be unique
  $querycheckUnique="select id from members where firstname=".$firstName."and lastName=".$lastName;
  $result=$db->query($querycheckUnique);
  if($result->rowCount()>0){
    // means the first and last name already exist so we prevent the insertion
    ?>
    <script>
      alert("Falure! The player: <?=$_REQUEST["firstName"]." ".$_REQUEST["lastName"]?> already exist! ");
       window.location.href="adminUser.php";
    </script>
    <?php
  }
  else{
    //1- retreive the team id
      $queryGetTeamId="select id from team where teamName=".$teamName;
      $rows=$db->query($queryGetTeamId);
      foreach ($rows as $row ) {
        $teamId=$row["id"];
      }
      //2- insert the player into members
    $queryaddmember="Insert into members (age,firstName, lastName)
            Values
            ($age,$firstName,$lastName)";
    $db->exec($queryaddmember);
    //3- get the id of the current inserted member(Player)
    $playerId;
    $querygetPlayerId="select id from members where firstname=".$firstName."and lastName=".$lastName;
    $rows=$db->query($querygetPlayerId);
    foreach ($rows as $row ) {
      $playerId=$row["id"];
    }
    //4- finally inserting into player table
    $queryaddPlayer="Insert into Player (teamPosition, teamRole, id, teamId)
            Values
            ($teamPosition,$teamRole,$playerId,$teamId)";
    $db->exec($queryaddPlayer);
    ?>
    <script>
      alert("Insertion Completed Successfuly!");
       window.location.href="adminUser.php";
    </script>
    <?php
  }

}

else if(isset($_REQUEST["insertStaff"])){
  $firstName=$db->quote($_REQUEST["firstName"]);
  $lastName=$db->quote($_REQUEST["lastName"]);
  $age=$_REQUEST["age"];
  $role=$db->quote($_REQUEST["role"]);
  $teamName=$db->quote($_REQUEST["teamName"]);
  $teamId;
  // Before any thing we check if the firstName and lstName of staff exist, we prevent the insertion since first and last name must be unique
  $querycheckUnique="select id from members where firstname=".$firstName."and lastName=".$lastName;
  $result=$db->query($querycheckUnique);
  if($result->rowCount()>0){
    // means the first and last name already exist so we prevent the insertion
    ?>
    <script>
      alert("Falure! The Player: <?=$_REQUEST["firstName"]." ".$_REQUEST["lastName"]?> already exist! ");
      window.location.href="adminUser.php";
    </script>
    <?php
  }
  else{
    //1- retreive the team id
      $queryGetTeamId="select id from team where teamName=".$teamName;
      $rows=$db->query($queryGetTeamId);
      foreach ($rows as $row ) {
        $teamId=$row["id"];
      }
      //2- insert the staff into members
    $queryaddmember="Insert into members (age,firstName, lastName)
            Values
            ($age,$firstName,$lastName)";
    $db->exec($queryaddmember);
    //3- get the id of the current inserted member(staff)
    $staffId;
    $querygetStaffId="select id from members where firstname=".$firstName."and lastName=".$lastName;
    $rows=$db->query($querygetStaffId);
    foreach ($rows as $row ) {
      $staffId=$row["id"];
    }
    //4- finally inserting into player table
    $queryaddStaff="Insert into staff (role ,id, teamId)
            Values
            ($role,$staffId,$teamId)";
    $db->exec($queryaddStaff);
    ?>
    <script>
      alert("Insertion Completed Successfuly!");
      window.location.href="adminUser.php";
    </script>
    <?php
  }
}

else{
  die("Unathorized Access");
}

?>
