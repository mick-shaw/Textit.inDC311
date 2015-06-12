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
$prof = = $_REQUEST['prof']; 

$dbconn = pg_connect("host=ec2-54-83-17-8.compute-1.amazonaws.com dbname=d4053sck3t55ue user=yysuxoqqtdzohb password=D27ay0-A7oQKsvsGmAfrCBnmT9")
         or die('Could not connect: ' . pg_last_error());


         //perform the insert using pg_query
$result = pg_query($dbconn, "INSERT INTO HBX($cn, $qstn, $sat, $waittime, $prof) 
                           VALUES('4103705432', '1', '1','1','1');");

//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
