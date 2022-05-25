<?php

//var_dump(hash('sha256', '1234'));die;


$servername = "users-mysql";
$username = "og";
$password = "password";
$dbname = "users";
$port = "3306";

$dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);

//$sql = 'SELECT password
//    FROM products
//    WHERE name = :n';
//$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
//$sth->execute(array('n' => 'admin'));
//$password = $sth->fetchColumn();
//var_dump($password);die;

//var_dump(empty($_SERVER['PHP_AUTH_DIGEST']));die;
$realm = 'Skladovka';

// Just a random id
$nonce = uniqid();

// Get the digest from the http header
$digest = getDigest();

// If there was no digest, show login
if (is_null($digest)) requireLogin($realm,$nonce);

$digestParts = digestParse($digest);

$validUser = $digestParts['username'];

$sql = 'SELECT password
    FROM products
    WHERE name = :n';
$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array('n' => $digestParts['username']));
$validPass = $sth->fetchColumn();
//var_dump($password);die;

// Based on all the info we gathered we can figure out what the response should be
$A1 = md5("{$validUser}:{$realm}:{$validPass}");
$A2 = md5("{$_SERVER['REQUEST_METHOD']}:{$digestParts['uri']}");

$validResponse = md5("{$A1}:{$digestParts['nonce']}:{$digestParts['nc']}:{$digestParts['cnonce']}:{$digestParts['qop']}:{$A2}");

if ($digestParts['response']!=$validResponse) requireLogin($realm,$nonce);

// We're in!
echo 'Well done sir, you made it all the way through the login!';

// This function returns the digest string
function getDigest() {

    // mod_php
    if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
        $digest = $_SERVER['PHP_AUTH_DIGEST'];
        // most other servers
    } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {

        if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']),'digest')===0)
            $digest = substr($_SERVER['HTTP_AUTHORIZATION'], 7);
    }

    return $digest;

}

// This function forces a login prompt
function requireLogin($realm,$nonce) {
    header('WWW-Authenticate: Digest realm="' . $realm . '",qop="auth",nonce="' . $nonce . '",opaque="' . md5($realm) . '"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    die();
}

// This function extracts the separate values from the digest string
function digestParse($digest) {
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();

    //whitespaces or non-empty string match
    preg_match_all('@(\w+)=(?:(?:")([^"]+)"|([^\s,$]+))@', $digest, $matches, PREG_SET_ORDER);
//    file_put_contents((__DIR__) . '/../img/matches', json_encode($matches, JSON_PRETTY_PRINT));
//    file_put_contents((__DIR__) . '/../img/digest', json_encode($digest, JSON_PRETTY_PRINT));

   /*
    * [
        [
            "username=\"admin\"",
            "username",
            "admin"
        ],

        ....
    */
    foreach ($matches as $m) {
        $data[$m[1]] = $m[2] ? $m[2] : $m[3];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}




die;
$realm = 'Skladovka';

//user => password
$users = array('admin' => 'mypass', 'guest' => 'guest');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="' . $realm .
        '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');

    die('Text to send if user hits Cancel button');
}


// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('Wrong Credentials!');


// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $data['uri']);
$valid_response = md5($A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $A2);

if ($data['response'] != $valid_response)
    die('Wrong Credentials!');

// ok, valid username & password
echo 'You are logged in as: ' . $data['username'];


// function to parse the http auth header
function http_digest_parse($txt)
{
//    var_dump($txt);die;
    // protect against missing data
    $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

die;

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}


?>