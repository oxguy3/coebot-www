<?php

require_once("common.php");

printHead("Home", array("/css/index.css"), array("/js/jquery-ui.custom.min.js", "/js/index.js"));
printNav();

?>
<div class="container">

  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-info" role="alert" id="home_placeholder">
        <strong>Welcome!</strong> We're working hard to build the new site. While we're still early in development, some things may not work quite right, so please pardon our dust!
      </div>
    </div>
  </div>


  <div class="row">

    <div class="col-md-8 col-lg-9 js-whoslive-containers">
      <div id="carousel-whoslive" class="carousel slide">

        <div class="carousel-inner js-whoslive-carousel" role="listbox"></div>

        <a class="left carousel-control" href="#carousel-whoslive" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-whoslive" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 whoslive-sidebar js-whoslive-containers">
      <h4>Who's live?</h4>
      <div class="list-group js-whoslive-list"></div>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-8 col-sm-12 infobox">
      <h3>Welcome to <?php echo $SITE_TITLE; ?></h3>
      <p class="lead"><?php echo $SITE_TITLE; ?> is a chat bot for Twitch.tv. <?php echo $SITE_TITLE; ?> can moderate chat, manage custom commands, track highlights, and much more!</p>
    </div>

    <div class="col-md-4 col-sm-6 infobox">
      <h3>Need help?</h3>
      <p>The commands list and FAQ have all the information you need to learn to use <?php echo $SITE_TITLE; ?> like a pro.</p>
      <p>
        <a class="btn btn-default" href="/commands" role="button">View commands &raquo;</a> 
        <a class="btn btn-default" href="/faq" role="button">View FAQ &raquo;</a>
      </p>
    </div>

    <div class="col-md-4 col-sm-6 infobox">
      <h3>Looking for someone?</h3>
      <p>If you're looking for information about a channel that isn't currently live, you can find them on the channels list.</p>
      <p>
        <a class="btn btn-default" href="/channels" role="button">View channels &raquo;</a>
      </p>
    </div>

    <div class="col-md-4 col-sm-6 infobox">
      <h3>Do you stream?</h3>
      <p>If you're a streamer and you want to use <?php echo $SITE_TITLE; ?> on your channel, drop us a line! We are always happy to welcome new streamers to the <?php echo $SITE_TITLE; ?> family.</p>
      <p>
        <a class="btn btn-default" href="https://twitter.com/endsgamer" role="button">Tweet @endsgamer &raquo;</a>
      </p>
    </div>

    <div class="col-md-4 col-sm-6 infobox">
      <h3>Keep in touch!</h3>
      <p>To stay up to date on the latest CoeBot features and news, you can follow us on Twitter. We will also occasionally host cool channels on our Twitch page.</p>
      <p>
        <a class="btn btn-default" href="https://twitter.com/coebottv" role="button"><i class="icon-twitter"></i> Twitter &raquo;</a> 
        <a class="btn btn-default" href="https://twitch.tv/coebot" role="button"><i class="icon-twitch"></i> Twitch &raquo;</a> 
      </p>
    </div>

    <div class="col-sm-12 infobox">
      <h3>Statistics</h3>

      <div class="row">
        
        <div class="col-md-3 col-sm-4 col-xs-6 text-center">
          <h2><?php echo dbCountChannels(); ?></h2>
          <p class="lead">channels active</p>
        </div>
        
        <div class="col-md-3 col-sm-4 col-xs-6 text-center">
          <h2><?php echo dbCountBots(); ?></h2>
          <p class="lead">bot(s) active</p>
        </div>
        
        <div class="col-md-3 col-sm-4 col-xs-6 text-center">
          <h2 class="js-totalChannels">...</h2>
          <p class="lead">channels live</p>
        </div>
        
        <div class="col-md-3 col-sm-4 col-xs-6 text-center">
          <h2 class="js-totalViewers">...</h2>
          <p class="lead">viewers watching</p>
        </div>

      </div>

    </div>

  </div>


</div>
<?php
printFooter();
printFoot();
?>