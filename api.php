<?php

require_once("common.php");

define("AUTH_SHARED_SECRET", 2);
define("AUTH_USER_OAUTH", 3);


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

    } else if ($q[1] == 'channel' && $q[2] == 'list') {

        apiChannelList($q);

    } else if ($q[1] == 'channel' && ($q[2] == 'join' || $q[2] == 'part')) {

        apiChannelUpdate($q);

    } else if ($q[1] == 'channel' && $q[2] == 'update' && $q[3] == 'config') {

        apiChannelUpdateConfig($q);

    } else if ($q[1] == 'channel' && $q[2] == 'update' && $q[3] == 'boir') {

        apiChannelUpdateBoir($q);

    } else {
        tellError("bad method", 400);
    }



} else {
    tellError("bad api version", 400);
}




/***************
 * API METHODS
 **************/

function apiChannelList($query) {

    $channels = dbListChannels();

    if ($channels === NULL) {
        tellError("database error", 500);
    }

    $response = array('channels' => $channels);

    tellSuccess($response);
}


function apiChannelUpdate($query) {

    authOrDie($query, AUTH_SHARED_SECRET);
    $channel = channelOrDie($query);
    // requirePostParams(array("displayName"));

    // $displayName = $_POST["displayName"];
    $isActive = NULL;

    if ($query[2] == "join") {
        $isActive = true;
    } else if ($query[2] == "part") {
        $isActive = false;
    } else {
        tellError("unknown error", 500);
    }

    $twitchObj = twitchGetChannel($channel);

    if ($twitchObj === false || $twitchObj === NULL || !(property_exists($twitchObj, "display_name"))) {
        tellError("twitch api unavailable", 503);

    } else if (property_exists($twitchObj, "error")) {
        tellError("twitch api error: " . $twitchObj->status . " " . $twitchObj->error, 400);
    }

    $displayName = $twitchObj->display_name;

    $success = dbSetChannel($channel, $displayName, $isActive); // TODO eventually need to pass identifier of bot

    if ($success) {
        tellSuccess();
    } else {
        tellError("database error", 500);
    }
}


function apiChannelUpdateConfig($query) {

    authOrDie($query, AUTH_SHARED_SECRET);
    $channel = channelOrDie($query);

    $json = json_decode(file_get_contents("php://input"));
    if ($json === false) {
        tellBadParam('json');
    }

    file_put_contents('configs/' . $channel . '.json', json_encode($json), LOCK_EX);

    tellSuccess();
}


function apiChannelUpdateBoir($query) {

    authOrDie($query, AUTH_USER_OAUTH);
    $channel = channelOrDie($query);

    $json = json_decode(file_get_contents("php://input"));
    if ($json === false) {
        tellBadParam('json');
    }

    file_put_contents('configs/boir/' . $channel . '.json', json_encode($json), LOCK_EX);

    dbSetChannelShowBoir($channel, true);

    tellSuccess();
}




/******************
 * AUTHENTICATION
 *****************/

function authOrDie($query, $authMethod) {

    if (!checkAuthFromRaw($query, $authMethod)) {
        tellError("bad auth", 403);
    }
}

function checkAuthFromRaw($query, $authMethod) {
    $checkChannel = NULL;
    // channel is required for oauth check, so force $checkChannel
    if ($authMethod == AUTH_USER_OAUTH) {
        $checkChannel = true;
    }
    if ($authMethod == AUTH_SHARED_SECRET) {
        $checkChannel = false; // for now
    }


    $authArr = getAuthArray($query);
    if (count($authArr) != 3) return false;

    $a = $authArr[1];
    $botChannel = $authArr[2];

    $chan = false;

    if ($checkChannel) {
        $chan = channelOrDie($query);
    }

    if ($authMethod == AUTH_SHARED_SECRET) {
        return checkAuthApiKey($a, $botChannel, $chan);

    } else if ($authMethod == AUTH_USER_OAUTH) {
        return checkOauthToken($a, $chan);

    } else {
        return false;
    }
}

function checkAuthApiKey($auth, $botChannel, $channel) {
    //global $TEMP_AUTH_KEY;
    return dbCheckBotAuth($botChannel, $auth);

    // check that the auth token and cnonce are legit
    if ($channel !== false) {
        // TODO do some check to see if this client has access for this channel
    }
}

function checkOauthToken($auth, $channel) {
    if (!validateOauthToken($auth)) {
        return false;
    }

    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, 'https://api.twitch.tv/kraken/user?oauth_token=' . $auth);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $jsonData = json_decode(curl_exec($curlSession));
    curl_close($curlSession);

    return property_exists($jsonData, "name") && $channel == ($jsonData->name);
}

function validateOauthToken($token) {
    return preg_match('/^[A-Z0-9]*$/i', $token);
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
        $param = $params[$i];
        if (!isset($_POST[$param]) || $_POST[$param] == '') {
            tellBadParam($param);
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