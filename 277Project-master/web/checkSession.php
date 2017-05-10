<?php
   // this file check if session is time out
   // since we will check session on different number of pages. it's better to include the code of checking session time out in external file
   session_start();
   if(isset($_SESSION["lastLogIn"])){
      $lastLogIn=$_SESSION["lastLogIn"];
      if(time()-$lastLogIn>=60*60){
        // user has been browsing the page more than 20 minutes so we redirect him to login.html page to log in again
        session_destroy();
        session_regenerate_id(true);
        header("location: index.php");
     }else $_SESSION["lastLogIn"]=time();
  }

?>
