<?php
/*

POST /v2/mmessaging HTTP/1.1
Host: test.zignsec.com
Content-Type: application/x-www-form-urlencoded
Authorization: e28abe50-a2b1-4a4d-90c0-d95b3146dcbd
Cache-Control: no-cache
Postman-Token: 4a7cc859-b7ab-225e-3a2a-5ad595cd4b5b

from=46730449308&to=46736454633&text=This+message+is+send+from+Zignsec+gateway+and+it's+working+fine+%3A)

*/


$curl = curl_init();

$from = "46730449308";
$to = "46736454633";
$text = "This second message also works fine";


// The data to send to the API
$data = "from=".$from."&to=".$to."&text=".$text;

curl_setopt_array($curl, array(
		CURLOPT_URL => "https://test.zignsec.com/v2/mmessaging",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
				"authorization: e28abe50-a2b1-4a4d-90c0-d95b3146dcbd",
				"cache-control: no-cache",
				"Token: 448c77b9-4d2a-4201-84ac-9a3d844f7146", // need to send new token
				"content-type: application/x-www-form-urlencoded",
		),
		CURLOPT_POSTFIELDS => $data
		
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}