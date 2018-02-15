<?php
include_once("db_functions.php");

if(isset($_REQUEST['submit']))
{
		session_start();
		$_SESSION['user_name']="";

		
		$db=new db_func();
		$db->connect();
		
		$query = "SELECT password FROM users WHERE username = '".$_POST["usrname"]."'";
		$result = $db->query($query);

		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			foreach ($line as $col_value) {
				if(hash_hmac('ripemd160',$_POST["pass"],"AdriaProp") == $col_value)
				{
					$_SESSION['user_name'] = $_POST['usrname'];
				}
			}
		}

		// Free resultset
		pg_free_result($result);

		// Closing connection
		$db->disconnect();
		


		if ($_SESSION['user_name']!="")
		{	
			 header("Location: gis.php");
			 exit(1);
		}


		else
		{
				// U slucaju neispravnog korisničkog imena i lozinke
				print "<SCRIPT>alert('<?php echo _NATPIS_WRONG_LOGIN?>'); document.location.href='login.php';</SCRIPT>\n";
		}

} 
else 
{
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<?php include("postavke_dir_gis.php"); ?>
<?php include("header.php"); ?>

<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<SCRIPT language=JavaScript >
var submitBrojac = 0;
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
function preSubmit() {
  if (submitBrojac==0) {
    submitBrojac=1;
    //pokaži Loading
    winW = document.body.offsetWidth;
    winH = document.body.offsetHeight;
    var ly = document.getElementById("lyLoading");
    newX = winW/2-100;
    newY = winH/2-35;
    ly.style.left=newX;
    ly.style.top=newY;
    ly.style.visibility='visible';
    //disable na sve tipke i unosne objekte u formi
    var mainForm=document.forms(0);
    for (var i = 0; i < mainForm.elements.length; i++) {
      elem = mainForm.elements[i];
      if (elem.type=="submit" ||
        elem.type=="text" ||
        elem.type=="select" ||
        elem.type=="option" ||
        elem.type=="textarea") {
        elem.style.color="gray";
      };
    };
    return true;
  } else {return false}; //ako je submit već napravljen
}
</SCRIPT>
<LINK REL="stylesheet" HREF="css/style.css" TYPE="text/css">
</HEAD>

<BODY onload="document.forms[0].usrname.focus()">
<DIV ID="lyLoading" STYLE="position:absolute; width:180px; height:70px; z-index:99; background-color : White; border:medium solid Black; visibility: hidden">
<TABLE BORDER=0 CELLPADDING="5">
  <TR>
    <TD ALIGN="center" VALIGN="middle" STYLE="font-size=12px; color:Red"><STRONG><?php echo _NATPIS_PRICEKAJTE?></STRONG></TD>
  </TR><TR>
    <TD ALIGN="center" VALIGN="middle"><img src="gif/inProgress.gif"></TD>
</TR>
</TABLE>
</DIV>
<FORM NAME="form" ACTION="login.php" METHOD="POST" 
 onSubmit="__submitting__ = 1; document.forms[0].__pushed__.value = 0; return preSubmit();">
<TABLE WIDTH="100%" HEIGHT="90%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
  <TR>
    <TD>
      <!-- tablica sa logotipima -->
      <TABLE WIDTH="100%" BORDER="0" CELLPADDING="3" CELLSPACING="0">
        <TR>
            <TD align="center"><img src="./css/images/AdriaFirePropagator.png" width="632" height="146"></TD>
          </TR>
      </TABLE>
      <!-- END tablica sa logotipima -->
    </TD>
  </TR>
  <TR>
    <TD HEIGHT="18" BGCOLOR="Gray">
      <!-- info traka -->
     <TABLE WIDTH="100%" HEIGHT="18" BORDER="0" CELLPADDING="0" CELLSPACING="0">
        <TR>
          <TD WIDTH="5" HEIGHT="18" BGCOLOR="Gray"><IMG SRC="gif/spacer.gif" WIDTH="5" HEIGHT="18"></TD>
          <TD VALIGN="middle" align="right"><span CLASS="copyright"></span></TD>
          <TD WIDTH="5" HEIGHT="18" BGCOLOR="Gray"><IMG SRC="gif/spacer.gif" WIDTH="5" HEIGHT="18"></TD>
		</TR>
      </TABLE>
      <!-- END info traka -->
    </TD>
  </TR>
  <TR height="100%">
    <TD VALIGN="TOP" ALIGN="center" >
      <TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="4" ALIGN="center">
	 	  <TR>
          <TD COLSPAN="2" HEIGHT="10" BACKGROUND="gif/spacer.gif"></TD>
        </TR>
<TR>
          <TD COLSPAN="2" HEIGHT="1" BACKGROUND="gif/tockica.gif"></TD>
        </TR>
          <TR> 
            <TD COLSPAN="2" ALIGN="center"><h3><?php echo _NATPIS_REGISTRIRANI_KORISNICI?></h3></TD>
        </TR>
        <TR>
            <TD WIDTH="50%" VALIGN="middle" ALIGN="right"><B><?php echo _NATPIS_IDENTIFIKACIJA?></B></TD>
          <TD WIDTH="50%" VALIGN="middle"><INPUT TYPE=text NAME=usrname VALUE="" SIZE=10 CLASS="inputNormal" onfocus="this.className='inputFocus';" onblur="this.className='inputNormal';" AUTOCOMPLETE="OFF" MAXLENGTH=25></TD>
        </TR>
        <TR>
            <TD WIDTH="50%" VALIGN="middle" ALIGN="right"><B><?php echo _NATPIS_ZAPORKA?></B></TD>
          <TD WIDTH="50%" VALIGN="middle"><INPUT TYPE=password NAME=pass VALUE="" SIZE=10 CLASS="inputNormal" onfocus="this.className='inputFocus';" onblur="this.className='inputNormal';" AUTOCOMPLETE="OFF" MAXLENGTH=25></TD>
        </TR>
        <TR>
          <TD COLSPAN="2" VALIGN="middle" ALIGN="center"><INPUT TYPE=submit SIZE=7 title="<?php echo _NATPIS_POTVRDA_TITLE?>" class="inputMenu" onMouseOver="this.className = 'inputMenuOver';" onMouseOut="this.className = 'inputMenu';" NAME=submit VALUE="<?php echo _NATPIS_POTVRDA?>"></TD>
        </TR>
        <TR>
          <TD COLSPAN="2" HEIGHT="10" BACKGROUND="gif/spacer.gif"></TD>
        </TR>
        <TR>
          <TD COLSPAN="2" HEIGHT="1" BACKGROUND="gif/tockica.gif"></TD>
        </TR>
        <TR>
          <TD COLSPAN="2">
			<div align="center" id="slikeLogo">
			<img src="./css/images/EU.jpg"/>
				<img src="./css/images/IPA Adriatic.jpg"/>
				<img src="./css/images/HOLISTIC-2.jpg"/>
				<img src="./css/images/zupanija.jpg"/>
				<img src="./css/images/fesb.jpg"/>
				<img src="./css/images/sveuciliste.jpg"/>
			</div>
		  </TD>
        </TR>	
          <TR> 
            <TD COLSPAN="2"><div align="center"><?php echo _NATPIS_UPOZORENJE?></div></TD>
        </TR>
		<TR> 
            <TD COLSPAN="2"><div  align="center" ><?php echo _NATPIS_DISCLAIMER?></div></TD>
        </TR>
        <TR>
		<TD COLSPAN="2" ALIGN="center"><IMG SRC="gif/spacer.gif" WIDTH="10" HEIGHT="5"></TD>
		</TR>
      </TABLE>
	  <a href="http://propagator.adriaholistic.eu/AdriaFireRisk/">AdriaFireRisk</a>
    </TD>
  </TR>
<INPUT 
type=hidden name=__pushed__>
<SCRIPT language=JavaScript>
function winStLn() { self.defaultStatus = ''; }
winStLn();
</SCRIPT>
</FORM>
</BODY>
</HTML>
<?php
}
?>