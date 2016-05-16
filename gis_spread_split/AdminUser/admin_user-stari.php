<?php require("../korisnik.php"); ?>
<? include("../header.php"); ?>
<script>
 
 function reload_table(){
  
 $.post( "load_users_table.php","" ,function( res ) {
  $( "#users_table" ).html( res );
  
 
});
 
 }
 
  $(document).ready(function(){
	reload_table();
	});
function spremi(id){
 $( "#result" ).html( "" );
var uname= $("#uname"+id).val();
 name= $("#name"+id).val();
lastname= $("#lastname"+id).val();
password= $("#password"+id).val();
user_level= $("#user_level"+id).val();
 var data= { "id_user":id, "uname": uname,"name": name, "lastname": lastname, "password": password,"user_level": user_level };
$.post( "spremi_user.php", data,function( res ) {
  $( "#result" ).html( res );
   reload_table();
} );
}


function izbrisi(id){
 $( "#result" ).html( "" );
 
 data={"id_user":id};
 $.post( "delete_user.php", data,function( res ) {
  $( "#result" ).html( res );
  
  reload_table();
});
}


function dodaj_user(){
 $( "#result" ).html( "" );
 id="_new";
var uname= $("#uname"+id).val();
 name= $("#name"+id).val();
lastname= $("#lastname"+id).val();
password= $("#password"+id).val();
user_level= $("#user_level"+id).val();
 var data= { "id_user":id, "uname": uname,"name": name, "lastname": lastname, "password": password,"user_level": user_level };
 $.post( "dodaj_user.php", data,function( res ) {
  $( "#result" ).html( res );
    reload_table();
} );


}

function spremi_radnomjesto(id){
 $( "#result" ).html( "" );
 
var id_radnomjesto= $("#radno_mjesto"+id).val();
 name= $("#name"+id).val();
lastname= $("#lastname"+id).val();
password= $("#password"+id).val();
user_level= $("#user_level"+id).val();
 var data= { "id_user":id, "id_radnomjesto": id_radnomjesto  };
 $.post( "spremi_radnomjesto_user.php", data,function( res ) {
  $( "#result" ).html( res );
    reload_table();
} );


}
</script>
<link rel="stylesheet" href="../css/admin-gui.css" type="text/css">

<center><img src="../graphics/logo-naslov.png">
<div style="margin:50px">
<div id="result"></div>
<div id="users_table"></div>
</div>


<?  include("../zatvori.php");  ?><br />
<div style="background-color:#84c1a2;">
<?  include("../copyright.php");  ?>
</div>
</center>



