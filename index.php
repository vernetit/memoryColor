<?
//Programmer by rRoberto Chalean
//robertchalean@gmail.com
//Program idea and color list Florian Dellé


//header("Content-Type: text/plain");
session_start();

$localIP = getHostByName(getHostName());
//echo $localIP . "<br>";

$bLocal = 0;

$dist="";
if ($localIP == "localhost:13080"){
  
  $bLocal = 1;
 
  
}else{
  
  $dist="-dist";
}
?>

<?php

/*
$handle = fopen("c2.csv", "r");

if ($handle) {
    $i = 0;
    while (($line = fgets($handle)) !== false) {

     $line = str_replace(",,", ",", $line);
     $aLine = explode(",", $line);
     $nombre = trim($aLine[0]);
     $hex = trim($aLine[2]);
     $rgb = trim($aLine[3]."&#44;".$aLine[4]."&#44;".$aLine[5]);
     $letras = trim($aLine[6]);

     echo "<center><div style=\"background-color: $hex; width: 100px; height: 100px;\">&nbsp;</div></center>,$nombre<br>$hex<br>rgb($rgb)<br>$letras\n"; 

     //echo $line . "<br>"; 
        // process the line read.

     $i++;

    }

    fclose($handle);
} else {
    // error opening the file.
} 

*/

/*

$handle = fopen("c2.csv", "r");

echo "var colores = [];"."<br>";

if ($handle) {
    $i = 0;
    while (($line = fgets($handle)) !== false) {

     $line = str_replace(",,", ",", $line);
     $aLine = explode(",", $line);
     $nombre = trim($aLine[0]);
     $hex = trim($aLine[2]);
     $rgb = trim($aLine[3].",".$aLine[4].",".$aLine[5]);
     $letras = trim($aLine[6]);

     echo "colores[$i] = [];"."<br><br>";

     echo "colores[$i][0] = '$nombre';"."<br>";  
     echo "colores[$i][1] = '$hex';"."<br>";  
     echo "colores[$i][2] = '$rgb';"."<br>";  
     echo "colores[$i][3] = 1;"."<br>";  
     echo "colores[$i][5] = 1;"."<br>";  
     echo "colores[$i][6] = '$letras';"."<br><br>";  

     //echo $line . "<br>"; 
        // process the line read.

     $i++;

    }

    fclose($handle);
} else {
    // error opening the file.
} 

die;*/
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Memory Color - Competición mental</title>

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>

   <script src="js/jquery.cookie.js" type="text/javascript"></script> 
  <script src="js/underscore-min.js"></script>
  <script src="js/colores.js"></script>

 <link rel="shortcut icon" href="./favicon.ico">

  <meta name="description" content="Competición mental: memorizar colores">
  <meta name="keywords" content="entrenamiento mental, velocidad mental, memorizar colores">

  <style type="text/css">

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
       
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
   
    </style>
    <? if(!$bLocal){ ?>

      <script>
        

        //put analytics

      </script>
    <? } ?>
</head>
<body>
<? if(!$bLocal){ ?> 

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<? } ?>

  <h3>Color Memory!</h3>
  &nbsp;
  <select id="level" style="width: 65px;">
    <option value="1" selected="">5x5</option>
    <option value="2">10x10</option>
  </select> 
  &nbsp;
  <input type="button" value="Start" id="jugar">
  &nbsp;
  <input type="button" value="Add or remove Colors" id="config">
  &nbsp;
  <input type="button" value="Rapid Memory" id="Mr" onclick="location.href='http://competicionmental.appspot.com/';"> 
  &nbsp;
  <input type="button" value="Memory Direction" id="Mr" onclick="location.href='http://competicionmental.appspot.com/memoryDirection';">
  &nbsp;&nbsp;<a href="#" onclick="alert(window.helpText);"><img src="img/help.png"></a>
  <? if(!$bLocal){ ?> 
  &nbsp;&nbsp;<div class="fb-share-button" data-href="http://competicionmental.appspot.com/colors" data-layout="button_count"></div>
  <? } ?>

  <br><br>
  <div id="screen"></div>


