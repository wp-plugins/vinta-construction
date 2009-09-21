<?php 
session_start();
$_SESSION['vinta_version'] = '1.0' ;
function vinta_server_version()
 {
$site_url = 'http://vasthtml.com/themeforms/vinta_update.php';
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, $site_url);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
 
ob_start();
curl_exec($ch);
curl_close($ch);
$file_contents = ob_get_contents();
ob_end_clean();

   if (preg_match ("@\<span\>(.*)\</span\>@i", $file_contents, $out)) {
   return $out[1];
   
  }
 } 
?>