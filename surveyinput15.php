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

$result = pg_query($dbconn, "INSERT INTO HBX2(callingnumber, questionsanswered, overallsatisfaction, waittime, professionalism, referral) 
                           VALUES('$cn', '$qstn', '$sat','$wait','$prof','$refer');");

// Questions Answered Switch

switch ($qstn){
   case 1:
      $result = pg_query($dbconn, "INSERT INTO questions2(Strongly_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Questions Answered','Strongly Disagree');");
      break;

   case 2:
      $result = pg_query($dbconn, "INSERT INTO questions2(Somewhat_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Questions Answered','Somewhat Disagree');");
      break;

   case 3:
      $result = pg_query($dbconn, "INSERT INTO questions2(Niether) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Questions Answered','Niether');");
      break;

   case 4:
      $result = pg_query($dbconn, "INSERT INTO questions2(Somewhat_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Questions Answered','Somewhat Agree');");   
      break;
   case 5:
      $result = pg_query($dbconn, "INSERT INTO questions2(Strongly_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Questions Answered','Strongly Agree');");
      break;

}

switch ($sat){
   case 1:
      $result = pg_query($dbconn, "INSERT INTO customerSat2(Strongly_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','Strongly Disagree');");
      break;

   case 2:
      $result = pg_query($dbconn, "INSERT INTO customersat2(Somewhat_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','Somewhat Disagree');");
      break;

   case 3:
      $result = pg_query($dbconn, "INSERT INTO customersat2(Niether) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','Niether');");
      break;

   case 4:
      $result = pg_query($dbconn, "INSERT INTO customersat2(Somewhat_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','Somewhat Agree');");   
      break;

   case 5:
      $result = pg_query($dbconn, "INSERT INTO customersat2(Strongly_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Overall Satisfaction','Strongly Agree');");
      break;
}

switch ($wait){
   case 1:
      $result = pg_query($dbconn, "INSERT INTO wait2(Strongly_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Wait Time','Strongly Disagree');");
      break;

   case 2:
      $result = pg_query($dbconn, "INSERT INTO wait2(Somewhat_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Wait Time','Somewhat Disagree');");
      break;

   case 3:
      $result = pg_query($dbconn, "INSERT INTO wait2(Niether) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Wait Time','Niether');");
      break;

   case 4:
      $result = pg_query($dbconn, "INSERT INTO wait2(Somewhat_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Wait Time','Somewhat Agree');");   
      break;

   case 5:
      $result = pg_query($dbconn, "INSERT INTO wait2(Strongly_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Wait Time','Strongly Agree');");
      break;
}

switch ($prof){
   case 1:
      $result = pg_query($dbconn, "INSERT INTO professionalism2(Strongly_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Professionalism','Strongly Disagree');");
      break;

   case 2:
      $result = pg_query($dbconn, "INSERT INTO professionalism2(Somewhat_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Professionalism','Somewhat Disagree');");
      break;

   case 3:
      $result = pg_query($dbconn, "INSERT INTO professionalism2(Niether) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Professionalism','Niether');");
      break;

   case 4:
      $result = pg_query($dbconn, "INSERT INTO professionalism2(Somewhat_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Professionalism','Somewhat Agree');");   
      break;

   case 5:
      $result = pg_query($dbconn, "INSERT INTO professionalism2(Strongly_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Professionalism','Strongly Agree');");
      break;
}

switch ($refer){
   case 1:
      $result = pg_query($dbconn, "INSERT INTO referral2(Strongly_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Referral','Strongly Disagree');");
      break;

   case 2:
      $result = pg_query($dbconn, "INSERT INTO referral2(Somewhat_Disagree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Referral','Somewhat Disagree');");
      break;

   case 3:
      $result = pg_query($dbconn, "INSERT INTO referral2(Niether) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Referral','Niether');");
      break;

   case 4:
      $result = pg_query($dbconn, "INSERT INTO referral2(Somewhat_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Referral','Somewhat Agree');");   
      break;

   case 5:
      $result = pg_query($dbconn, "INSERT INTO referral2(Strongly_Agree) 
                           VALUES('1');");
      $result = pg_query($dbconn, "INSERT INTO COMPOSITE2(SurveyItem, Result) 
                           VALUES('Referral','Strongly Agree');");
      break;
}


//                          //dump the result object
                           var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  
?>
