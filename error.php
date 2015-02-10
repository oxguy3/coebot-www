<?php

require_once("common.php");

$code = isset($httpStatusCode) ? $httpStatusCode : $_ENV['REDIRECT_STATUS'];

$responses = array(
  "404" => (object) array(
    "title" => "404!!",
    "heading" => "Sorry dude, that page totally doesn't exist.",
    "subheading" => "Learn how to type better, I guess.",
    "img_src" => "/img/notfound_400.png",
    "img_srcset" => "/img/notfound_800.png 2x",
    "img_alt" => "404 art by ryuski",
    "img_title" => "Art by ryuski"
  ),
  "403" => (object) array(
    "title" => "403!!",
    "heading" => "Begone, trespasser!",
    "subheading" => "This page is forbidden. You best be headed back the way you came.",
    "img_src" => "/img/coeicebucket_square.png"
  ),
  "200" => (object) array(
    "title" => "Not an error!",
    "heading" => "Oh, wise guy eh?",
    "subheading" => "Thought you could break the error page by accessing the PHP script directly, huh? Well, it looks like I'm one step ahead of you.",
    "img_src" => "/img/coeicebucket_square.png"
  )
);

$resp = $responses[$code];

printHead($resp->title);
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <?php 

      if (property_exists($resp, "img_src")) {
        echo '<img class="center-block img-responsive"';
        if (property_exists($resp, "img_src"))      { echo ' src="'     . $resp->img_src    . '"'; }
        if (property_exists($resp, "img_srcset"))   { echo ' srcset="'  . $resp->img_srcset . '"'; }
        if (property_exists($resp, "img_alt"))      { echo ' alt="'     . $resp->img_alt    . '"'; }
        if (property_exists($resp, "img_title"))    { echo ' title="'   . $resp->img_title  . '"'; }
        echo '>';
      }
      ?>

      <h3 class="text-center"><?php echo $resp->heading; ?></h3>

      <p class="lead text-center"><?php echo $resp->subheading; ?></p>

    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>