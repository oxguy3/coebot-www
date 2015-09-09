<?php

require_once("common.php");

// if (!isset($_GET['code'])) {
//   throw404();
// }

if (isset($_GET["logout"])) {
  header('Location: /');
  $_SESSION['showLoggedOut'] = true;
  logUserOut();
  die('logged out');
}

if (!isset($_GET['code'])) {
  throw400();
}

$code = $_GET['code'];

$loginResult = twitchGetAccessToken($code);

if (!$loginResult) {
  die("Twitch is down, or authentication failed for some other reason.");
}

$twitchAccessToken = $loginResult->access_token;

$userData = twitchGetUser($twitchAccessToken);

if (!$userData) {
  die("Twitch is down, or user retrieval failed for some other reason.");
}

$uid = dbSetUser($userData->name, true, $twitchAccessToken);

if ($uid === false) {
  throw500("Database error, contact site administrator");
}

logUserIn($userData->name, $uid);


header('Location: ' . getUrlToChannel($_SESSION['channel']));
$_SESSION['showLoggedIn'] = true;
die('logged in');

/*
printHead("Logged in");
printNav();
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Welcome <?php echo $_SESSION['channel']; ?>!</h2>
      <p class="lead">This is still super buggy and new and doesn't do much yet. I'm working on it!!</p>
    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
*/
?>
