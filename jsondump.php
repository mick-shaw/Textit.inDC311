<?php

/*
 *  * Sample HBX Web-service to gather real-time results from
 *  * from OneReach Post-call survey
 *  * Potomac Integration and Consulting: Mick Shaw
 *  * Rank Survey Results
 *   */
 
// Select all Survey Results from DB and present them in JSON
// Connect to my awesome Sample PostGres Database
$survey = $_REQUEST['survey'];
$query  = $_REQUEST['query'];

$dbconn = pg_connect("host=ec2-54-83-17-8.compute-1.amazonaws.com dbname=d4053sck3t55ue user=xvvxssmzzaoaks password=Llcymti7JpH2tIA59lyKdPhqlM")
         or die('Could not connect: ' . pg_last_error());


// Select Survey Answers from my awesome database

if ($survey == 'yes_no'){ 
   switch ($query){
      case "all":
      $result = pg_query($dbconn, "SELECT * FROM HBX");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "today":
      $result = pg_query($dbconn, "SELECT * FROM HBX WHERE my_date = now()::DATE");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todaytotal":
      $result = pg_query($dbconn, "SELECT COUNT(*) FROM HBX WHERE my_date = now()::DATE");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayreferral":
      $result = pg_query($dbconn, "SELECT result 
         AS Referral_Results, COUNT(result) AS Totals 
         FROM composite WHERE surveyitem = 'Referral' 
         AND my_date=now()::Date GROUP BY Referral_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayquestions":
      $result = pg_query($dbconn, "SELECT result 
         AS Question_Results, COUNT(result) AS Totals 
         FROM composite WHERE surveyitem = 'Questions Answered' 
         AND my_date=now()::Date GROUP BY Question_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayprofessionalism":
      $result = pg_query($dbconn, "SELECT result 
         AS Professionalism_Results, COUNT(result) AS Totals 
         FROM composite WHERE surveyitem = 'Professionalism' 
         AND my_date=now()::Date GROUP BY Professionalism_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayoverall":
      $result = pg_query($dbconn, "SELECT result 
         AS Overall_Results, COUNT(result) AS Totals 
         FROM composite WHERE surveyitem = 'Overall Satisfaction' 
         AND my_date=now()::Date GROUP BY Overall_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todaywaittime":
      $result = pg_query($dbconn, "SELECT result 
         AS WaitTime_Results, COUNT(result) AS Totals 
         FROM composite WHERE surveyitem = 'Wait Time' 
         AND my_date=now()::Date GROUP BY WaitTime_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;
   }
}    
   
   
   
if ($survey == 'rank'){ 
   switch ($query){
   case "all":
      $result = pg_query($dbconn, "SELECT * FROM HBX2");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "today":
      $result = pg_query($dbconn, "SELECT * FROM HBX2 WHERE my_date = now()::DATE");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todaytotal":
      $result = pg_query($dbconn, "SELECT COUNT(*) FROM HBX2 WHERE my_date = now()::DATE");
      print json_encode(array_values(pg_fetch_all($result)));
      break; 

       case "todayreferral":
      $result = pg_query($dbconn, "SELECT result 
         AS Referral_Results, COUNT(result) AS Totals 
         FROM composite2 WHERE surveyitem = 'Referral' 
         AND my_date=now()::Date GROUP BY Referral_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayquestions":
      $result = pg_query($dbconn, "SELECT result 
         AS Question_Results, COUNT(result) AS Totals 
         FROM composite2 WHERE surveyitem = 'Questions Answered' 
         AND my_date=now()::Date GROUP BY Question_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayprofessionalism":
      $result = pg_query($dbconn, "SELECT result 
         AS Professionalism_Results, COUNT(result) AS Totals 
         FROM composite2 WHERE surveyitem = 'Professionalism' 
         AND my_date=now()::Date GROUP BY Professionalism_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todayoverall":
      $result = pg_query($dbconn, "SELECT result 
         AS Overall_Results, COUNT(result) AS Totals 
         FROM composite2 WHERE surveyitem = 'Overall Satisfaction' 
         AND my_date=now()::Date GROUP BY Overall_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;

      case "todaywaittime":
      $result = pg_query($dbconn, "SELECT result 
         AS WaitTime_Results, COUNT(result) AS Totals 
         FROM composite2 WHERE surveyitem = 'Wait Time' 
         AND my_date=now()::Date GROUP BY WaitTime_Results");
      print json_encode(array_values(pg_fetch_all($result)));
      break;
   
   }
}
              //dump the result object
                           //var_dump($result);

                           //Closing connection
                          pg_close($dbconn);
  

?>
