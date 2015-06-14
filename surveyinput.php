<?php

/*
 *  * Sample HBX Web-service to gather real-time results from
 *  * from OneReach Post-call survey
 *	* Potomac Integration and Consulting: Mick Shaw
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
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Questions Answered','Y');");
}elseif ($qstn == '2'){
	$result = pg_query($dbconn, "INSERT INTO questions(_no) 
                           VALUES('1');");

	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Questions Answered','N');");
}

if ($sat == '1'){
	$result = pg_query($dbconn, "INSERT INTO customerSat(_yes) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','Y');");
}elseif ($sat == '2'){
	$result = pg_query($dbconn, "INSERT INTO customerSat(_no) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','N');");
}

if ($wait == '1'){
	$result = pg_query($dbconn, "INSERT INTO wait(_yes) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Wait Time','Y');");

}elseif ($wait == '2'){
	$result = pg_query($dbconn, "INSERT INTO wait(_no) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Wait Time','N');");
}					
if ($prof == '1'){
	$result = pg_query($dbconn, "INSERT INTO professionalism(_yes) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Professionalism','Y');");
}elseif ($prof == '2'){
	$result = pg_query($dbconn, "INSERT INTO professionalism(_no) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Professionalism','N');");
}


//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
