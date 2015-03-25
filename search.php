<?php


# Superdupper Contact Search
# Intake a value and use it to search 
# Bonsai JSON pages for a match
#

date_default_timezone_set('America/New_York');
$searchvalue  = $_REQUEST['q'];
$searchvalue = "Liquor";
$baseURL = "https://qjrzeixfhk:efolbnqz45@agencylookup-199053081.us-east-1.bonsai.io/_search?q=";
$date = new DateTime();
$logfile = '/var/log/searchvalue.log';

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



$requestURL =$baseURL . $searchvalue;



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

$jsondecoded = JsonHandler::decode_true($returned_content);

echo  "\n" . json_encode($jsondecoded) . "\n"; 
}
?>