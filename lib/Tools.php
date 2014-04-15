<?php

// /**
// * Return any part of the current URL string
// * Usage example: getCurrentUrl("fullURL"); or getCurrentUrl("request");
// * Parameters available:
// * Now filters out  AmazonAWS load balancer Urls
// *  "https", "server", "port", "request", "baseURL", "fullURL", "fullURL+port"
// */
// //public
// function getCurrentUrl($part="fullURL") {
//   global $productionURL;
//   $httpsSetting = $_SERVER["HTTPS"];
//   $serverName = $productionURL;
//   $serverPort = $_SERVER["SERVER_PORT"];
//   $serverRequest = $_SERVER["REQUEST_URI"];

//   if ( $httpsSetting != 'on' ) {
//     $httpsSetting = 'http://';
//   } else{
//     $httpsSetting = 'https://';
//   }

//   $baseURL = $httpsSetting . $serverName;
//   $fullURL = $baseURL . $serverRequest;

//   switch ($part) {
//     case "https": return $httpsSetting;
//     case "server": return $serverName;
//     case "port": return $serverPort;
//     case "request": return $serverRequest;
//     case "baseURL": return $baseURL;
//     case "fullURL": return $fullURL;
//     case "fullURL+port": return $baseURL . ":" . $serverPort . $serverRequest;
//   }

// }

function stripURL($url){
  list($pt1, $pt2) = explode('?', $url);
  return $pt1;
}

/* localhost hack */


function isLocalhost(){
  return $_SERVER["SERVER_NAME"] === 'localhost';
}


if(isLocalhost()){
  debugSrc("LOCALHOST = TRUE");
}
else{
  debugSrc("LOCALHOST = FALSE");
}



/**
* drop in file paths for js, css, and image files
* @param $path = path to your resource ex. "img/mastadon.png"
* @param $prefix - optional, if set it will prepend a string to the url, ex 'www.dinorrific.io/img/pterodactyl.png'
* @return string of html
*/
function getResource($path, $cssClass="", $prefix="") {
  $html = "";
  debugSrc(" production url is: ". $prefix);
  if ( strpos($path, '.gif') !== false
    || strpos($path, '.png') !== false
    || strpos($path, '.jpeg') !== false
    || strpos($path, '.jpg') !== false
    ){
    $html = "<img class='$cssClass' src='". $prefix . $path."' />";
}
if (strpos($path, '.css') !== false){
  $html = "<link rel='stylesheet' href='". $prefix . $path."'>";
}
if (strpos($path, '.js') !== false){
  $html = "<script src='". $prefix . $path."'></script>";
}
return $html;
}





//public
function consolelog($input){
  echo "<pre class='console'
  style='
  z-index: 99999999;
  font-family: monospace;
  color: white;
  background: rgba(0,0,0,.8);
  border-top: 5px solid rgba(0,0,0,.9);
  padding: 15px;
  overflow-x: scroll;
  word-wrap:break-word;
  overflow-y: wrap;
  position: fixed;
  height: 300px;
  width: 100%;
  bottom: 0px;
  '>";
  print_r($input);
  echo "</pre>";
}


//public
function console($input){
  echo "<pre class='console'
  style='
  font-family: monospace;
  color: white;
  background: rgba(0,0,0,.8);
  border-top: 5px solid rgba(0,0,0,.9);
  padding: 15px;
  overflow-x: scroll;
  word-wrap:break-word;
  overflow-y: wrap;
  position: relative;
  height: 400px;
  width: 400px;
  '>";
  print_r($input);
  echo "</pre>";
}


//public
function debugSrc($input, $backtrace = false){
  echo "<!--<pre>\n///////////////////////////-[ DEBUG LOG ]-//////////////////////////////\n\n";
  if($backtrace){
// echo debug_string_backtrace();
  }
  print_r($input);
  echo "\n\n///////////////////////////-[ DEBUG LOG ]-//////////////////////////////\n</pre>-->\n\n\n\n";
}


//public
function isUSD($currencyType){
  return $currencyType === "USD";
}


//public
function falsyToZero($string){
  if(empty($string)){
    return 0;
  }
}


//public
function stripNumber($string){
  return preg_replace( '/[^0-9]/', '', $string);
}

   function alert($input){
      echo "<script>allert('";
        echo $input;
        echo "');</script>";
    }


?>