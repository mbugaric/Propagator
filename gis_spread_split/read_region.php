<?php
 $char = fgetc($fp);
	if ( $char =='n' )
		{

		 $n="";
	     }
 $char = fgetc($fp);
	 if ($char =='=' )


 $char = fgetc($fp);
	 while  ($char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '.' || $char == '-')
	{

		 $n=$n.$char;
         $char = fgetc($fp);

	}

	/************postavljen n*********************/



	/******************s**************************/
     $char = fgetc($fp);
	if ( $char =='s' )
		{

		 $s="";
	     }
 $char = fgetc($fp);
	 if ('=' == $char )
//echo "$char\n";

 $char = fgetc($fp);
	 while  ($char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '.' ||  $char == '-')
	{

		 $s=$s.$char;
		$char = fgetc($fp);

	}

   /************postavljen s*********************/

   /******************w**************************/
    $char = fgetc($fp);
	if ( $char =='w' )
		{
	 //   echo "$char\n";
		 $w="";
	     }
 $char = fgetc($fp);
	 if ('=' == $char )
// echo "$char\n";

 $char = fgetc($fp);
	 while  ($char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '.' ||  $char == '-')
	{

		 $w=$w.$char;
		$char = fgetc($fp);

		}



  /************postavljen w*********************/

   /******************e**************************/
    $char = fgetc($fp);
	if ( $char =='e' )
		{
	//    echo "$char\n";
		 $e="";
	     }
 $char = fgetc($fp);
	 if ('=' == $char )
// echo "$char\n";

 $char = fgetc($fp);
	 while  ($char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '.' ||  $char == '-')
	{

		 $e=$e.$char;
		$char = fgetc($fp);

		}

/************postavljen e*********************/
   $char = fgetc($fp);
	if ( $char =='w' )
		{
	//    echo "$char\n";
		 $e="";
	     }
 $char = fgetc($fp);
	 if ('=' == $char )
// echo "$char\n";

 $char = fgetc($fp);
	 while  ($char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9' || $char == '.' ||  $char == '-')
	{

		 $e=$e.$char;
		$char = fgetc($fp);

		}


?>