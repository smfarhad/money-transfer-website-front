<?php
/*
 *
 * POST /v2/eid/sbid-another HTTP/1.1 HTTP/1.1
 * Host: api.zignsec.com
 * Content-Type: application/x-www-form-urlencoded
 * Authorization: 448c77b9-4d2a-4201-84ac-9a3d844f7146
 * Cache-Control: no-cache
 * Postman-Token: 7d861af9-6e66-b8ad-27b4-f3afa3d3baa7
 *
 * PersonalNumber=198410400712&target=http%3A%2F%2Fswebd.se
 *
 */
$curl = curl_init ();

$personnumber = "198410300712";
// $target_url = "http%3A%2F%2Fswebd.se";
$target_url = "http://swebd.se/Delete-files/api/personnumber_receive.php";

// The data to send to the API
$data = "PersonalNumber=" . $personnumber . "&target=" . $target_url;

curl_setopt_array ( $curl, array (
		CURLOPT_URL => "https://api.zignsec.com/v2/eid/sbid-another",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array (
				"authorization: 448c77b9-4d2a-4201-84ac-9a3d844f7146",
				"cache-control: no-cache",
				"Token: 448c77b9-4d2a-4201-84ac-9a3d844f7146", // need to send new token
				"content-type: application/x-www-form-urlencoded" 
		),
		CURLOPT_POSTFIELDS => $data 

) );

$response = curl_exec ( $curl );
$err = curl_error ( $curl );

curl_close ( $curl );

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
	
	$data = json_decode ( $response );
	
	/*
	 * echo $id = $data->id . '<br>';
	 * echo $error = $data->errors . '<br>';
	 * echo $url = $data->redirect_url;
	 * echo count($error) ;
	 */
	
	echo "<script type='text/javascript'> location.href = '". $url = $data->redirect_url."';</script>";
	?>

<?php
}


