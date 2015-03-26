<?php

require_once('common.php');

if (!isset($_GET['channel'])||!isset($_GET['command'])) die("lern2parameters");

$channel = $_GET['channel'];
$command = $_GET['command'];

if (!validateChannel($channel) || preg_match('/^[A-Z0-9\-_]$/i', $command)) die('git gud skrub');

$json_data = file_get_contents('configs/' . $channel . '.json');
$data = json_decode($json_data);

$cmdObj = (object)array("count" => "?");
foreach($data->commands as $struct) {
    if ($command == $struct->key) {
        $cmdObj = $struct;
        break;
    }
}

$ct = $cmdObj->count;

$isUpdated = false;
if (isset($_COOKIE['lastcmdct_' . $command]) && $_COOKIE['lastcmdct_' . $command] != $ct) {
	$isUpdated = true;
}

$devMode = isset($_GET['dev']);

setcookie("lastcmdct_" . $command, $ct);

header('Content-type: text/html');
header('refresh: 5');
?>
<html>
<head>
	<style>
	body {
		font-weight: bold;
		color:#a00;
		text-shadow: 2px 2px 10px black;
		text-align:center;
	}
	#guude {
		position: fixed;
		left: 50%;
		height: 100px;
		width: 87px;
		margin-left: -43px;
		display: none;
	}

	body.is-update #guude {
		display: inline;
		opacity: 0;
		-webkit-animation: fadetoggle 3s 1; animation: fadetoggle 3s 1;
	}

	#number {
		font-family: Chiller, serif;
		font-size: 72px;
		line-height: 90%;
		color:#a00;
	}

	body.is-update #number {
		-webkit-animation: flashwhite 3s 1; animation: flashwhite 3s 1;
	}

	#label {
		font-family: sans-serif;
		font-size: 24px;
		line-height: 50%;
		color:#a00;
	}
	#label:after {
		content: 'deaths';
	}


	@keyframes flashwhite {
    0%   {color: #a00;}
    40%  {color: #fff;}
    100% {color: #a00;}
  }

	@-webkit-keyframes flashwhite {
    0%   {color: #a00;}
    40%  {color: #fff;}
    100% {color: #a00;}
  }


	@keyframes fadetoggle {
    0%   {opacity: 0;}
    40%  {opacity: 1;}
    100% {opacity: 0;}
  }

	@-webkit-keyframes fadetoggle {
    0%   {opacity: 0;}
    40%  {opacity: 1;}
    100% {opacity: 0;}
  }
	</style>
</head>
<body<?php if($isUpdated) { echo " class=\"is-update\""; } ?>>
	<img id="guude" src="/img/guude.png">
	<div id="normalText">
		<div id="number" class="bigtxt"> <?php echo $ct; ?></div>
		<div id="label"></div>
	</div>
</body>
</html>
