<?php
	include("checkSession.php");
if(!isset($_SESSION["lastLogIn"])){

   ?>
   <script>
	 alert("Please Log-in or Sign-up first! so continue browsing the website ");
   window.location.href="login.php";
   </script>
   <?php
}else{
	if( $_SESSION["isAdmin"]!="true"){
			// user is not an admin
			die("Unauthorized Access!");
			header('Location:home.php');
	}
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
$queryListOfPlayers= "select fullName  from playerInfo where 1";
$queryListOfStaff= "select firstName, lastName  from members, staff where staff.id=members.id";
$queryListOfTorunamnets= "select tournamentName  from tournament where 1";
$queryListOfClubs= "select clubName  from club where 1";
$queryListOfSponsors="select sponsorName from sponsor where 1";
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
	 	<script src="js/IRUD.js"></script>

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
                        <strong>Admin Page</strong>
                    </h2>
                    <hr/>
                </div>
					<h1 class="cscs">Deletion Section:</h1>
					<!-- FOR teams  -->
							<h3>Remove A Team</h3>
							<label>List Of Teams:</label>
							<select name="listOfTeams" id="selectedTeamToRemove">
								<?php
									$rows=$db->query($queryListOfTeams);
									foreach ($rows as $row) {
										?>
										<option><?= $row["teamName"]; ?></option>
										<?php
									}
								 ?>
							</select><br/>
							<label>Delete Selected Team  : </label>
							<button onclick="rmTeam()" />Remove Selected Team</button><br/>
							<hr/>
						<!-- delete Player -->
								<h3>Remove A Player</h3>
								<label>List Of Players:</label>
								<select id="selectedPlayerToRemove">
									<?php
										$rows=$db->query($queryListOfPlayers);
										foreach ($rows as $row) {
											?>
											<option><?= $row["fullName"]; ?></option>
											<?php
										}
									 ?>
								</select><br/>
								<label>Delete Selected Player: </label>
								<button onclick="rmPlayer()" />Remove Selected player</button><br/>
								<hr/>
								<!-- delete a staff -->
								<h3>Remove A Staff</h3>
								<label>List Of Staff:</label>
								<select id="selectedStaffToRemove">
									<?php
										$rows=$db->query($queryListOfStaff);
										foreach ($rows as $row) {
											?>
											<option><?= $row["firstName"]." ".$row["lastName"]; ?></option>
											<?php
										}
									 ?>
								</select><br/>
								<label>Delete Selected Staff: </label>
								<button onclick="rmStaff()" />Remove Selected Staff</button><br/>
								<hr/>
								<!-- delete sponsors -->
								<h3>Remove A Sponsor</h3>
								<label>List Of Sponsors:</label>
								<select id="selectedSponsorToRemove">
									<?php
										$rows=$db->query($queryListOfSponsors);
										foreach ($rows as $row) {
											?>
											<option><?= $row["sponsorName"] ?></option>
											<?php
										}
									 ?>
								</select><br/>
								<label>Delete Selected sponsor  : </label>
								<button onclick="rmSponsor()" />Remove Selected Sponsor</button><br/>
								<hr/>
						<!-- delete torunamnet -->
						<h3>Remove A Tournament</h3>
						<label>List Of Tournaments:</label>
						<select id="selectedTournamentToRemove">
							<?php
								$rows=$db->query($queryListOfTorunamnets);
								foreach ($rows as $row) {
									?>
									<option><?= $row["tournamentName"]; ?></option>
									<?php
								}
							 ?>
						</select><br/>
						<label>Delete Selected Torunamnet  : </label>
						<button onclick="rmTournament()" />Remove Selected Tournament</button><br/>
						<hr/>
					<!-- insert -->
					<h2 class="cscs">Insertion Section:</h2>

					<!-- insert Team -->

						<h3>Add a Team:</h3>
						<form method="post" action="modifyDB.php">
							<label>Team Name:</label> <input type="text" name="teamName"><br/>
							<label>Team Type:</label>
							<select name="sportName">
								<option>Soccer</option>
								<option>BasketBall</option>
								<option>Futsal</option>
							</select><br/>
							<label>Club Name:</label>
							<select name="selectedClub">
								<?php
									$rows=$db->query($queryListOfClubs);
									foreach ($rows as $row) {
										?>
										<option><?= $row["clubName"] ?></option>
										<?php
									}
								 ?>
							</select><br/>
							<input type="submit" name="insertTeam"><br/>
						</form>
						<hr/>

						<h3>Add a Club:</h3>
						<!-- Insert Club  -->
						<form method="post" action="modifyDB.php">
							<label>President Name:</label> <input type="text" name="presidentName"><br/>
							<label>Club Name:</label> <input type="text" name="clubName"><br/>
							<label>Date Of Creation:</label> <input type="date" name="foundationDate"><br/>
							<label>Club Location:</label> <input type="text" name="location"><br/>
							<input type="submit" name="insertClub"><br/>
						</form>

						<!-- Reach Here  -->
						<hr/>

						<h3>Add a Tournament:</h3>

						<!-- inserting Tournament -->
						<form method="post" action="modifyDB.php">
							<label>Tournament Name:</label> <input type="text" name="tournamentName"><br/>
							<label>Tournament Type:</label>
							<select name="tournamentType">
								<option>Soccer</option>
								<option>BasketBall</option>
								<option>Futsal</option>
							</select><br/>
							<label>Tournament Prize:</label> <input type="number" name="prize"> $<br/>
							<label>Starting Date:</label> <input type="date" name="startingDate"> <br/>
							<label>Ending Date :</label> <input type="date" name="endingDate"> <br/>
							<label>Number of Rounds:</label> <input type="number" name="numberOfRounds"><br/>
							<input type="submit" name="insertTournament"><br/>

					</form>
						<hr/>

						<h3>Add a player:</h3>

						<!-- Inserting A player -->
						<form method="post" action="modifyDB.php">

							<label>First Name:</label> <input type="text" name="firstName"><br/>
							<label>Last name:</label> <input type="text" name="lastName"><br/>
							<label>Age:</label> <input type="text" name="age"><br/>
							<label>Plays In:</label>
							<select name="teamName">
								<?php
									$rows=$db->query($queryListOfTeams);
									foreach ($rows as $row) {
										?>
										<option><?= $row["teamName"]; ?></option>
										<?php
									}
								 ?>
							</select>'s Team<br/>
							<label>Team Role:</label>
							<select name="teamRole">
								<option>Captain</option>
								<option>Vice Captain</option>
								<option>Thrid Captain</option>
								<option>Fourth Captain</option>
								<option>Starting Captain</option>
							</select><br/>
							<label>Team Position:</label>
							<select name="teamPosition">
								<option>DF</option>
								<option>MF</option>
								<option>SF</option>
								<option>WF</option>
								<option>GK</option>
							</select><br/>
							<input type="submit" name="insertPlayer"><br/>
					</form>
						<hr/>

						<h3>Add a staff:</h3>

						<!-- inserting staff -->
						<form method="post" action="modifyDB.php">
							<label>First Name:</label> <input type="text" name="firstName"><br/>
							<label>Last name:</label> <input type="text" name="lastName"><br/>
							<label>Age:</label> <input type="text" name="age"><br/>
							<label>Works In:</label>
							<select name="teamName">
								<?php
									$rows=$db->query($queryListOfTeams);
									foreach ($rows as $row) {
										?>
										<option><?= $row["teamName"]; ?></option>
										<?php
									}
								 ?>
							</select>'s Team<br/>
							<label>Staff Role:</label>
							<select name="role">
								<option>Prisedent</option>
								<option>Vice Prisedent</option>
								<option>Coach</option>
								<option>Manager</option>
								<option>Assistant Manager</option>
								<option>Fitness</option>
							</select><br/>
						<input type="submit" name="insertStaff" class="button1"><br/>
				</form>
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
