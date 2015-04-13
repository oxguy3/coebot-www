<?php

require_once('common.php');

if (!isset($_GET['channel'])||!isset($_GET['var'])) die("Your URL is missing a required parameter.");

$channel = $_GET['channel'];
$varName = $_GET['var'];
$refresh = (isset($_GET['refresh'])) ? $_GET['refresh'] : "5000";

if (!validateChannel($channel) 
	|| !preg_match('/^[A-Z0-9\-_]{1,64}$/i', $varName)
	|| !preg_match('/^[0-9]+$/i', $refresh)) {
	die('One of the parameters in your URL is invalid.');
}

function printOptionalParam($param, $format="%s") {
	if (isset($_GET[$param])) {
		printf($format, htmlspecialchars($_GET[$param])); 
	}
}


// $varRow = dbGetVar($channel, $varName);
// $ct = ($varRow && isset($varRow['value'])) ? $varRow['value'] : "?";

// if (isset($_GET['format']) && $_GET['format'] == "text") { 
// 	header('Content-type: text/plain');
// 	die($ct);
// }

?>
<!doctype html>
<html id="html" class="<?php printOptionalParam('themes'); ?>">
<head>
	<?php
	if (preg_match('/^.*\bblood\b.*$/i', $_GET['themes'])) {
		echo "<link href='http://fonts.googleapis.com/css?family=Trade+Winds' rel='stylesheet' type='text/css'>";
	}
	?>
	<?php
	if (preg_match('/^.*\b(plumbers|arcade)\b.*$/i', $_GET['themes'])) {
		echo "<link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>";
	}
	?>
	<style>

	#value {
		<?php printOptionalParam('valueFont', 'font-family: "%s", sans-serif ! important;'); ?>
		<?php printOptionalParam('valueColor', 'color: %s ! important;'); ?>
	}

	#label {
		<?php printOptionalParam('labelFont', 'font-family: "%s", sans-serif ! important;'); ?>
		<?php printOptionalParam('labelColor', 'color: %s ! important;'); ?>
	}




	/******************
	 * THEME: BASIC
	 ******************/
	html.basic * {
		font-weight: bold;
		color: white;
		text-shadow: 2px 2px 10px black;
		text-align: center;
		font-family: sans-serif;
	}

	html.basic #value {
		font-size: 72px;
	}

	html.basic #value:empty:after {
		content: '...';
	}

	html.basic #label {
		font-size: 24px;
		line-height: 50%;
	}





	/******************
	 * THEME: GUUDE
	 ******************/
	html.guude #guude {
		position: fixed;
		left: 50%;
		height: 100px;
		width: 87px;
		margin-left: -43px;
		display: none;
	}

	html.guude .updated #guude {
		display: inline;
		opacity: 0;
		animation: blood_fadeInOut 3s 1 ease-out;
		-webkit-animation: blood_fadeInOut 3s 1 ease-out;
	}





	/******************
	 * THEME: BLOOD
	 ******************/
	html.blood * {
		font-weight: bold;
		color:#a00;
		text-shadow: 2px 2px 10px black;
		text-align:center;
	}

	html.blood #value {
		font-family: Chiller, 'Trade Winds', serif;
		font-size: 72px;
		line-height: 90%;
	}

	html.blood #value:empty:after {
		content: '...';
	}

	html.blood .updated #value {
		animation: blood_flashWhite 3s 1 ease-out;
		-webkit-animation: blood_flashWhite 3s 1 ease-out;
	}

	html.blood #label {
		font-family: sans-serif;
		font-size: 24px;
		line-height: 50%;
	}


	@keyframes blood_flashWhite {
    0%   {color: #a00;}
    50%  {color: #fff;}
    100% {color: #a00;}
  }

	@-webkit-keyframes blood_flashWhite {
    0%   {color: #a00;}
    50%  {color: #fff;}
    100% {color: #a00;}
  }

	@keyframes blood_fadeInOut {
    0%   {opacity: 0;}
    50%  {opacity: 1;}
    100% {opacity: 0;}
  }

	@-webkit-keyframes blood_fadeInOut {
    0%   {opacity: 0;}
    50%  {opacity: 1;}
    100% {opacity: 0;}
  }





	/******************
	 * THEME: ARCADE
	 ******************/
	html.arcade * {
		font-weight: bold;
		color: black;
		text-align:center;
		font-family: 'Press Start 2P', monospace;
	}

	html.arcade #value {
		font-size: 72px;
	}

	html.arcade #value:empty:after {
		content: '...';
	}

	html.arcade #label {
		font-size: 24px;
	}





	/******************
	 * THEME: EXZENTIA_BLOOD
	 ******************/
	html.exzentia_blood body.updated {
		background: url(http://i.imgur.com/AzMrQg7.gif) no-repeat fixed center top;
	}





	/******************
	 * THEME: PLUMBERS
	 ******************/
	html.plumbers * {
		font-weight: bold;
		color: #e75a10;
		text-align:center;
		font-family: 'Press Start 2P', monospace;
	}

	html.plumbers #value {
		font-size: 72px;
		text-shadow: 9px 9px #000000;
	}

	html.plumbers #value:empty:after {
		content: '?';
	}

	html.plumbers #label {
		font-size: 24px;
		text-shadow: 3px 3px #000000;
		line-height: 150%;
	}


	html.plumbers #mario {
		position: fixed;
		left: 50%;
		height: 100px;
		width: 100px;
		margin-left: -50px;
		display: none;
	}

	html.plumbers .updated #mario {
		display: inline;
		opacity:0;
		animation: plumbers_marioJump 1.2s 1 linear;
		-webkit-animation: plumbers_marioJump 1.2s 1 linear;
	}

	@keyframes plumbers_marioJump {
    0%   {top: 60px; opacity:0;}
    50%  {top: 0px; opacity:1;}
    100% {top: 60px; opacity:0;}
  }

	@-webkit-keyframes plumbers_marioJump {
    0%   {top: 60px; opacity:0;}
    50%  {top: 0px; opacity:1;}
    100% {top: 60px; opacity:0;}
  }
	</style>
</head>
<body>
	<div id="value"></div>
	<div id="label"><?php printOptionalParam('label'); ?></div>

<script src="/js/jquery.min.js"></script>
<script>

var channel = '<?php echo $channel; ?>';
var varName = '<?php echo $varName; ?>';
var refresh = <?php echo $refresh; ?>;

var currValue = null;

function updateNumber() {
	$.ajax({
	  url: "/api/v1/vars/get/" + varName + "/" + channel,
	  method: "GET",
	  dataType: "json",
	  cache: false
	})
	  .done(function(json) {
	  	var txt = json.value;

	  	if (currValue == null || currValue == txt) $('body').removeClass('updated');
	  	else $('body').addClass('updated');

	  	currValue = txt;
	    $("#value").text(currValue);
	  });
}

setInterval(updateNumber, refresh);
updateNumber();

if ($('#html').hasClass("guude")) {
	$('body').prepend('<img id="guude" src="/img/guude.png">');
}

if ($('#html').hasClass("plumbers")) {
	$('body').prepend('<img id="mario" src="/img/mario.png">');
}

</script>
</body>
</html>