<script type="text/javascript">
window.helpText = "Memory Colors\nConfig to activate/desactivate colors\nThanks Florian Dellé for the list of Colors and the idea.(https://goo.gl/kicaCF)\nContact: robertchalean@gmail.com";

selectedItems = [];
selectedItemsRnd = [];
var lista = [];
var aRecall = [];
var respuestas = [];

$(document).ready(iniciarPrograma());
$("#config").click(mostrarConfig);
$("#jugar").click(jugar);


function iniciarPrograma(){
  

  myCookie = $.cookie('initMC');

  if (!(typeof myCookie !== "undefined" && myCookie !== null)) {

    save = "";

    for(i=0;i<colores.length;i++){
      save += colores[i][3] + ",";
      colores[i][5] = colores[i][3];

    }
    save = save.slice(0, -1);
    $.cookie('initMC', save, { expires: 300 });

    myCookie = $.cookie('initMC');


  }else{

    aVal = myCookie.split(",");

    for(i=0;i<colores.length;i++){
      colores[i][5] = parseInt(aVal[i]);

    }
  }
}

//$(selector).click();

vistaConfig = 0;
t_ini = 0, t_fin = 0, t_dif = 0, t_total = 0;

function mostrarConfig(){

  if(vistaConfig){
    $("#screen").html("");
    vistaConfig = 0;
    return;
  }
  vistaConfig = 1;


  poner = "<div style=\"width: 350px;\">" +
          "<div style=\"float: right;\">" +
            "&nbsp;<input type=\"button\" value=\"Inverse\" class=\"inverse\">" +
            "&nbsp;<input type=\"button\" value=\"None\" class=\"none\">" +
            "&nbsp;<input type=\"button\" value=\"All\" class=\"all\">" +
            "&nbsp;<input type=\"button\" value=\"Default\" class=\"setDefault\">" +
            "&nbsp;<input type=\"button\" value=\"Reload\" class=\"reload\">" +
            "&nbsp;<input type=\"button\" value=\"Save\" class=\"save\">" +
            "&nbsp;<input type=\"button\" value=\"Cancel\" class=\"cancel\">" +
          "</div>"+
         "</div>";

  poner += "<br><div style=\"overflow-y: scroll !important; height: 400px !important; width: 360px;\"><table border=\"0\">";


  for(i=0;i<colores.length;i++){
    poner += "<tr>";

    checked = "";
    if(colores[i][5]==1){
      checked = "checked";
    }
    backgroundColor = colores[i][1];
    nombre =  colores[i][0];

    poner += "<td><input type=\"checkbox\" name=\"vehicle\" id=\"ch" + i + "\"" + checked + "></td><td><div style=\"background-color: " + backgroundColor + "; width: 20px; height 20px;\">&nbsp;</div></td><td>" + nombre + "</td>";

     
    poner += "</tr>";
  }

  poner += "</table></div>";

  poner += "<br><div style=\"width: 350px;\">" +
          "<div style=\"float: right;\">" +
            "&nbsp;<input type=\"button\" value=\"Inverse\" class=\"inverse\">" +
            "&nbsp;<input type=\"button\" value=\"None\" class=\"none\">" +
            "&nbsp;<input type=\"button\" value=\"All\" class=\"all\">" +
            "&nbsp;<input type=\"button\" value=\"Default\" class=\"setDefault\">" +
            "&nbsp;<input type=\"button\" value=\"Reload\" class=\"reload\">" +
            "&nbsp;<input type=\"button\" value=\"Save\" class=\"save\">" +
            "&nbsp;<input type=\"button\" value=\"Cancel\" class=\"cancel\">" +
          "</div>"+
         "</div>";

  $("#screen").html(poner);

  $(".cancel").click(cancel);
  $(".save").click(save1);
  $(".setDefault").click(setDefault);
  $(".all").click(all);
  $(".inverse").click(inverse);
  $(".reload").click(reload);  
  $(".none").click(none);  
}

