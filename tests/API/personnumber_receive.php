<?php
$relaystate = htmlspecialchars ( $_GET ["relaystate"] );

echo $relaystate;

$curl = curl_init ();

curl_setopt_array ( $curl, array (
		CURLOPT_URL => "https://api.zignsec.com/v2/eid/" . $relaystate,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array (
				"authorization: 448c77b9-4d2a-4201-84ac-9a3d844f7146",
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded" 
		) 
) );

$response = curl_exec ( $curl );
$err = curl_error ( $curl );

curl_close ( $curl );

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
