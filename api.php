<?php

require_once("common.php");

function getNonce() {
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
}

?>