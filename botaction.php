<?php

require_once('common.php');
require_once('Pusher.php');

if (!isLoggedIn()) {
  die("error: not logged in");
}

if (!isset($_GET['a'])) {
  throw404();
}

if ($_GET['a'] == "join" && isset($_GET['channel']) && isset($_GET['bot'])) {

  $channel = $_GET['channel'];
  $bot = $_GET['bot'];

  if (!validateChannel($channel) || !validateChannel($bot)) die("error: bad param");

  if (getUserAccessLevel($channel) >= $USER_ACCESS_LEVEL_OWNER) {

    $channelCoebotData = dbGetChannel($channel);

    if ($channelCoebotData['isActive'] == true) die("error: already joined");

    $botSession = BotSession::getBotSession($bot, $channel, $_SESSION['channel']);
    $botSession->doJoin();
    $botSession->finalize();

    header('refresh: 3;url=' . getUrlToChannel($channel));
    printHead("Processing...");
    printNav('', true);

    ?>

    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <h3><span class="loading-generic"><i></i> Join request sent to bot...</span></h3>
          <p class="lead"><a href="<?php echo getUrlToChannel($channel); ?>">If you are not redirected after 3 seconds, click here.</a></p>
        </div>
      </div>
    </div>

    <?php

    printFooter();
    printFoot();
    die();

  } else {
    die("error: unauthorized");
  }



} else if ($_GET['a'] == "part" && isset($_GET['channel'])) {

  $channel = $_GET['channel'];

  if (!validateChannel($channel)) die("error: bad param");

  if (getUserAccessLevel($channel) >= $USER_ACCESS_LEVEL_OWNER) {

    $channelCoebotData = dbGetChannel($channel);

    if ($channelCoebotData['isActive'] == false) die("error: already left");
    $bot = $channelCoebotData['botChannel'];

    $botSession = BotSession::getBotSession($bot, $channel, $_SESSION['channel']);
    $botSession->doPart();
    $botSession->finalize();

    die("success");

  } else {
    die("error: unauthorized");
  }



} else {
  die("error: bad action");
}

?>