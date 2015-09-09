<?php

require_once('common.php');

requireLoggedIn();

$action = false;
$httpMethod = false;

if (isset($_GET['a'])) {
  $action = $_GET['a'];
  $httpMethod = "GET";

} else if (isset($_POST['a'])) {
  $action = $_POST['a'];
  $httpMethod = "POST";

} else {
  throw400("Your request did not specify an action to perform.");
}



if ($action == "join") {

  $channel = getChannelWithAuthOrDie($USER_ACCESS_LEVEL_OWNER);
  $bot = getParamOrDie('bot');

  $channelCoebotData = dbGetChannel($channel);

  if ($channelCoebotData['isActive'] == true) {
    throw400("That channel is already joined by " . $channelCoebotData['botChannel']
      . "! Only one instance of CoeBot can be in a channel at a time.");
  }

  $botSession = BotSession::getBotSessionCurrentUser($bot, $channel);
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



} else if ($action == "part") {

  $channel = getChannelWithAuthOrDie($USER_ACCESS_LEVEL_OWNER);

  $channelCoebotData = dbGetChannel($channel);

  if ($channelCoebotData['isActive'] == false) {
    respondMessage("Channel was already parted");
  }
  $bot = $channelCoebotData['botChannel'];

  $botSession = BotSession::getBotSessionCurrentUser($bot, $channel);
  $botSession->doPart();
  $botSession->finalize();

  die("success");



} else if ($action == "setCommand") {

  $channel = getChannelWithAuthOrDie($USER_ACCESS_LEVEL_MOD);
  $name = getParamOrDie('name');
  $oldName = getParam('oldName');
  $response = getParamOrDie('response');
  $restriction = getParamOrDie('restriction');

  if ($restriction != "everyone"
      && $restriction != "regular"
      && $restriction != "mod"
      && $restriction != "owner") {
    respondMessage("invalid parameter (restriction)");
  }

  $channelCoebotData = dbGetChannel($channel);

  $bot = $channelCoebotData['botChannel'];

  $botSession = BotSession::getBotSessionCurrentUser($bot, $channel);

  if ($oldName != NULL && $oldName != "" && $oldName != $name) {
    $botSession->doCommandRename($oldName, $name);
  }

  $botSession->doCommandAdd($name, $response);
  $botSession->doCommandRestrict($name, $restriction);

  $botSession->finalize();

  die("success");



} else if ($action == "delReqsong") {

  $channel = getChannelWithAuthOrDie($USER_ACCESS_LEVEL_OWNER);
  $id = getParamOrDie('id');

  if (!is_numeric($id)) {
    respondMessage("invalid parameter (id)");
  }

  if (!dbDeleteReqsong($channel, $id)) {
    respondMessage("database error");
  }

  $response = array('status' => 'success');
  $response['reqsongs'] = getReqsongsOrDie($channel);
  respondJson($response);



} else if ($action == "listReqsong") {

  $channel = getChannelWithAuthOrDie($USER_ACCESS_LEVEL_OWNER);

  $response = array('status' => 'success');
  $response['reqsongs'] = getReqsongsOrDie($channel);
  respondJson($response);



} else {
  respondMessage("bad action");
}





function getReqsongsOrDie($channel) {

  $reqsongs = dbListReqsongs($channel);

  if ($reqsongs === NULL) {
    respondMessage("database error");
    return NULL;
  } else {
    return $reqsongs;
  }
}


function respondJson($response) {
  header('Content-type: application/json');
  die(json_encode($response));
}

function respondMessage($message) {
  $response = array('status' => $message);
  respondJson($response);
}






function getChannelWithAuthOrDie($userAccessLevel, $useJson=false) {

  $channel = getParam('channel');

  if (!validateChannel($channel)) {
    respondMessage("invalid parameter (channel)");
    return NULL;
  }

  if (getUserAccessLevel($channel) < $userAccessLevel) {
    respondMessage("not authorized");
    return NULL;
  }

  return $channel;
}


function getParam($name) {
  global $httpMethod;

  if ($httpMethod == "GET") {

    if (!isset($_GET[$name])) {
      return NULL;
    }

    return $_GET[$name];

  } else if ($httpMethod == "POST") {

    if (!isset($_POST[$name])) {
      return NULL;
    }

    return $_POST[$name];
  }

  return NULL;
}

function getParamOrDie($name) {
  $param = getParam($name);

  if ($param === NULL) {
    respondMessage("missing parameter");
  }

  return $param;
}

?>
