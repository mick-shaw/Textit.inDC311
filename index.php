<?php

# Location Validation Wrapper for Textit.in
# Simplifies the JSON response from citizenatlas
# and returns a flat dictionary.
# Version 1.0
# Maintainer: Mick Shaw (mshaw@potomacintegration.com)
# Date: 01/23/2015

# TODO

# 1) Write handler for invalid Addresses - Need to test invalid entries.


date_default_timezone_set('America/New_York');
$AddressInfo  = $_REQUEST['str'];
$responseFormat = "json";
$baseURL = "http://citizenatlas.dc.gov/newwebservices/locationverifier.asmx/findLocation2?";
$date = new DateTime();
# Log file
#$logfile = '/var/log/LocationFinder.log';
$Location_Arr = array();
$LocationURL_Arr = array();
$InvalidLocation = array('Address_0'=>'invalid');


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



	
$requestURL =$baseURL . "f=" . $responseFormat . "&" . "str=" . $AddressInfo;

$requestURL=str_replace(' ','+',$requestURL);

file_put_contents("php://stdout", "\n" . $date->format('Y-m-d H:i:s') . " " . $requestURL . "\n", FILE_APPEND | LOCK_EX);

  $ch = curl_init($requestURL);
  $timeout = 15;
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
  $returned_content = curl_exec($ch);
  $responseCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  $date = new DateTime();
 
 file_put_contents("php://stderr", $date->format('Y-m-d H:i:s') . " " . $AddressInfo . " " . $returned_content . "\n", FILE_APPEND | LOCK_EX);
	
   if($responseCode == '200' ) {
   	$jsonData = JsonHandler::decode($returned_content); 
          $x=0;
          
          foreach ($jsonData->returnDataset->Table1 as $AddressTable) {
  	 		       {
                $ArrayIndex = "Address_" . (string)$x;
                $ArrayURLIndex = "AddressURL_" . (string)$x;
              if (($AddressTable->STATUS == "ACTIVE")&& ($x <5)){
  	 		
                $FullAdress = $AddressTable->FULLADDRESS;
                $StreetURL = $AddressTable->STREETVIEWURL;
                $Location_Arr[$ArrayIndex] = $FullAdress;
                $Location_Arr[$ArrayURLIndex] = $StreetURL;
                $x=$x+1;
  	 		      } 
  	 		
  	 	     }
    	   }
   	}
   


if (empty($Location_Arr[0])) {
  echo "\n" . json_encode($InvalidLocation). "\n";;
}else{
  echo  "\n" . json_encode($Location_Arr). "\n";  
}

?>
