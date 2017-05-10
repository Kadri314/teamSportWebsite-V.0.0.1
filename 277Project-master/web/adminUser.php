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
$queryListOfPlayers= "select fullName  from playerInfo where 1";
$queryListOfStaff= "select firstName, lastName  from members, staff where staff.id=members.id";
$queryListOfTorunamnets= "select tournamentName  from tournament where 1";
$queryListOfClubs= "select clubName  from club where 1";
$queryListOfSponsors="select sponsorName from sponsor where 1";
?>
<!doctype html>
<html>
<head>
	<script src="IRUD.js"></script>
</head>
<body>
	<h1>Welcome To Admin Page. <?=$userName ?></h1>
	<a href="regularUser.php">View dataBaseInfo</a>
	<!-- <form method="post" action="result.php"> -->
		<h2>Delete Section:</h2>
		<!-- FOR teams  -->
				<h3>Remove A Team</h3>
				<span>List Of Teams:</span>
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
				<span>Delete Selected Team  : </span>
				<button onclick="rmTeam()" />Remove Selected Team</button><br/>
				<hr/>
			<!-- delete Player -->
					<h3>Remove A Player</h3>
					<span>List Of Players:</span>
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
					<span>Delete Selected Player: </span>
					<button onclick="rmPlayer()" />Remove Selected player</button><br/>
					<hr/>
					<!-- delete a staff -->
					<h3>Remove A Staff</h3>
					<span>List Of Staff:</span>
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
					<span>Delete Selected Staff: </span>
					<button onclick="rmStaff()" />Remove Selected Staff</button><br/>
					<hr/>
					<!-- delete sponsors -->
					<h3>Remove A Sponsor</h3>
					<span>List Of Sponsors:</span>
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
					<span>Delete Selected sponsor  : </span>
					<button onclick="rmSponsor()" />Remove Selected Sponsor</button><br/>
					<hr/>
			<!-- delete torunamnet -->
			<h3>Remove A Tournament</h3>
			<span>List Of Tournaments:</span>
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
			<span>Delete Selected Torunamnet  : </span>
			<button onclick="rmTournament()" />Remove Selected Tournament</button><br/>
			<hr/>
		<!-- update  -->
		<h2>Update Section:</h2>
			record
			player
			staff
			<hr/>
		<!-- insert -->
		<h2>Insert Section:</h2>

		<!-- insert Team -->

			<h3>Insert a Team:</h3>
			<form method="post" action="modifyDB.php">
				<span>Team Name:</span> <input type="text" name="teamName"><br/>
				<span>Team Type:</span>
				<select name="sportName">
					<option>Soccer</option>
					<option>BasketBall</option>
					<option>Futsal</option>
				</select>
				<span>Club Name:</span>
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

			<h3>Insert a Club:</h3>
			<!-- Insert Club  -->
			<form method="post" action="modifyDB.php">
				<span>President Name:</span> <input type="text" name="presidentName"><br/>
				<span>Club Name:</span> <input type="text" name="clubName"><br/>
				<span>Date Of Creation:</span> <input type="date" name="foundationDate"><br/>
				<span>Club Location:</span> <input type="text" name="location"><br/>
				<input type="submit" name="insertClub"><br/>
			</form>

			<!-- Reach Here  -->
			<hr/>

			<h3>Insert a Tournament:</h3>

			<!-- inserting Tournament -->
			<form method="post" action="modifyDB.php">
				<span>Tournament Name:</span> <input type="text" name="tournamentName"><br/>
				<span>Tournament Type:</span>
				<select name="tournamentType">
					<option>Soccer</option>
					<option>BasketBall</option>
					<option>Futsal</option>
				</select><br/>
				<span>Tournament Prize:</span> <input type="number" name="prize"> $<br/>
				<span>Starting Date:</span> <input type="date" name="startingDate"> <br/>
				<span>Ending Date :</span> <input type="date" name="endingDate"> <br/>
				<span>Number of Rounds:</span> <input type="number" name="numberOfRounds"><br/>
				<input type="submit" name="insertTournament"><br/>

		</form>
			<hr/>

			<h3>Insert a player:</h3>

			<!-- Inserting A player -->
			<form method="post" action="modifyDB.php">

				<span>First Name:</span> <input type="text" name="firstName"><br/>
				<span>Last name:</span> <input type="text" name="lastName"><br/>
				<span>Age:</span> <input type="text" name="age"><br/>
				<span>Plays In:</span>
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
				<span>Team Role:</span>
				<select name="teamRole">
					<option>Captain</option>
					<option>Vice Captain</option>
					<option>Thrid Captain</option>
					<option>Fourth Captain</option>
					<option>Starting Captain</option>
				</select><br/>
				<span>Team Position:</span>
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

			<h3>Insert a staff:</h3>

			<!-- inserting staff -->
			<form method="post" action="modifyDB.php">
				<span>First Name:</span> <input type="text" name="firstName"><br/>
				<span>Last name:</span> <input type="text" name="lastName"><br/>
				<span>Age:</span> <input type="text" name="age"><br/>
				<span>Works In:</span>
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
				<span>Staff Role:</span>
				<select name="role">
					<option>Prisedent</option>
					<option>Vice Prisedent</option>
					<option>Coach</option>
					<option>Manager</option>
					<option>Assistant Manager</option>
					<option>Fitness</option>
				</select><br/>
			<input type="submit" name="insertStaff"><br/>
	</form>
	<!-- </form> -->
</body>
</html>
