<!doctype html>
<html>
   <head>
      <script src="java.js"></script>
      <link rel="stylesheet" type="text/css" href="style.css"  />
   </head>
   <body>
      <h1>Welcome To Lebanon University’s athletic teams </h1>
            <form method="post" action="signup.php" onsubmit="validateSignup(event)" id="form1">
         <fieldset>
            <legend>SignUp:</legend>
            <span>UserName:</span><br/>
            <input type="text" name="userName" id ="userName"><p  id="userNameSpan"></p ><br/>
            <span>Password:</span><br/>
            <input type="password" name="password" id ="password"><p  id="passwordSpan"></p ><br/>
            <span>Re-Password:</span><br/>
            <input type="password" name="re-password" id ="rePassword"><p  id="rePasswordSpan"></p ><br/>
            <span>email:</span><br/>
            <input type="text" name="email" id ="email"><p  id="emailSpan"></p ><br/>
        <input type="submit" name="submitSignup" value="Signup">
         </fieldset>
      </form>
      <form method="post" action="To Be Determined in JS" onsubmit="validateLogin(event)">
         <fieldset>
            <legend>Login: </legend>
            <span>LogIn As:</span><br/>
            <input type="radio" name="privilage" id="admin" value="admin">Admin<br/>
            <input type="radio" name="privilage" id="user" value="user" checked >User<br/>
            <span>UserName:</span><br/>
            <input type="text" name="luserName" id="luserName"><p  id="luserNameSpan"></p ><br/>
            <span>Password:</span><br/>
            <input type="password" name="lpassword" id="lpassword"><p  id="lpasswordSpan"></p ><br/><p id="userNameOrPassword"></p>
            <input type="submit" name="submitLogin" value="Login"><br/>
         </fieldset>
      </form>
   </body>
</html>