function ts(ms){
   min = (ms/1000/60) << 0;
   sec = (ms/1000) % 60;

   return(min + ':' + sec);
}

function reload(){
  myCookie = $.cookie('initMC');
  //alert(myCookie);

  aVal = myCookie.split(",");

  for(i=0;i<colores.length;i++){
    if(parseInt(aVal[i])){
      $("#ch"+i).prop('checked', true); 
    }else{
       $("#ch"+i).prop('checked', false); 

    }
  }
}

function inverse(){
  for(i=0;i<colores.length;i++){
    if($("#ch"+i).is(':checked')) {  
      $("#ch"+i).prop('checked', false); 
    }else{
      $("#ch"+i).prop('checked', true); 

    }
  }
}

function all(){
  for(i=0;i<colores.length;i++){
    $("#ch"+i).prop('checked', true);
  }
}

function none(){
  for(i=0;i<colores.length;i++){
    $("#ch"+i).prop('checked', false);
  }
}

function setDefault(){
  for(i=0;i<colores.length;i++){
      
    if(colores[i][3]){
      $("#ch"+i).prop('checked', true); 
    }else{
       $("#ch"+i).prop('checked', false); 
    }
  }
}

function save1(){
   save = "";

    for(i=0;i<colores.length;i++){
       if($("#ch"+i).is(':checked')) {  
          save += "1,";
          colores[i][5] = 1;
          
        }else{
           save += "0,";
           colores[i][5] = 0;
        }
    }
    save = save.slice(0, -1);

    $.cookie('initMC', save, { expires: 300 });

    myCookie = $.cookie('initMC');

}

function cancel(){
  $("#screen").html("");
  vistaConfig = 0;
  return;
} 

function jugar(){
  vistaConfig = 0;

  z = 0;
  for(i=0;i<colores.length;i++){

    if(colores[i][5]==1){

      lista[z]=i;
      z++;
    }
  }

  tamano = 0;

  if(parseInt($("#level").val())==1)
    tamano = 5;
  else  
    tamano = 10; 

  poner = "<table border=\"0\">";

  z=0;
  for(i=0;i<tamano;i++){
    poner += "<tr>";

    for(j=0;j<tamano;j++){
      rnd = _.random(0,lista.length-1);
      id = lista[rnd];
      selectedItems[z] = id;


      poner += "<td><div class=\"dropdown\"><a href=\"#\" class=\"dropbtn\" style=\"text-decoration: none;\"><div style=\"background-color: " + colores[id][1] + "; width: 30px; height: 30px;  z-index: 90;\">&nbsp;</div></a><div class=\"dropdown-content\" style=\"z-index: 100;\">" + colores[id][0] + "<br>" + colores[id][1] +  "<br>" + colores[id][2] +  "<br></div></div></td>";

      z++;
    }
    poner += "</tr>";
  }
  poner += "</table>";

  console.log(selectedItems);

  $("#screen").html(poner);
  t_ini = Date.now();
  $("#screen").append("<br><input type=\"button\" value=\"Recall\" id=\"recall\">");


  $("#recall").click(recall1);

}

