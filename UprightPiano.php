<?php
error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging

// API request variables
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$query = 'Kimball Upright';                  // Supply your own query keywords as needed

// Create a PHP array of the item filters you want to use in your request
$medianarray = array();
$filterarray =
  array(
    array(
    'name' => 'MinPrice',
    'value' => '100',
    'paramName' => 'Currency',
    'paramValue'  => 'USD'),
    array(
    'name' => 'MaxPrice',
    'value' => '2000',
    'paramName' => 'Currency',
    'paramValue'  => 'USD'),
    array(
    'name' => 'FreeShippingOnly',
    'value' => 'true',
    'paramName' => '',
    'paramValue'  => ''),
    array(
    'name' => 'ListingType',
    'value' => array('AuctionWithBIN','FixedPrice','StoreInventory'),
    'paramName' => '',
    'paramValue'  => ''),
  );


  // Generates an XML snippet from the array of item filters
function buildXMLFilter ($filterarray) {
  global $xmlfilter;
  // Iterate through each filter in the array
  foreach ($filterarray as $itemfilter) {
    $xmlfilter .= "<itemFilter>\n";
    // Iterate through each key in the filter
    foreach($itemfilter as $key => $value) {
      if(is_array($value)) {
        // If value is an array, iterate through each array value
        foreach($value as $arrayval) {
          $xmlfilter .= " <$key>$arrayval</$key>\n";
        }
      }
      else {
        if($value != "") {
          $xmlfilter .= " <$key>$value</$key>\n";
        }
      }
    }
    $xmlfilter .= "</itemFilter>\n";
  }
  return "$xmlfilter";
} // End of buildXMLFilter function

// Build the item filter XML code
buildXMLFilter($filterarray);

// Construct the findItemsByKeywords POST call
// Load the call and capture the response returned by the eBay API
// The constructCallAndGetResponse function is defined below
$resp = simplexml_load_string(constructPostCallAndGetResponse($endpoint, $query, $xmlfilter));

// Check to see if the call was successful, else print an error
if ($resp->ack == "Success") {
  $results = '';  // Initialize the $results variable
  $totals = '';
  $count = '';
  // Parse the desired information from the response
  #foreach($resp->searchResult->item as $item) {
  foreach($resp->searchResult->item as $item) {
  
    $pic   = $item->galleryURL;
    $link  = $item->viewItemURL;
    $title = $item->title;
    $Price = $item->sellingStatus->currentPrice;
    $currentPrice = floatval($Price);
    array_push($medianarray, $currentPrice);

    // Build the desired HTML code for each searchResult.item node and append it to $results
    $results .= "<tr><td><?php echo $query; ?>$<?php echo money_format('%.2n', $currentPrice); ?>$currentPrice</td><td><a href=\"$link\">$title</a></td></tr>";
  	$totals = $currentPrice + $totals;
  	$count++;
  	$AveragePrince = $totals/$count;
  }
}
else {  // If the response does not indicate 'Success,' print an error
  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
  $results .= "AppID for the Production environment.</h3>";
}
function array_median($array) {
  // perhaps all non numeric values should filtered out of $array here?
  $iCount = count($array);
  if ($iCount == 0) {
    throw new DomainException('Median of an empty array is undefined');
  }
  // if we're down here it must mean $array
  // has at least 1 item in the array.
  $middle_index = floor($iCount / 2);
  sort($array, SORT_NUMERIC);
  $median = $array[$middle_index]; // assume an odd # of items
  // Handle the even case by averaging the middle 2 items
  if ($iCount % 2 == 0) {
    $median = ($median + $array[$middle_index - 1]) / 2;
  }
  return $median;
}
?>

<!-- Build the HTML page with values from the call response -->
<html>
<head>
<title>Current Median Price on eBay for: <?php echo $query; ?></title>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
</head>
<body>
<h3>Current median price for an upright piano on ebay is $<?php echo array_median($medianarray); ?></h3>
<h3>Current average price for an upright piano on ebay is $<?php echo money_format('%.2n', $AveragePrince); ?></h3>


<table>
<tr>
  <td>
    <?php echo $results;?>
  </td>
</tr>
</table>

</body>
</html>



<?php
function constructPostCallAndGetResponse($endpoint, $query, $xmlfilter) {

global $xmlrequest;

  // Create the XML request to be POSTed
  $xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlrequest .= "<findItemsByKeywordsRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">\n";
  $xmlrequest .= "<keywords>";
  $xmlrequest .= $query;
  $xmlrequest .= "</keywords>\n";
  $xmlrequest .= $xmlfilter;
  $xmlrequest .= "<paginationInput>\n  <entriesPerPage>1000</entriesPerPage>\n</paginationInput>\n";
  $xmlrequest .= "</findItemsByKeywordsRequest>";

  // Set up the HTTP headers
  $headers = array(
    'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
    'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
    'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
    'X-EBAY-SOA-GLOBAL-ID: EBAY-US',
    'X-EBAY-SOA-SECURITY-APPNAME: PIC3931b7-fe12-46d2-92b5-d8fd301380e',
    'Content-Type: text/xml;charset=utf-8',
  );
  $session  = curl_init($endpoint);                       // create a curl session
  curl_setopt($session, CURLOPT_POST, true);              // POST request type
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  

$responsexml = curl_exec($session);                     // send the request
  curl_close($session);                                   // close the session
  return $responsexml;                                    // returns a string
    // return values as a string, not to std out
}  // End of constructPostCallAndGetResponse function
?>
