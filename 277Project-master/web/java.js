
function validateLogin(event){
   checkLoginInfo(event);

}
function validateSignup(event){
      checkSignupInfo(event);

}
function checkSignupInfo(event){
   //CheckUserAndCompany(event);
   var isUserNameCorrect=isValid(/^\w{4,30}$/,document.getElementById("userName").value);
   var isPasswordCorrect=isValid(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/g,document.getElementById("password").value);
   var isRePasswordCorrect=document.getElementById("password").value==document.getElementById("rePassword").value;
   var emailCorrect=isValid(/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/,document.getElementById("email").value);
   // email validation is taken from http://stackoverflow.com/questions/46155/validate-email-address-in-javascript

   if( isUserNameCorrect && isPasswordCorrect  && isRePasswordCorrect && emailCorrect ){
      // check database whether userName and companyName exist, if so we alert cleint to change them
      // we will solve this problem by establish connection to server using ajax
      CheckUserAndEmail(event);// this method will will send a request to userAndEmail.php with userName,companyName and email as parameter using AJAX and then it will check whether userName or companyName exist in database
  }else{ // at least one of the inputs are worng
      event.preventDefault();

      if(!isUserNameCorrect){
         postError("userName","userNameSpan","userName must be at least 4 characters long");
      }else{
         removeError("userName","userNameSpan");
      }
      if(!isPasswordCorrect){
         postError("password","passwordSpan","password: Minimum 6 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet and 1 Number");
      }else{
         removeError("password","passwordSpan");
      }
      if(!isRePasswordCorrect){
         postError("rePassword","rePasswordSpan","password does not match");
      }else{
         removeError("rePassword","rePasswordSpan");
      }
      if(!emailCorrect){
         postError("email","emailSpan","wrong email address");
      }else{
         removeError("email","emailSpan");
      }
   }
}
function CheckUserAndEmail(event){
   event.preventDefault();
   var ajax= new XMLHttpRequest();
   var userName=document.getElementById("userName").value;
   var email=document.getElementById("email").value;
   ajax.open("get","userAndEmail.php?userName="+userName+"&email="+email,true);
   ajax.send(null);
   ajax.onload=function(){
      var data=JSON.parse(ajax.responseText);
      var isUserNameExist=data.userName=="true";
      var isEmailExist=data.email=="true";
      if( isUserNameExist ||  isEmailExist){
         if(isUserNameExist){
            postError("userName","userNameSpan","That userName already exist please chose another one");
         }else{
            removeError("userName","userNameSpan");
         }
         if(isEmailExist){
            postError("email","emailSpan","That email is already used chose another one ");
         }else{
            removeError("email","emailSpan");
         }
      }else {
         // data are correct and username companyName and email are unique so we can submit the data to the server
         document.getElementById("form1").submit();
      }
   }
   ajax.onerror=displayRequestError;
}
function preventDefault(event){
   alert(event.target);
   event.preventDefault();}

function checkLoginInfo(event){
   event.preventDefault();
   alert("Hello world");
   var isUserNameCorrect= true;//isValid(/^\w{4,}$/,document.getElementById("luserName").value);
   var isPasswordCorrect=  true;//isValid(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/g,document.getElementById("lpassword").value);
      if(isUserNameCorrect && isPasswordCorrect ){
            // the login information have valid formate but we do need to make sure the username and password exist in
            // our database so we create ajax object and send the data through it to server and then the server repose by
            // JSON object has the following formate { "isUserExist=boolean"}
            var ajax= new XMLHttpRequest();
             ajax.open("post","logUser.php",true);
             ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             var userName=document.getElementById("luserName").value;
             var password=document.getElementById("lpassword").value;
             var isAdmin=document.getElementById("admin").checked;
             ajax.send("userName="+userName+"&password="+password+"&isAdmin="+isAdmin);
             ajax.onload=function(){
                var data= JSON.parse(ajax.responseText);
                if(!data.isUserExist){
                   // the reponse from the server says that the userName or password does not have any match in the dataBase
                   event.preventDefault();
                   var p=document.getElementById("userNameOrPassword");
                   p.innerHTML="The userName or the password is incorrect!";
                   p.style.color="red";
                }else{
                     //at this stage the userName and password submitted by the user are correct and the user will be redirected into
                     window.location.href="regularUser.php";
                }

             };
             ajax.onerror=displayRequestError;

      }else{
         displayLoginError(isUserNameCorrect,isPasswordCorrect);
      }
}

function displayRequestError(){
   alert("Request fail to reach the server try again later");
}
function displayLoginError(isUserNameCorrect,isPasswordCorrect){
   if(!isUserNameCorrect){
      postError("luserName","luserNameSpan","The userName is incorrect!");
   }else{
         removeError("luserName","luserNameSpan");
   }
   if(!isPasswordCorrect){
      postError("lpassword","lpasswordSpan","The password is incorrect!");
   }else{
      removeError("lpassword","lpasswordSpan");
   }
}
function isValid(expression, input){
   if(input.match(expression)){
      return true;
   }else{
      return false;
   }
}
function postError(inputId,spanId,text){
      var span= document.getElementById(spanId);
      var parent= document.getElementById(inputId);
      parent.style.borderColor="red";
      span.style.color="red";
      span.innerHTML=text;
}
function removeError(inputId,spanId){
         var parent=document.getElementById(inputId);
         parent.style.borderColor="initial";
         var span= document.getElementById(spanId);
         span.innerHTML="";
}
