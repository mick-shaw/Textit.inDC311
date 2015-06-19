<?php

/*
 *  * Sample HBX Web-service to gather real-time results from
 *  * from OneReach Post-call survey
 *  * Potomac Integration and Consulting: Mick Shaw
 *  * Rank Survey Results
 *   */
 
// Gather data elements from the OneReach webcall post-survey
// cn    = Phone Nunmber
// qstn  = Questions Answered Answer 
// sat   = Overall Satisfaction Answer
// wait  = Wait Time Answer
// prof  = Professionalism Answers
// refer = Referral Answers


// Connect to my awesome Sample PostGres Database

$dbconn = pg_connect("host=ec2-54-83-17-8.compute-1.amazonaws.com dbname=d4053sck3t55ue user=yysuxoqqtdzohb password=D27ay0-A7oQKsvsGmAfrCBnmT9")
         or die('Could not connect: ' . pg_last_error());


// Insert the Survey Answers into the awesome database

$result = pg_query($dbconn, "SELECT * FROM HBX2");
print json_encode(array_values(pg_fetch_all($result)));

              //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  

?>
