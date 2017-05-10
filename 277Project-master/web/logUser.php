<?php
   // this file receives username and password as parameters then it checks if they  exist in the database
   // it starts a session, else if they don't exist in the database it return boolean as json fomrate
   if(!isset($_REQUEST["userName"]) || !isset($_REQUEST["password"])){
      header("");
      die("");
   }else{
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
      $userName=$db->quote($_REQUEST["userName"]);
      $password=$db->quote($_REQUEST["password"]);
      $isAdmin=$_REQUEST["isAdmin"];

      $result=$db->query("select count(userName) from webusers where userName=$userName && password=$password && isAdmin=$isAdmin");
      if($result->fetchColumn()==1){
         // logIn information are correct we set session and return JSON have the following format { "isUserExist=true"}
            // creating session after the user is loged in
            session_start();
            $_SESSION['userName']=$_REQUEST["userName"];
            $_SESSION["isAdmin"]=$_REQUEST["isAdmin"];
            $_SESSION['lastLogIn']=time();
            echo "{ \"isUserExist\":true}";
      }else{
         // logIn information are incorrect we return the following JSON { "isUserExist=false"}
         echo "{ \"isUserExist\":false}";

      }

   }

?>
