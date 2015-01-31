<?php

require_once("common.php");


if (!isset($_GET['q']) || $_GET['q'] == '') {
    tellError("missing params", 400);
}
$qRaw = $_GET['q'];
$q = explode('/', $qRaw);

if (count($q) < 2) {
    tellError("missing params", 400);
}
//$version = $q[0];
//$authRaw = $q[count($q) - 1];


// API VERSION 1
if ($q[0] == "v1") {

    if ($q[1] == 'auth' && $q[2] == 'nonce') {
        tellError("unimplemented method", 400);

    } else if ($q[1] == 'channel' && $q[2] == 'update' && $q[3] == 'config') {

        channelUpdateConfig($q);
        // authOrDie($q, true);
        // $channel = channelOrDie($q);
        // requirePostParams(array('json'));

        // $jsonRaw = $_POST['json'];

        // $json = json_decode($jsonRaw);
        // if (!$json) {
        //     errorBadParam('json');
        // }

        // file_put_contents('configs/' . $channel . '.json', $jsonRaw, LOCK_EX);



    } else if ($q[1] == 'channel' && $q[2] == 'update' && $q[3] == 'boir') {

        channelUpdateBoir($q);

    } else {
        tellError("bad method", 400);
    }



} else {
    tellError("bad api version", 400);
}




/***************
 * API METHODS
 **************/

function channelUpdateConfig($query) {
    authOrDie($query, true);
    $channel = channelOrDie($query);
    //requirePostParams(array('json'));

    // $jsonRaw = $_POST['json'];

    // die($jsonRaw);

    $json = json_decode(file_get_contents("php://input"));//json_decode($jsonRaw);
    if ($json === false) {
        tellBadParam('json');
    }

    file_put_contents('configs/' . $channel . '.json', json_encode($json), LOCK_EX);

    tellSuccess();
}


function channelUpdateBoir($query) {
    authOrDie($query, true);
    $channel = channelOrDie($query);

    $json = json_decode(file_get_contents("php://input"));
    if ($json === false) {
        tellBadParam('json');
    }

    file_put_contents('configs/boir/' . $channel . '.json', json_encode($json), LOCK_EX);

    tellSuccess();
}




/******************
 * AUTHENTICATION
 *****************/

function authOrDie($query, $checkChannel) {
    if (!checkAuthFromRaw($query, $checkChannel)) {
        tellError("bad auth", 403);
    }
}

function checkAuthFromRaw($query, $checkChannel) {
    $authArr = getAuthArray($query);
    if (count($authArr) != 3) return false;

    $a = $authArr[1];
    $cn = $authArr[2];

    $chan = false;

    if ($checkChannel) {
        $chan = channelOrDie($query);
    }

    return checkAuth($a, $cn, $chan);
}

function checkAuth($auth, $cnonce, $channel) {
    global $TEMP_AUTH_KEY;
    return $auth == $TEMP_AUTH_KEY;

    // check that the auth token and cnonce are legit
    if ($channel !== false) {
        // do some check to see if this client has access for this channel
    }
}




/********************
 * PARAMETER CHECKS
 *******************/

// returns the channel from a query, or terminates the script if it's unobtainable
function channelOrDie($query) {
    $chan = getChannelFromQuery($query);
    if ($chan === false) {
        tellError("missing channel", 400);
    }
    return $chan;
}

// pulls a channel from a query array
function getChannelFromQuery($query) {
    //if (count($query) < 3) return false;
    $authArr = getAuthArray($query);
    $chan = $authArr[0];

    // this check is crucial!!! huge server vulnerability if this check is removed
    if (!validateChannel($chan)) return false;

    return $chan;
}

function getAuthArray($query) {
    return explode('$', $query[count($query) - 1]);
}

// die if any of a list of POST params are missing
function requirePostParams($params) {
    for ($i = 0; $i < count($params); $i++) {
        if (!isset($_POST[$params[$i]]) || $_POST[$params[$i]] == '') {
            tellError("missing params", 400);
        }
    }
}




/**********************
 * RESPONSE TO CLIENT
 *********************/

function tellSuccess($response=array()) {
    tellError("ok", 200, $response);
}

function tellBadParam($param) {
    tellError("bad param: " . $param, 400);
}

function tellError($msg, $code=400, $response=array()) {
    http_response_code($code);
    $response["status"] = $msg;
    respond($response);
}

function respond($response) {
    header('Content-type: application/json');
    die(json_encode($response));
}




/*function getNonce() {
    $id = Identify Request //(either by username, session, or something)
    $nonce = hash('sha512', makeRandomString());
    storeNonce($id, $nonce);
    return $nonce to client;
}

verifyNonce($data, $cnonce, $hash) {
    $id = Identify Request
    $nonce = getNonce($id);  // Fetch the nonce from the last request
    removeNonce($id, $nonce); //Remove the nonce from being used again!
    $testHash = hash('sha512',$nonce . $cnonce . $data);
    return $testHash == $hash;
}

function makeRandomString($bits = 256) {
    $bytes = ceil($bits / 8);
    $return = '';
    for ($i = 0; $i < $bytes; $i++) {
        $return .= chr(mt_rand(0, 255));
    }
    return $return;
}*/

?>