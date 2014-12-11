<?php

$SITE_TITLE = "Coebot";


function printHead($pageTitle, $extraCss=array(), $extraJs=array(), $extraHeadCode="") {
	global $SITE_TITLE;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $SITE_TITLE . " &bull; " . $pageTitle; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/cyborg.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
    <?php
    for ($i = 0; $i < count($extraCss); $i++) {
    	echo '<link href="' . $extraCss[$i] . '" rel="stylesheet">' . "\n";
    }

    if ($_GET['birthday']=="hellyeah") {
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

function printNav() {
	global $SITE_TITLE;
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
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Profile</a></li>
        <li><a href="#">Help</a></li>
      </ul>
      <form class="navbar-form navbar-right">
        <input type="text" class="form-control" placeholder="Search...">
      </form>
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


?>