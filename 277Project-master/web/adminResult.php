<?php
	include("checkSession.php");
if(!isset($_SESSION["lastLogIn"])){
   ?>
   <script>
   alert("Please Log-in or Sign-up first! So you can add a product");
   window.location.href="index.php";
   </script>
   <?php
}else{
	$userName=$_SESSION["userName"];
}
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
$queryListOfTeams= "select teamName from team where 1";
$queryListOfPlayers= "select firstName, lastName  from playerInfo where 1";
$queryListOfClubs= "select clubName  from club where 1";
?>
<!doctype html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css"  />
</head>
<body>
	<h1>Result</h1>
  <?php
	// for Team result
    if(isset($_REQUEST["getTeamPlayer"])){
				?><div id="editType" style="display:none;">player</div><?php
        $teamName=$db->quote($_REQUEST["selectedTeam"]);
        $query="select fullName, age, teamPosition, teamRole from playerInfo where teamName=".$teamName;
        $rows=$db->query($query);
        ?>
        <table>
          <caption><?=$_REQUEST["selectedTeam"]?> Has the following Players:</caption>
          <tr>
            <th>Full_Name</th> <th>Age</th>  <th>Team_Position</th>  <th>Team_Role</th> <th>Admin_Section</th>
          </tr>
          <tr>
            <td contenteditable ></td> <td contenteditable></td>  <td contenteditable></td>  <td contenteditable></td> <td><button id="insert">Add Record</button></td>
          </tr>
        <?php
        foreach ($rows as $row) {
          ?>
          <tr id="id">
            <td contenteditable><?=$row["fullName"]?> <td contenteditable><?=$row["age"]?></td> <td contenteditable><?=$row["teamPosition"]?></td> <td contenteditable><?=$row["teamRole"]?>></td>
            <td><button id="update+id">Update Record</button><button id="delete+id">Delete Record</button></td>
          </tr>
          <?php
        }
        ?>
      </table>
        <?php
    }
    else if(isset($_REQUEST["getTeamRecord"])){
      $teamName=$db->quote($_REQUEST["selectedTeam"]);
      $query="select r.numberOfMatchesPlayed, r.startDate, tr.numberOfWins, tr.numberOfLosses, t.clubName
              from records r, teamRecord tr, team t
              where t.id=tr.teamId and
              tr.recordNumber=r.recordNumber and
              t.teamName=".$teamName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedTeam"]?> Has the following Record:</caption>
        <tr>
          <th>Parent Club</th> <th>Wins</th> <th>Losses</th>  <th>Foundation_Date</th>  <th>Matches_Played</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["clubName"]?></td> <td><?=$row["numberOfWins"]?></td> <td><?=$row["numberOfLosses"]?></td> <td><?=$row["startDate"]?></td> <td><?=$row["numberOfMatchesPlayed"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    else if(isset($_REQUEST["getTeamMatchesHistory"])){
      $teamName=$db->quote($_REQUEST["selectedTeam"]);
      $query="select mh.gameDate, ta.teamName as teamA, tb.teamName as teamB, mh.scoreA, mh.scoreB
              from teamVsTeam mh, team ta, team tb
              where
              mh.teamAId=ta.Id  and
              mh.teamBId=tb.Id and
              ta.teamName=".$teamName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedTeam"]?> Has the following Match History:</caption>
        <tr>
          <th>Game_Date</th> <th>Team A</th> <th>Score A</th>  <th>Score B</th>  <th>Team B</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["gameDate"]?></td> <td><?=$row["teamA"]?></td> <td><?=$row["scoreA"]?></td> <td><?=$row["scoreB"]?></td> <td><?=$row["teamB"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    else if(isset($_REQUEST["getTeamStaff"])){
      $teamName=$db->quote($_REQUEST["selectedTeam"]);
      $query="select firstName, lastName, age, role
              from staffInfo
              where
              teamName=".$teamName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedTeam"]?> Has the following Staff Members:</caption>
        <tr>
          <th>First_Name</th> <th>last_Name</th> <th>Age</th>  <th>Role</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["firstName"]?></td> <td><?=$row["lastName"]?></td> <td><?=$row["age"]?></td> <td><?=$row["role"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    else if(isset($_REQUEST["getTeamTournamnet"])){
      $teamName=$db->quote($_REQUEST["selectedTeam"]);
      $query="select t.startDate, t.endDate, t.tournamentName
              from teamparticipatedintournament tp, tournament t, team
              where
               tp.tournamentName=t.tournamentName and
               tp.tournamentStartDate=t.startDate and
               team.id=tp.teamId and
               teamName=".$teamName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedTeam"]?> Has participated in the following torunament:</caption>
        <tr>
          <th>Tournamnet_Name</th> <th>Starting_Date</th> <th>Finishing_Date</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["tournamentName"]?></td> <td><?=$row["startDate"]?></td> <td><?=$row["endDate"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    // now for the player
    else if(isset($_REQUEST["getPlayerInfo"])){
      $playerName=$db->quote($_REQUEST["selectedPlayer"]);
      $query="select *
              from playerInfo
              where
              fullName=".$playerName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedPlayer"]?> Has the following Record:</caption>
        <tr>
          <th>Full_Name</th> <th>Age</th> <th>Height(CM)</th> <th>Weight (KG)</th> <th>Year_Of_Experience</th>  <th>Team_Name</th> <th>Team_Position</th>  <th>Team_Role</th> <th>Total_Goals</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["fullName"]?><td><?=$row["age"]?></td> <td><?=$row["height"]?>
          </td> <td><?=$row["weight"]?></td> <td><?=$row["yearsOfExperience"]?></td>  <td><?=$row["teamName"]?></td>
           <td><?=$row["teamPosition"]?></td> </td> <td><?=$row["teamRole"]?></td> <td><?=$row["numberOfGoals"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    else if(isset($_REQUEST["getPlayerAwards"])){
      $playerName=$db->quote($_REQUEST["selectedPlayer"]);
      $query="select *
              from playerAwards
              where fullName=".$playerName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedPlayer"]?> Has the following Award:</caption>
        <tr>
          <th>Full_Name</th> <th>Award_Name</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["fullName"]?><td><?=$row["awardName"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
		else if(isset($_REQUEST["getPlayerMatchHistory"])){
      $playerName=$db->quote($_REQUEST["selectedPlayer"]);
      $query="select *
              from playermatches
              where fullName=".$playerName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedPlayer"]?> Has the following Matches History:</caption>
        <tr>
          <th>Team_A</th> <th>Team_B</th> <th>Scored</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["teamA"]?><td><?=$row["teamB"]?></td> <td><?=$row["score"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    // For Clubs
    else if(isset($_REQUEST["getClubInfo"])){
      $clubName=$db->quote($_REQUEST["selectedClub"]);
      $query="select *
              from club
              where
              clubName=".$clubName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedClub"]?> club Has the following Info:</caption>
        <tr>
          <th>President</th> <th>Foundation_Date</th> <th>Location</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["president"]?></td> <td><?=$row["dateofCreation"]?></td> <td><?=$row["location"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    else if(isset($_REQUEST["getClubTeam"])){
      $clubName=$db->quote($_REQUEST["selectedClub"]);
      $query="select teamName, sportName, totalPlayers
              from clubTeams
              where
              clubName=".$clubName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedClub"]?> club Has the following Team(s):</caption>
        <tr>
          <th>Team_Name</th> <th>Sport_Name</th> <th>Total_Players</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["teamName"]?></td> <td><?=$row["sportName"]?></td> <td><?=$row["totalPlayers"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
    else if(isset($_REQUEST["getClubCourt"])){
      $clubName=$db->quote($_REQUEST["selectedClub"]);
      $query="select courtName, courtType, courtCondition, courtSize
              from clubCourts
              where
							clubName=".$clubName;
      $rows=$db->query($query);
      ?>
      <table>
        <caption><?=$_REQUEST["selectedClub"]?> club Has the following Court(s):</caption>
        <tr>
          <th>Court_Name</th> <th>Court_Type</th> <th>Court_Condition</th> <th>Size (M)</th>
        </tr>
      <?php
      foreach ($rows as $row) {
        ?>
        <tr>
          <td><?=$row["courtName"]?></td> <td><?=$row["courtType"]?></td> <td><?=$row["courtCondition"]?></td> <td><?=$row["courtSize"]?></td>
        </tr>
        <?php
      }
      ?>
    </table>
      <?php
    }
   ?>
</body>
</html>
