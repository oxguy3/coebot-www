<?php

require_once("safeconfig.php");

$SITE_TITLE = "CoeBot";
$mysqli = false;


// session_start();
// date_default_timezone_set($siteTimezone);


// DEBUG OPTIONS
// REMOVE BEFORE GOING LIVE
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();


function printHead($pageTitle=false, $extraCss=array(), $extraJs=array(), $extraHeadCode="") {
	global $SITE_TITLE;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php 

    echo $SITE_TITLE;
    if ($pageTitle) { 
      echo " &bull; " . $pageTitle;
    } 

    ?></title>

    <link rel="shortcut icon" href="/favicon.ico">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/cyborg.min.css">
    <link rel="stylesheet" href="/css/messenger.css">
    <link rel="stylesheet" href="/css/messenger-theme-flat.css">
    <link rel="stylesheet" href="/css/common.css">
    <?php
    for ($i = 0; $i < count($extraCss); $i++) {
    	echo '<link href="' . $extraCss[$i] . '" rel="stylesheet">' . "\n    ";
    }

    if (isCookieTrue("birthdayMode")) {
        echo '<link href="/css/birthday.css" rel="stylesheet">'."\n";
    }

    if (isCookieTrue("exzentiaShareMode")) {
        echo '<link href="/css/exzentiamode.css" rel="stylesheet">'."\n";
    }

    if (isCookieTrue("oxSpamMode")) {
        echo '<link href="/css/oxspammode.css" rel="stylesheet">'."\n";
    }

    echo $extraHeadCode;
    ?>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
    
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/livestamp.min.js"></script>
    <script src="/js/humanize.min.js"></script>
    <script src="/js/jquery.linkify.min.js"></script>
    <script src="/js/messenger.min.js"></script>
    <script src="/js/messenger-theme-flat.js"></script>
    <script src="/js/common.js"></script>
    <?php

    if (isset($_SESSION['showLoggedOut'])) { 
        unset($_SESSION['showLoggedOut']);
        ?>
        <script>
        Messenger().post({
          message: 'You have been logged out!',
          type: 'success'
        });
        </script>
        <?php
    }

    if (isset($_SESSION['showLoggedIn'])) { 
        unset($_SESSION['showLoggedIn']);
        ?>
        <script>
        Messenger().post({
          message: 'Welcome <?php echo $_SESSION['channel']; ?>!',
          type: 'success'
        });
        </script>
        <?php
    }

    for ($i = 0; $i < count($extraJs); $i++) {
        echo '<script src="' . $extraJs[$i] . '"></script>' . "\n";
    }
    ?>

  	<noscript>
      <h1>This site requires JavaScript!</h1>
      <h2 class="text-muted">Please enable JavaScript in your web browser to view this site 
    </noscript>
<?php
}

function printNav($activeTab="", $isFluid=false) {
	global $SITE_TITLE;
    $activeStr = ' class="active"';
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container<?php if ($isFluid){ echo "-fluid";}?>">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">
        <span class="pull-left">
          <!-- <img alt="Coebot" src="/img/coebot-icon.png"> -->
          <?php echo $SITE_TITLE; ?><sub class="text-muted"> beta</sub>
        </span>
      </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-left">
        <li<?php if($activeTab=="channels") echo $activeStr; ?>><a href="/channels">Channels</a></li>
        <li<?php if($activeTab=="commands") echo $activeStr; ?>><a href="/commands">Commands</a></li>
        <li<?php if($activeTab=="help") echo $activeStr; ?>><a href="/help">Help</a></li>
        <?php if(isCookieTrue("cookiemanShortcut")) {?>
            <li<?php if($activeTab=="cookieman") echo $activeStr; ?>><a href="/cookieman" title="Cookie Manager" id="cookieMonsterLink"><img src="/img/cookiemonster.png" height="21" width="24"><span class="visible-xs-inline"> Cookie Manager</span></a></li>
        <?php } ?>
      </ul>
      <?php if(isLoggedIn()) {?>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="icon-user"></i> <?php echo $_SESSION['channel']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo getUrlToChannel($_SESSION['channel']); ?>">Channel</a></li>
                <li><a href="/settings">Settings</a></li>
                <li><a href="/logout">Log out</a></li>
              </ul>
            </li>
          </ul>
      <?php } else { ?>
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="<?php echo getSignInUrl() ?>">Log in <i class="icon-login"></i></a>
            </li>
          </ul>
      <?php } ?>
    </div>
  </div>
</nav>
<?php
}

function getSignInUrl() {
    return "https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&amp;client_id=" . TWITCH_CLIENT_ID . "&amp;redirect_uri=" . TWITCH_REDIRECT_URI . "&amp;scope=". TWITCH_REQUIRED_SCOPES;
}

