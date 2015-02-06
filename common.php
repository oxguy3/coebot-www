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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/common.css">
    <?php
    for ($i = 0; $i < count($extraCss); $i++) {
    	echo '<link href="' . $extraCss[$i] . '" rel="stylesheet">' . "\n";
    }

    if (isCookieTrue("birthdayMode")) {
        echo '<link href="/css/birthday.css" rel="stylesheet">'."\n";
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
    <script src="/js/common.js"></script>
    <?php
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

function printNav($activeTab="") {
	global $SITE_TITLE;
    $activeStr = ' class="active"';
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
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
        <li<?php if($activeTab=="faq") echo $activeStr; ?>><a href="/faq">FAQ</a></li>
        <?php if(isCookieTrue("cookiemanShortcut")) {?>
            <li<?php if($activeTab=="cookieman") echo $activeStr; ?>><a href="/cookieman" title="Cookie Manager"><i class="fa fa-cogs"></i><span class="visible-xs-inline"> Cookie Manager</span></a></li>
        <?php } ?>
      </ul>
<!--       <form class="navbar-form navbar-right">
        <input type="text" class="form-control" placeholder="Search...">
      </form> -->
    </div>
  </div>
</nav>
<?php
}

function printFooter() {
?>
<footer class="footer-normal text-muted">
    <span class="footer-section">
        Site by <a class="footer-link" href="http://haydenschiff.me" target="_blank" title="Hayden Schiff">oxguy3</a> 
        <a href="https://github.com/oxguy3/coebot-www" class="btn btn-xs btn-default footer-srccodelink"
        data-toggle="tooltip" title="Source on GitHub" target="_blank">
            <i class="fa fa-github"></i>
        </a> 
    </span>
    <span class="footer-section">
        Bot by <a class="footer-link" href="https://twitter.com/endsgamer" target="_blank">endsgamer</a>
        <a href="https://bitbucket.org/tucker_gardner/coebot" class="btn btn-xs btn-default footer-srccodelink"
        data-toggle="tooltip" title="Source on Bitbucket" target="_blank">
            <i class="fa fa-bitbucket"></i>
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
	return "/channel/" . $chan . "/";
}

/**
 * Verifies that a string is a valid Twitch username
 */
function validateChannel($channel) {
	return preg_match('/^[A-Z0-9\-_]{4,25}$/i', $channel);
}

function checkCookieValue($key, $val) {
    return isset($_COOKIE[$key]) && $_COOKIE[$key]==$val;
}

function isCookieTrue($key) {
    return checkCookieValue($key, "true");
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

    $sql = 'SELECT channel, displayName, isActive, youtube, twitter, shouldShowOffensiveWords, shouldShowBoir FROM ' . DB_PREF . 'channels WHERE isActive = 1';


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
 * Creates a row for a new channel in the database
 *
 * Returns true if successful, or false if an error occurred
 */
function dbCreateChannel($channel, $displayName, $botChannel="coebot") {
    global $mysqli;
    initMysqli();

    $sql = 'INSERT INTO ' . DB_PREF . 'channels (channel, displayName, botChannel) VALUES (?, ?, ?)';
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $botChannel = strtolower($botChannel);
    $stmt->bind_param('sss', $channel, $displayName, $botChannel);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
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