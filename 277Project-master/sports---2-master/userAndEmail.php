<?php
// 1-this file receives three parameters userName , companyName, and email
// 2- then we check if the userName and companyName exist in the database
// 3- after that we return a boolean true or false as JSON formate
   if(!isset($_REQUEST["userName"]) || !isset($_REQUEST["email"])){
      header("HTTP/1.1 403 Forbidden");
      die("Missing Parameters try again later please!");
   }
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
      $email=$db->quote($_REQUEST["email"]);
      $query1="select userName from webusers where userName=$userName";
      $query2="select email from webusers where email=$email";
      $result1=$db->query($query1);
      $result2=$db->query($query2);
      if($result1->rowCount()==0)$isUserExist="false";// means no reuslt found on database for the passed userName if equal to 0
      else  $isUserExist="true";
      if($result2->rowCount()==0) $isEmailExist="false";// means no reuslt found on database for the passed email if equal to 0
      else $isEmailExist="true";
      // printing json format
      echo "{\"userName\":\"$isUserExist\",\"email\":\"$isEmailExist\"}";

?>
