<?php

/*
 *  * Sample HBX Web-service to gather real-time results from
 *  * from OneReach Post-call survey
 *	* Potomac Integration and Consulting: Mick Shaw
 *   */
 
// Gather data elements from the OneReach webcall post-survey
// cn    = Phone Nunmber
// qstn  = Questions Answered Answer 
// sat   = Overall Satisfaction Answer
// wait  = Wait Time Answer
// prof  = Professionalism Answer
// refer = Referral Answer

$cn  = $_REQUEST['cn'];
$qstn = $_REQUEST['qstn'];
$sat = $_REQUEST['sat'];
$wait = $_REQUEST['wait'];
$prof = $_REQUEST['prof']; 
$refer = $_REQUEST['refer'];

// Connect to my awesome Sample PostGres Database

$dbconn = pg_connect("host=ec2-54-83-17-8.compute-1.amazonaws.com dbname=d4053sck3t55ue user=xvvxssmzzaoaks password=Llcymti7JpH2tIA59lyKdPhqlM")
         or die('Could not connect: ' . pg_last_error());


// Insert the Survey Answers into the awesome database

$result = pg_query($dbconn, "INSERT INTO HBX(callingnumber, questionsanswered, overallsatisfaction, waittime, professionalism, referral) 
                           VALUES('$cn', '$qstn', '$sat','$wait','$prof','$refer');");
if ($qstn == '1'){
	$result = pg_query($dbconn, "INSERT INTO questions(_yes) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Questions Answered','Y');");
}
if ($qstn == '2'){
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
}
if ($sat == '2'){
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

}
if ($wait == '2'){
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
}
if ($prof == '2'){
	$result = pg_query($dbconn, "INSERT INTO professionalism(_no) 
                           VALUES('1');");
	$result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Professionalism','N');");
}
if ($refer == '1'){
   $result = pg_query($dbconn, "INSERT INTO referral(_yes) 
                           VALUES('1');");
   $result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Referral','Y');");
}
if ($prof == '2'){
   $result = pg_query($dbconn, "INSERT INTO referral(_no) 
                           VALUES('1');");
   $result = pg_query($dbconn, "INSERT INTO COMPOSITE(SurveyItem, Result) 
                           VALUES('Referral','N');");
}

//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
