<?php


# Superdupper Trash Collection Service Request Status API
# Provides All Service Request with Service Code S0441.
# Requires start_date and end_date Parameters
# Uses the address to query the citizen address for lat/long
# and adds the lat/long fields in the JSON Response
# Version 1.0
# Maintainer: Mick Shaw (mshaw@potomacintegration.com)
# Date: 03/05/2015
#
# TODO: Clean it up
# This was down and dirty (Frankenstein script)
#

date_default_timezone_set('America/New_York');
#$start_date  = $_REQUEST['start_date'];
#$end_date = $_REQUEST['end_date'];

$Location_Arr = array();
$LocationURL_Arr = array();
$start_date  = "2015-03-01T00%3A00%3A00.300Z";
$end_date = "2015-03-04T00%3A00%3A00.300Z";
$baseURL = "http://app.311.dc.gov/cwi/Open311/v2/requests.xml?jurisdiction_id=dc.gov&service_code=S0441";
$date = new DateTime();
$logfile = 'php://stdout';
#$ServiceRequestIDArray = array();
#$RetunedDataset = array();
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
 
    public static function decode_false($json, $assoc = false) {
        $result = json_decode($json, $assoc);
 
        if($result) {
            return $result;
        }
 
        throw new RuntimeException(static::$_messages[json_last_error()]);
    }

    public static function decode_true($json, $assoc = true) {
        $result = json_decode($json, $assoc);
 
        if($result) {
            return $result;
        }
 
        throw new RuntimeException(static::$_messages[json_last_error()]);
    }
 
}

function TrashAddress ($AddressInput, $latlon){
 
    $responseFormat = "json";
    $GISbaseURL = "http://citizenatlas.dc.gov/newwebservices/locationverifier.asmx/findLocation2?";
    $GISrequestURL =$GISbaseURL . "f=" . $responseFormat . "&" . "str=" . $AddressInput;

    $GISrequestURL=str_replace(' ','+',$GISrequestURL);

      $ch = curl_init($GISrequestURL);
      $timeout = 15;
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
      $returned_content = curl_exec($ch);
      $responseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      $date = new DateTime();
     
     #file_put_contents($logfile, $date->format('Y-m-d H:i:s') . " " . $AddressInput . " " . $returned_content . "\n", FILE_APPEND | LOCK_EX);
      
       if($responseCode == '200' ) {
        $jsonData = json_decode($returned_content); 
              
              
              foreach ($jsonData->returnDataset->Table1 as $AddressTable) {
                   {
                    $ArrayIndex = "Latitude";
                    $ArrayURLIndex = "Longitude";
                    $Latitude = "$AddressTable->LATITUDE";
                    $Longitude = "$AddressTable->LONGITUDE";
                    $Location_Arr[$ArrayIndex] = "$Latitude";
                    $Location_Arr[$ArrayURLIndex] = "$Longitude";
                   
            
               }
             }
        }
       
if ($latlon == "lat"){

  return $Latitude;

}elseif ($latlon == "lon") {
  return $Longitude;
}
  
    }



$requestURL =$baseURL . "&start_date=" . $start_date . "&end_date=" . $end_date;



#file_put_contents($logfile, "\n" . $date->format('Y-m-d H:i:s') . " " . $requestURL . "\n", FILE_APPEND | LOCK_EX);

  $ch = curl_init($requestURL);
  $timeout = 15;
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
  $returned_content = curl_exec($ch);
  $responseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  $date = new DateTime();
 
#file_put_contents($logfile, $date->format('Y-m-d H:i:s') . " " . $returned_content . "\n", FILE_APPEND | LOCK_EX);
  
if($responseCode == '200' ) {

$jsonData = xml2json::transformXmlStringToJson($returned_content);
$jsondecoded = JsonHandler::decode_false($jsonData);

foreach ($jsondecoded->service_requests as $Request) {
                $ServiceRequestIDArray = $Request;
              }
         }

$ScrubedRequest = json_encode($Request);

$decodedRequest = JsonHandler::decode_true($ScrubedRequest);


$x = 0;
foreach ($decodedRequest as $AddressTable) {
  
  $lat = "lat";
  $lon = "lon";
  $AddressTable['lat']=TrashAddress(($AddressTable['address']),$lat);
  $AddressTable['long']=TrashAddress(($AddressTable['address']),$lon);  
  $RetunedDataset[$x] = $AddressTable;
  $x = $x+1;
}  

echo  "\n" . json_encode($RetunedDataset). "\n"; 

?>