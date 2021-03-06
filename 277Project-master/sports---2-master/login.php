<?php
include("checkSession.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="js/java.js"></script>

    <title>Sports Teams</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

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
                        <strong>Log In</strong>
                    </h2>
                    <hr>
                </div>
                <div style="text-align: center;">
                    <form method="post" action="To Be Determined in JS" onsubmit="validateLogin(event)">


            <input type="radio" name="privilage" id="admin" value="admin">Admin</input>
            <input type="radio" name="privilage" id="user" value="user" checked >User<br/>
            <span class="intro-text text-center">UserName : </span>
            <input type="text" name="luserName" id="luserName"><p  id="luserNameSpan"></p ><br/>
            <span class="intro-text text-center" >Password : </span>
            <input type="password" name="lpassword" id="lpassword"><p  id="lpasswordSpan"></p ><br/><p id="userNameOrPassword"></p>
            <input align="center" class="btn btn-default btn-lg" type="submit" name="submitLogin" value="Login"><br/>

                    </form>
                </div>



                <div class="clearfix"></div>

            </div>
        </div>

    </div>

    <div class="container">


        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">
                        <strong>Sign Up</strong>
                    </h2>
                    <hr>
                </div>
                <div style="text-align: center;">
                  <form method="post" action="signup.php" onsubmit="validateSignup(event)" id="form1">
                      <span class="intro-text text-center">UserName :</span>
                      <input type="text" name="userName" id ="userName"><p  id="userNameSpan"></p ><br/>
                      <span class="intro-text text-center">Password :</span>
                      <input type="password" name="password" id ="password"><p  id="passwordSpan"></p ><br/>
                      <span class="intro-text text-center">Re-Password :</span>
                      <input type="password" name="re-password" id ="rePassword"><p  id="rePasswordSpan"></p ><br/>
                      <span class="intro-text text-center">Email :</span>
                      <input type="text" name="email" id ="email"><p  id="emailSpan"></p ><br/>
                      <input type="submit" class="btn btn-default btn-lg"name="submitSignup" value="Signup">
                  </form>
                </div>



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
