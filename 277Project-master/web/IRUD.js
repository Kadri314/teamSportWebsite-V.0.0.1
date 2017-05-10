// IRUD: stands for Insert,Retrieve,Update, and Delete
 window.onload=start;

function start(){
  // adding action listener into insert button
    //alert("hello world");

}

function rmTeam(){
  var teamName= document.getElementById("selectedTeamToRemove").value;
  var ajax= new XMLHttpRequest();
  ajax.open("get","modifyDB.php?deleteTeam=true&teamName="+teamName,true);
  ajax.send(null);
  ajax.onload=function(){
    alert(this.responseText);
  };
  ajax.onerror=displayError;
}
function rmPlayer(){
  var playerName= document.getElementById("selectedPlayerToRemove").value;
  var ajax= new XMLHttpRequest();
  ajax.open("get","modifyDB.php?deletePlayer=true&playerName="+playerName,true);
  ajax.send(null);
  ajax.onload=function(){
    alert(this.responseText);
  };
  ajax.onerror=displayError;
}
function rmStaff(){
  var staffName= document.getElementById("selectedStaffToRemove").value;
  var ajax= new XMLHttpRequest();
  ajax.open("get","modifyDB.php?deleteStaff=true&staffName="+staffName,true);
  ajax.send(null);
  ajax.onload=function(){
    alert(this.responseText);
  };
  ajax.onerror=displayError;
}

function rmSponsor(){
  var sponsorName= document.getElementById("selectedSponsorToRemove").value;
  var ajax= new XMLHttpRequest();
  ajax.open("get","modifyDB.php?deleteSponsor=true&sponsorName="+sponsorName,true);
  ajax.send(null);
  ajax.onload=function(){
    alert(this.responseText);
  };
  ajax.onerror=displayError;
}
function rmTournament(){
  var tournamentName= document.getElementById("selectedTournamentToRemove").value;
  var ajax= new XMLHttpRequest();
  ajax.open("get","modifyDB.php?deleteTournament=true&tournamentName="+tournamentName,true);
  ajax.send(null);
  ajax.onload=function(){
    alert(this.responseText);
  };
  ajax.onerror=displayError;
}
function displayError()  {
  alert("Something Went Wrong! Please try Again Later");

}
