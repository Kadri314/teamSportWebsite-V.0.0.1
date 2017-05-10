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
$queryListOfClubs= "select clubName  from club where 1";

// determine if the user is admin or not
// if he is an admin then we redirect him into adminResult.php page so he has the privilege of inserting ,updating, and deleting data after clicking on the get result
// otherwise we store the link to take him into result.php where the user can only view data
$resultLink;
if( $_SESSION["isAdmin"]=="true"){
		// user is an admin
		$resultLink="adminResult.php";

}else{
	// user in not an admin
	$resultLink="result.php";
}
?>
<!doctype html>
<html>
<head>
</head>
<body>
	<h1>Hello <?=$userName ?></h1>
	<form method="post" action=<?=$resultLink?>>
<!-- FOR teams  -->
		<span>List Of Teams:</span>
		<select name="selectedTeam">
			<?php
				$rows=$db->query($queryListOfTeams);
				foreach ($rows as $row) {
					?>
					<option><?= $row["teamName"]; ?></option>
					<?php
				}
			 ?>
		</select><br/>
		<span>View Team's players  : </span>
		<input type="submit" name="getTeamPlayer" /><br/>

		<span>View Team  Record: </span>
		<input type="submit" name="getTeamRecord" /><br/>

		<span>View Team's Match History: </span>
		<input type="submit" name="getTeamMatchesHistory" /><br/>

		<span>View Team's Staff: </span>
		<input type="submit" name="getTeamStaff" /><br/>

		<span>View Tournamnets the team participated in: </span>
		<input type="submit" name="getTeamTournamnet" /><br/>
		<hr/>
<!-- FOR players  -->
			<span>List Of All Players:</span>
			<select name="selectedPlayer">
				<?php
					$rows=$db->query($queryListOfPlayers);
					foreach ($rows as $row) {
						?>
						<option><?= $row["fullName"]; ?></option>
						<?php
					}
				 ?>
			</select><br/>

			<span>view Player Info: </span>
			<input type="submit" name="getPlayerInfo" /><br/>

			<span>View Player's Awards: </span>
			<input type="submit" name="getPlayerAwards"/><br/>

			<span>View Player's Match History (Not Done)</span>
			<input type="submit" name="getPlayerMatchHistory"/><br/>

			<hr/>
<!-- FOR Clubs  -->
			<span>List Of All Clubs:</span>
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
			<span>view Club Info: </span>
			<input type="submit" name="getClubInfo" /><br/>

			<span>View teams belongs to that club: </span>
			<input type="submit" name="getClubTeam" /><br/>


			<span>View Club's court: </span>
			<input type="submit" name="getClubCourt" /><br/>

	</form>
</body>
</html>