function recall1(){
  recall = []; t_fin = Date.now();

  selectedItemsRnd = selectedItems.slice();
  selectedItemsRnd = selectedItemsRnd.sort(function() {return Math.random() - 0.5});

  poner2 = "<table border=\"0\">";
  z=0;

  for(i=0;i<tamano;i++){
    recall[z] = "#FFFFFF";  
    poner2 += "<tr>";

    for(j=0;j<tamano;j++){

      idRnd = selectedItemsRnd[z];
      
      poner2 += "<td><div class=\"dropdown\"><a href=\"#\" class=\"dropbtn\" style=\"text-decoration: none;\"><div style=\"background-color: " + colores[idRnd][1] + "; width: 30px; height: 30px;  z-index: 90;\" onclick=\"contestar(zzz,'" + colores[idRnd][1] + "');\" title=\"" + colores[idRnd][0] + "\">&nbsp;</div></a><div class=\"dropdown-content\" style=\"z-index: 100; display:none;\"></div></div></td>";

      z++;
    }
    poner2 += "</tr>";
  }
  poner2 += "</table>";

  poner = "<table border=\"1\" style=\"border: 1px solid gray;  border-collapse: collapse;\">";

  z=0;
  for(i=0;i<tamano;i++){
    poner += "<tr>";

    for(j=0;j<tamano;j++){

      poner3 = poner2;
      poner3 = poner3.replace(/zzz/g,z);
      //console.log(poner3);
      
      poner += "<td><div class=\"dropdown\"><a href=\"#\" class=\"dropbtn\" style=\"text-decoration: none;\"><div style=\"background-color: white; width: 30px; height: 30px;  z-index: 90;\" id=\"respuesta" + z + "\">&nbsp;</div></a><div class=\"dropdown-content\" style=\"z-index: 100;\">" + poner3 +  "</div></div></td>";

      z++;
    }
    poner += "</tr>";
  }
  poner += "</table>";
  
  //$("#screen").html(poner);
  $("#screen").html(poner);
  $("#screen").append("<br><input type=\"button\" value=\"Answer\" id=\"answer\">");

  $("#answer").click(answer);
}

correctas = 0;

function answer(){
  z=0; correctas=0;
  poner = "<table border=\"0\">";

  for(i=0;i<tamano;i++){
   
    poner += "<tr>";

    for(j=0;j<tamano;j++){
      border = "";
      idSelectedItem = selectedItems[z];

      border = " border: 1px solid green;";
      if(colores[idSelectedItem][1]!=recall[z])
        border = " border: 1px solid red;";
      else
        correctas++;

      poner += "<td>" +
              "<div style=\"width 32px; height: 30px !important; " + border + "\">" +
                "<div style=\"background-color: " + colores[idSelectedItem][1] + "; width: 15px; height: 30px;  float: left;\">&nbsp;</div>" + 
                "<div style=\"background-color: " + recall[z] + "; width: 15px; height: 30px; float: left;\">&nbsp;</div>" +
              "</div>" + 
            "</td>";

      z++;
    }
    poner += "</tr>";
  }
  poner += "</table>";

  tt = (parseInt(tamano)*parseInt(tamano));
  porcent = correctas * 100 / tt; 
  
  t_dif = t_fin - t_ini;

  myDate =  new Date();
  month = myDate.getMonth(); fullYear = myDate.getFullYear(); day = myDate.getDay(); date = myDate.getDate(); year = myDate.getYear();
  ponerFecha = (month + 1) + "/" + date + "/" + fullYear + "<br>";

  total_colors = lista.length;
  
  $("#screen").html(poner);
  $("#screen").append("<br><br><div style=\"background-color: #3fad46; color:white; width 500px;\">You got " + correctas + " out of " + tt + " attempted! (" + porcent  + "% accuracy) in " + getDuration(t_dif) + ", total colors: " + total_colors + ", " + ponerFecha +  "</div>");
 // $("#screen").append("<br><input type=\"button\" value=\"Agregar al Ranking\" id=\"addRank\">");
  

}

function contestar(x,y){

  console.log(x + " = " + y);
  $("#respuesta"+x).css("background-color",y);
  recall[x]=y;
}

var getDuration = function(millis){
  var dur = {};
  var units = [
      {label:"millis",    mod:1000},
      {label:"seconds",   mod:60},
      {label:"minutes",   mod:60},
      {label:"hours",     mod:24},
      {label:"days",      mod:31}
  ];
  // calculate the individual unit values...
  units.forEach(function(u){
      millis = (millis - (dur[u.label] = (millis % u.mod))) / u.mod;
  });
  // convert object to a string representation...
  var nonZero = function(u){ return dur[u.label]; };
  dur.toString = function(){
      return units
          .reverse()
          .filter(nonZero)
          .map(function(u){
              return dur[u.label] + " " + (dur[u.label]==1?u.label.slice(0,-1):u.label);
          })
          .join(', ');
  };
  return dur;
};


//( "body" ).append( $newdiv1, [ newdiv2, existingdiv1 ] );
</script> 
</body>
</html>