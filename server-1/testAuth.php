<?php
//$url = "http://localhost:8000/db/editProduct.php";
$url = "http://localhost:8000/db/getAllProducts.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);

// I have tried setting both of these
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);

$pass = hash('sha256', '1234');
// In combination of the above separately, I have tried each of these individually
curl_setopt($ch, CURLOPT_USERPWD, "admin:" . $pass);

//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Auth Digest: ' . $token));

curl_setopt($ch, CURLOPT_POST, true);
//$post_data = array('Auth Digest' => $token);
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));

//curl_setopt($ch, CURLOPT_USERPWD, $token);

$response = curl_exec($ch);
curl_close($ch);

if(curl_error($ch)){
    var_dump(curl_error($ch));
}
//$header_sent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
//$header_received = curl_getinfo($ch, CURLINFO_HEADER_SIZE)
//var_dump($response);die;
$headers = [];
$response = rtrim($response);
$data = explode("\n",$response);
$headers['status'] = $data[0];
array_shift($data);

foreach($data as $part){

    //some headers will contain ":" character (Location for example), and the part after ":" will be lost, Thanks to @Emanuele
    $middle = explode(":",$part,2);

    //Supress warning message if $middle[1] does not exist, Thanks to @crayons
    if ( !isset($middle[1]) ) { $middle[1] = null; }

    $headers[trim($middle[0])] = trim($middle[1]);
}

// Print all headers as array
echo "<pre>";
var_dump($headers);
echo "</pre>";
die;
if (!$response) {
    var_dump(curl_error($ch));
    var_dump($header_received);
    return false;
}

$response_json = json_decode($response);
var_dump($response_json);

//$header = array();
//$header[] = 'Content-length: 0';
//$header[] = 'Content-type: application/json';
//$header[] = 'Authorization: Digest username="admin", realm="Skladovka", nonce=xxx uri="/db/getAllProducts.php", response="98ccab4542f284c00a79b5957baaff23", opaque="d8ea7aa61a1693024c4cc3a516f49b3c", qop=auth, nc=00000001, cnonce="8d1b34edb475994b"';
