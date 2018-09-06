<?php
	######################################################
	## Update Backend Script for Modern LWC - v1.0      ##
	##                                                  ##
	## Provided as completely open source code which    ##
	## may be freely modified and distributed.          ##
	######################################################
	
	# Requested file version, throw HTTP 400 Bad Request if not given
	$reqVer = ( array_key_exists("ver", $_GET) && is_numeric( trim( $_GET["ver"] ) ) ) ? trim( $_GET["ver"] ) : badRequest();
	
	# OPTIONAL: Prettify output JSON before sending to client instead of pure carbon copy
	$prettyJSON = true;
	
	fetchData($reqVer);
	
	function fetchData($version){

		switch ($version) {
		
			case 1:
				# URL of the updates origin file
				$updatesURL = "https://raw.githubusercontent.com/Tsuser1/Modern-LWC-Updates/master/revision/1/updates.json";
				
				$updateDataCurl = curl_init();
				curl_setopt($updateDataCurl, CURLOPT_URL, $updatesURL);
				curl_setopt($updateDataCurl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($updateDataCurl, CURLOPT_BINARYTRANSFER, true);
				curl_setopt($updateDataCurl, CURLOPT_CRLF, true) ;

				$updateData = curl_exec($updateDataCurl);
				curl_close($updateDataCurl);
				
				echo(($GLOBALS['prettyJSON']) ? prettifyJSON($updateData) : $updateData);
				
				break;
				
			default:
				badRequest();
				break;
		}
	}
	
	function badRequest(){
		http_response_code(400);
		echo("400. Bad Request.");
		exit;
	}
	
	function prettifyJSON($nastyJSON, $prettyJSON){
		return json_encode(json_decode($nastyJSON), JSON_PRETTY_PRINT);
	}
?>
