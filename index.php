<?php

require_once("common.php");

printHead("Home", array("/css/index.css"), array("/js/jquery-ui.custom.min.js", "/js/jquery.nanoscroller.js", "/js/index.js"));
printNav();

?>
<div class="container">


  <div class="row" id="home_placeholder">

    <div class="col-md-8 col-lg-9 js-whoslive-containers">
      <div id="carousel-whoslive" class="carousel slide">

        <div class="carousel-whoslive-padding"></div>

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
      <div class="nano">
        <div class="js-whoslive-list list-group nano-content"></div>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-8 col-sm-12 infobox">
      <h3>Welcome to <?php echo $SITE_TITLE; ?></h3>
      <p class="lead"><?php echo $SITE_TITLE; ?> is a chat bot for Twitch.tv. <?php echo $SITE_TITLE; ?> can moderate chat, manage custom commands, track highlights, and much more!</p>
    </div>

    <div class="col-md-4 col-sm-6 infobox">
      <h3>Want to join?</h3>
      <p>If you want to use <?php echo $SITE_TITLE; ?> on your channel, just sign in with your Twitch account and join! We are always happy to welcome new streamers to the <?php echo $SITE_TITLE; ?> family.</p>
      <p>
        <a class="btn btn-default" href="<?php echo getSignInUrl(); ?>" role="button">Get started &raquo;</a>
      </p>
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
      <h3>Keep in touch!</h3>
      <p>To stay up to date on the latest CoeBot features and news, you can follow us on Twitter and check out our development blog.</p>
      <p>
        <a class="btn btn-default" href="https://twitter.com/coebottv" role="button"><i class="icon-twitter"></i> Twitter &raquo;</a>
        <a class="btn btn-default" href="http://blog.coebot.tv" role="button"><i class="icon-edit"></i> Blog &raquo;</a>
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
          <p class="lead">bots active</p>
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
