<?php

/*
 *  * PHP PGSQL - How to insert rows into PostgreSQL table
 *	* Sample HBX Demo
 *   */
 
// Connecting, selecting database
$cn  = $_REQUEST['cn'];
$qstn = $_REQUEST['qstn'];
$sat = $_REQUEST['sat'];
$wait = $_REQUEST['wait'];
$prof = $_REQUEST['prof']; 

$dbconn = pg_connect("host=ec2-54-83-17-8.compute-1.amazonaws.com dbname=d4053sck3t55ue user=yysuxoqqtdzohb password=D27ay0-A7oQKsvsGmAfrCBnmT9")
         or die('Could not connect: ' . pg_last_error());


         //perform the insert using pg_query
$result = pg_query($dbconn, "INSERT INTO HBX(callingnumber, questionsanswered, overallsatisfaction, waittime, professionalism) 
                           VALUES('$cn', '$qstn', '$sat','$wait','$prof');");
if ($qstn == '1'){
	$result = pg_query($dbconn, "INSERT INTO questions(_yes) 
                           VALUES('1');");
}elseif ($qstn == '2'){
	$result = pg_query($dbconn, "INSERT INTO questions(_no) 
                           VALUES('1');");
}

if ($sat == '1'){
	$result = pg_query($dbconn, "INSERT INTO customerSat(_yes) 
                           VALUES('1');");
}elseif ($sat == '2'){
	$result = pg_query($dbconn, "INSERT INTO customerSat(_no) 
                           VALUES('1');");
}

if ($wait == '1'){
	$result = pg_query($dbconn, "INSERT INTO wait(_yes) 
                           VALUES('1');");
}elseif ($wait == '2'){
	$result = pg_query($dbconn, "INSERT INTO wait(_no) 
                           VALUES('1');");
}					
if ($prof == '1'){
	$result = pg_query($dbconn, "INSERT INTO professionalism(_yes) 
                           VALUES('1');");
}elseif ($prof == '2'){
	$result = pg_query($dbconn, "INSERT INTO professionalism(_no) 
                           VALUES('1');");
}


//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
