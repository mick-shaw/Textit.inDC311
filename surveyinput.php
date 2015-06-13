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
if ($qstn = '1'){
	$result = pg_query($dbconn, "INSERT INTO CustomerSat(_yes) 
                           VALUES('$qstn');");
}else{
	$result = pg_query($dbconn, "INSERT INTO CustomerSat(_no) 
                           VALUES('$qstn');");
}
					
//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
