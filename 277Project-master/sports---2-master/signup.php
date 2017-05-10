<?php
   // 1-this file receives signup data from login.html
   // 2-then it stores the data in database
   // 3-after that it signs the user by putting the session
if(isset($_POST["userName"])){
   // 1- making connection to the dataBase
   $conn;
   try{
   $conn= new PDO("mysql:host=localhost;dbname=UniversitySport","root","");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
    // connection is established successfuly to dataBase

$username = $conn->quote($_POST["userName"]);// user name must be unique
$pass = $conn->quote($_POST["password"]);
$isAdmin=false; // for the time being only developers can add admin
$email = $conn->quote($_POST["email"]);

$sql = "insert into webusers
         (email,userName,password,isAdmin)
         VALUES
         ($email,$username,$pass,false)";
$conn->exec($sql);
echo "completed";
?>
<script>
  alert("you are signed in successfuly");
  window.location.href="login.php";
</script>

<?php
}else{
  die("Invalid parameters");
}




 ?>