function printFooter() {
?>
<footer class="footer-normal text-muted">
    <span class="footer-section">
        Site by <a class="footer-link" href="http://haydenschiff.me" target="_blank" title="Hayden Schiff">oxguy3</a> 
        <a href="https://github.com/oxguy3/coebot-www" class="btn btn-xs btn-default footer-srccodelink"
        data-toggle="tooltip" title="Source on GitHub" target="_blank">
            <i class="icon-github-circled"></i>
        </a> 
    </span>
    <span class="footer-section">
        Bot by <a class="footer-link" href="https://twitter.com/endsgamer" target="_blank">endsgamer</a>
        <a href="https://bitbucket.org/tucker_gardner/coebot" class="btn btn-xs btn-default footer-srccodelink"
        data-toggle="tooltip" title="Source on Bitbucket" target="_blank">
            <i class="icon-bitbucket"></i>
        </a> 
    </span>
    <script>$('.footer-srccodelink').tooltip()</script>
</footer>
<?php
}

function printFoot() {
?>
  </body>
</html>
<?php
}


function getUrlToChannel($chan) {
	return "/c/" . $chan . "/";
}

/**
 * Verifies that a string is a valid Twitch username
 */
function validateChannel($channel) {
    return preg_match('/^[A-Z0-9\-_]{4,25}$/i', $channel);
}

function validateYoutubeUsername($username) {
    return preg_match('/^[A-Z0-9\-_\'\.]{6,20}$/i', $username);
}

function validateTwitterUsername($username) {
    return preg_match('/^[A-Z0-9_]{1,15}$/i', $username);
}

function checkCookieValue($key, $val) {
    return isset($_COOKIE[$key]) && $_COOKIE[$key]==$val;
}

function isCookieTrue($key) {
    return checkCookieValue($key, "true");
}

// taken from http://stackoverflow.com/a/853870/992504
function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

function throw404() {
  header("HTTP/1.0 404 Not Found");
  $httpStatusCode = 404;
  include_once("error.php");
  die();
}

// lovingly stolen from http://hayageek.com/php-curl-post-get/#curl-post
function httpPost($url,$params)
{
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
 
}





/*******************************
 * DATABASE
 *******************************/

function initMysqli() {
    global $mysqli;

    if ($mysqli === false) {

        $mysqli = new mysqli(DB_SERV, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            $mysqli = false;
            die("Database connection failed");
        }
    }
}

/**
 * Returns array of channels marked active in the database, or NULL if an error occurred
 */
function dbListChannels() {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT channel, displayName, isActive, youtube, twitter, shouldShowOffensiveWords, shouldShowBoir FROM ' . DB_PREF . 'channels WHERE isActive = 1 ORDER BY channel ASC';


    $result = $mysqli->query($sql);
    if ($result === false) {
        return NULL;

    } else {

        $channels = array();
        while ($row = $result->fetch_assoc()) {
            $row['isActive'] = ($row['isActive'] == 1) ? true : false;
            $row['shouldShowOffensiveWords'] = ($row['shouldShowOffensiveWords'] == 1) ? true : false;
            $row['shouldShowBoir'] = ($row['shouldShowBoir'] == 1) ? true : false;
            $channels[] = $row;
        }
        return $channels;
    }
}

/**
 * Returns the row for a given channel, or false if an error occurred, or NULL if channel doesn't exist
 */
function dbGetChannel($channel) {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT displayName, isActive, botChannel, youtube, twitter, shouldShowOffensiveWords, shouldShowBoir FROM ' . DB_PREF . 'channels WHERE channel = ?';


    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param('s', $channel);
    $stmt->bind_result($displayName, $isActive, $botChannel, $youtube, $twitter, $shouldShowOffensiveWords, $shouldShowBoir);


    $success = $stmt->execute();

    if (!$success) {
        $stmt->close();
        return false;
    }
    if ($stmt->fetch() !== true) {
        $stmt->close();
        return NULL;
    }

    //$stmt->fetch();
    $stmt->close();

    $row = array(
        "channel" => $channel,
        "displayName" => $displayName,
        "isActive" => $isActive,
        "botChannel" => $botChannel,
        "youtube" => $youtube,
        "twitter" => $twitter,
        "shouldShowOffensiveWords" => $shouldShowOffensiveWords,
        "shouldShowBoir" => $shouldShowBoir
    );

    $row['isActive'] = ($row['isActive'] == 1) ? true : false;
    $row['shouldShowOffensiveWords'] = ($row['shouldShowOffensiveWords'] == 1) ? true : false;
    $row['shouldShowBoir'] = ($row['shouldShowBoir'] == 1) ? true : false;

    return $row;
}

