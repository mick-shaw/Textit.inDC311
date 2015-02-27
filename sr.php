<?php


# DC311 Open311 Service Request Status Textit.in
# Consumes XML from open311.dc.gov
# and returns a flat dictionary JSON response.
# Version 1.0
# Maintainer: Mick Shaw (mshaw@potomacintegration.com)
# Date: 01/27/2015
#
# TODO
#

date_default_timezone_set('America/New_York');
$ServiceRequestID  = $_REQUEST['service_request_id'];
$baseURL = "http://app.311.dc.gov/cwi/Open311/v2/requests.xml?jurisdiction_id=dc.gov";
$date = new DateTime();
$logfile = 'php://stdout';
$ServiceRequestIDArray = array();
$InvalidServiceID = array('service_request_id'=>'invalid');
require_once 'xml2json.php';


class JsonHandler {
 
    protected static $_messages = array(
        JSON_ERROR_NONE => 'No error has occurred',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Syntax error',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
    );
 


    public static function encode($value, $options = 0) {
        $result = json_encode($value, $options);
 
        if($result)  {
            return $result;
        }
 
        throw new RuntimeException(static::$_messages[json_last_error()]);
    }
 
    public static function decode($json, $assoc = false) {
        $result = json_decode($json, $assoc);
 
        if($result) {
            return $result;
        }
 
        throw new RuntimeException(static::$_messages[json_last_error()]);
    }
 
}

$requestURL =$baseURL . "&service_request_id=" . $ServiceRequestID;



file_put_contents($logfile, "\n" . $date->format('Y-m-d H:i:s') . " " . $requestURL . "\n", FILE_APPEND | LOCK_EX);

  $ch = curl_init($requestURL);
  $timeout = 15;
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
  $returned_content = curl_exec($ch);
  $responseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  $date = new DateTime();
 
 file_put_contents($logfile, $date->format('Y-m-d H:i:s') . " " . $returned_content . "\n", FILE_APPEND | LOCK_EX);
  


if($responseCode == '200' ) {

$jsonData = xml2json::transformXmlStringToJson($returned_content);
$jsondecoded = JsonHandler::decode($jsonData);

foreach ($jsondecoded->service_requests as $Request) {
                $ServiceRequestIDArray = $Request;
              }
         }
file_put_contents($logfile, $date->format('Y-m-d H:i:s') . " " . $jsonData . "\n", FILE_APPEND | LOCK_EX);

if (strlen($ServiceRequestID)==11)
{
   echo "\n" . json_encode($ServiceRequestIDArray). "\n"; 
   }
else{

  echo  "\n" . json_encode($InvalidServiceID). "\n"; 

}



?>
