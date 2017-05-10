<?php
	include("checkSession.php");
if(!isset($_SESSION["lastLogIn"])){
   ?>
   <script>
   alert("Please Log-in or Sign-up first! so continue browsing the website ");
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sports Teams</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">
    <style>
      table, td, th {
          border: 1px solid #ddd;
          text-align: left;
      }

      table {
          border-collapse: collapse;
          width: 50%;
          margin: auto;
      }

      th, td {
          padding: 15px;
          font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
      }
      tr:hover {background-color: #f5f5f5}
    </style>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="brand">Sports Teams</div>
    <div class="address-bar">Lebanon</div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Business Casual</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <?php
                $logInStatusLink;
                $logInOrOutText;
                $isAdmin=null;
                if(isset($_SESSION["userName"])){
                  // user is logged In
                  $logInStatusLink="logUserOut.php";
                  $logInOrOutText="Log-Out";
                  if( $_SESSION["isAdmin"]=="true"){
                      // user is an admin
                        $isAdmin=true;
                  }else{
                    // user in not an admin
                    $isAdmin=false;
                  }
                }else{
                  $logInStatusLink="logIn.php";
                  $logInOrOutText="Log-In";

                }

                ?>
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li>
                    <a href="clubs.php">Clubs</a>
                </li>
                <li>
                    <a href="teams.php">Teams</a>
                </li>

                <li>
                    <a href="players.php">Players</a>
                </li>
                <?php
                  if($isAdmin){
                    ?>
                    <li>
                        <a href="adminUser.php">Editing Section</a>
                    </li>
                    <?php
                  }
                ?>
                <li>
                    <a href="<?=$logInStatusLink?>"><?=$logInOrOutText?></a>
                </li>
              </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">


        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Results</strong>
                    </h2>
                    <hr>
                </div>
                <?php
              	// for Team result
                  if(isset($_REQUEST["getTeamPlayer"])){
                      $teamName=$db->quote($_REQUEST["selectedTeam"]);
                      $query="select fullName, age, teamPosition, teamRole from playerInfo where teamName=".$teamName;
                      $rows=$db->query($query);
                      ?>
                      <table>
                        <caption><?=$_REQUEST["selectedTeam"]?> Has the following Players:</caption>
                        <tr>
                          <th>Full_Name</th> <th>Age</th>  <th>Team_Position</th>  <th>Team_Role</th>
                        </tr>
                      <?php
                      foreach ($rows as $row) {
                        ?>
                        <tr>
                          <td><?=$row["fullName"]?> <td><?=$row["age"]?></td> <td><?=$row["teamPosition"]?></td> <td><?=$row["teamRole"]?></td>
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

                <div class="clearfix"></div>

            </div>
        </div>

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