/**
 * Creates or updates a row for a new channel in the database
 *
 * Returns true if successful, or false if an error occurred
 */
function dbSetChannel($channel, $displayName, $isActive, $botChannel="coebot") {
    global $mysqli;
    initMysqli();

    if ($isActive === true) $isActive = 1;
    if ($isActive === false) $isActive = 0;

    $sql = 'INSERT INTO ' . DB_PREF . 'channels (channel, displayName, isActive, botChannel) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE displayName=?, isActive=?, botChannel=?';
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $botChannel = strtolower($botChannel);
    $stmt->bind_param('ssissis', $channel, $displayName, $isActive, $botChannel, $displayName, $isActive, $botChannel);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

/**
 * Updates misc data about a channel
 *
 * Returns true if successful, or false if an error occurred
 */
function dbUpdateChannel($channel, $youtube, $twitter, $shouldShowOffensiveWords, $shouldShowBoir) {
    global $mysqli;
    initMysqli();

    $sql = 'UPDATE ' . DB_PREF . 'channels SET youtube=?, twitter=?, shouldShowOffensiveWords=?, shouldShowBoir=? WHERE channel=?';
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param('ssiis', $youtube, $twitter, $shouldShowOffensiveWords, $shouldShowBoir, $channel);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

/**
 * Updates whether or not BOIR is shown for a given channel
 *
 * Returns true if successful, or false if an error occurred
 */
function dbSetChannelShowBoir($channel, $shouldShowBoir) {
    global $mysqli;
    initMysqli();

    if ($shouldShowBoir === true) $shouldShowBoir = 1;
    if ($shouldShowBoir === false) $shouldShowBoir = 0;

    $sql = 'UPDATE ' . DB_PREF . 'channels SET shouldShowBoir=? WHERE channel=?';
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param('ss', $shouldShowBoir, $channel);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

/**
 * Returns the number of channels currently using CoeBot
 */
function dbCountChannels() {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT COUNT(*) FROM ' . DB_PREF . 'channels WHERE isActive = 1';


    $result = $mysqli->query($sql);
    if ($result === false) {
        return NULL;

    } else {
        $row = $result->fetch_row();
        return $row[0];
    }
}

/**
 * Returns the row for a given bot, or false if an error occurred, or NULL if channel doesn't exist
 */
function dbGetBotById($botId) {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT id, channel, apiKey, isActive, pusherAppId, pusherAppKey, pusherAppSecret, accessType FROM ' . DB_PREF . 'bots WHERE id = ?';


    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param('i', $botId);

    return dbExecuteGetBot($stmt);
}

/**
 * Returns the row for a given bot, or false if an error occurred, or NULL if channel doesn't exist
 */
function dbGetBotByChannel($channel) {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT id, channel, apiKey, isActive, pusherAppId, pusherAppKey, pusherAppSecret, accessType FROM ' . DB_PREF . 'bots WHERE channel = ?';


    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param('s', $channel);

    return dbExecuteGetBot($stmt);
}

function dbExecuteGetBot($stmt) {

    $stmt->bind_result($id, $channel, $apiKey, $isActive, $pusherAppId, $pusherAppKey, $pusherAppSecret, $accessType);

    $success = $stmt->execute();

    if (!$success) {
        $stmt->close();
        return false;
    }
    if ($stmt->fetch() !== true) {
        $stmt->close();
        return NULL;
    }

    $stmt->close();

    $row = array(
        "id" => $id,
        "channel" => $channel,
        "apiKey" => $apiKey,
        "isActive" => $isActive,
        "pusherAppId" => $pusherAppId,
        "pusherAppKey" => $pusherAppKey,
        "pusherAppSecret" => $pusherAppSecret,
        "accessType" => $accessType
    );

    return $row;
}

/**
 * Checks if an API key for a bot is valid and active
 *
 * Returns true if bot is authenticated, or false if an error occurred
 */
function dbCheckBotAuth($botChannel, $apiKey) {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT apiKey FROM ' . DB_PREF . 'bots WHERE channel=? AND isActive=?';
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $isActive = 1;

    $stmt->bind_param('si', $botChannel, $isActive);
    $stmt->bind_result($savedKey);

    $success = $stmt->execute();
    $stmt->fetch();
    
    $stmt->close();

    return $success && $savedKey == $apiKey;
}

/**
 * Returns the number of channels currently using CoeBot
 */
function dbCountBots() {
    global $mysqli;
    initMysqli();

    $sql = 'SELECT COUNT(*) FROM ' . DB_PREF . 'bots WHERE isActive = 1';


    $result = $mysqli->query($sql);
    if ($result === false) {
        return NULL;

    } else {
        $row = $result->fetch_row();
        return $row[0];
    }
}

/**
 * Creates or updates a row for a new user in the database
 *
 * Returns row ID if successful, or false if an error occurred (should use === when checking return value)
 */
function dbSetUser($channel, $isActive, $twitchAccessToken) {
    global $mysqli;
    initMysqli();

    if ($isActive === true) $isActive = 1;
    if ($isActive === false) $isActive = 0;

    $lastLogin = time();

    $sql = 'INSERT INTO ' . DB_PREF . 'users (channel, isActive, twitchAccessToken, lastLogin) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE isActive=?, twitchAccessToken=?, lastLogin=?';
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param('sisiisi', $channel, $isActive, $twitchAccessToken, $lastLogin, $isActive, $twitchAccessToken, $lastLogin);

    $success = $stmt->execute();
    $stmt->close();

    return $mysqli->insert_id;
}





/*******************************
 * TWITCH API
 *******************************/

function twitchGetChannel($channel) {
    if (!validateChannel($channel)) {
        return false;
    }

    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, 'https://api.twitch.tv/kraken/channels/' . $channel);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $jsonData = json_decode(curl_exec($curlSession));
    curl_close($curlSession);

    return $jsonData;
}

function twitchGetAccessToken($code) {

    $paramsTwitch = array(
      'client_id' => TWITCH_CLIENT_ID,
      'client_secret' => TWITCH_CLIENT_SECRET,
      'grant_type' => "authorization_code",
      'redirect_uri' => TWITCH_REDIRECT_URI,
      'code' => $code
    );

    $loginResponse = httpPost("https://api.twitch.tv/kraken/oauth2/token", $paramsTwitch);

    return json_decode($loginResponse);
}

function twitchGetUser($accessToken) {

    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, 'https://api.twitch.tv/kraken/user');
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_HTTPHEADER, array(
        'Accept: application/vnd.twitchtv.v3+json',
        'Authorization: OAuth ' . $accessToken
    ));

    $jsonData = json_decode(curl_exec($curlSession));
    curl_close($curlSession);

    return $jsonData;
}





