<?php

/*
 *  * PHP PGSQL - How to insert rows into PostgreSQL table
 *   */
 
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-54-83-17-8.compute-1.amazonaws.com dbname=d4053sck3t55ue user=yysuxoqqtdzohb password=D27ay0-A7oQKsvsGmAfrCBnmT9")
         or die('Could not connect: ' . pg_last_error());

         //perform the insert using pg_query
$result = pg_query($dbconn, "INSERT INTO HBX(callingnumber, questionsanswered, overallsatisfaction, waittime, professionalism) 
                           VALUES('4103705432', '1', '1','1','1');");

//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