/*******************************
 * SESSIONS
 *******************************/

function logUserIn($channel, $uid) {
    if (!validateChannel($channel)) {
        return false;
    }
    $_SESSION['loggedIn'] = true;
    $_SESSION['channel'] = $channel;
    $_SESSION['uid'] = $uid;
    return true;
}

function logUserOut() {
    $_SESSION['loggedIn'] = false;
    unset($_SESSION['channel']);
    unset($_SESSION['uid']);

    // session_unset();
    // session_destroy();
    // session_start();
}

function isLoggedIn() {
    return isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
}

// N.B. should always match up with the same list in common.js!!!
$USER_ACCESS_LEVEL_NA = -1;
$USER_ACCESS_LEVEL_NONE = 0;
$USER_ACCESS_LEVEL_MOD = 2;
$USER_ACCESS_LEVEL_EDITOR = 3;
$USER_ACCESS_LEVEL_OWNER = 4;
$USER_ACCESS_LEVEL_ADMIN = 99;

// returns the logged in user's access level on a particular channel
function getUserAccessLevel($channel) {
    global $USER_ACCESS_LEVEL_NA, 
    $USER_ACCESS_LEVEL_NONE, 
    $USER_ACCESS_LEVEL_MOD, 
    $USER_ACCESS_LEVEL_EDITOR, 
    $USER_ACCESS_LEVEL_OWNER, 
    $USER_ACCESS_LEVEL_ADMIN, 
    $GLOBAL_ADMINS;

    if (!isLoggedIn()) {
        return $USER_ACCESS_LEVEL_NA;
    }

    if (in_array($_SESSION['channel'], $GLOBAL_ADMINS)) {
        return $USER_ACCESS_LEVEL_ADMIN;
    }

    if ($_SESSION['channel'] == $channel) {
        return $USER_ACCESS_LEVEL_OWNER;
    }

    // TODO check if editor or mod

    return $USER_ACCESS_LEVEL_NONE;
}







/*******************************
 * SHIMS
 *******************************/

// workaround for PHP versions prior to 5.4.0
// created by craig@craigfrancis.co.uk
// copied from http://php.net/manual/en/function.http-response-code.php#107261
if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL) {

        if ($code !== NULL) {

            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);

            $GLOBALS['http_response_code'] = $code;

        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

        }

        return $code;

    }
}



?>