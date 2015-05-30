<?php

require_once("common.php");

$code = strval(isset($httpStatusCode) ? $httpStatusCode : $_ENV['REDIRECT_STATUS']);

$responses = array(
  "200" => (object) array(
    "title" => "Not an error!",
    "heading" => "Oh, wise guy eh?",
    "subheading" => "Thought you could break the error page by accessing the PHP script directly, huh? Well, it looks like I'm one step ahead of you.",
    "img_src" => "/img/coeicebucket_square.png"
  ),
  "400" => (object) array(
    "title" => "Bad request",
    "heading" => "Bad request",
    "subheading" => (isset($httpStatusMessage)) ? $httpStatusMessage : "The request you made was invalid somehow.",
  ),
  "403" => (object) array(
    "title" => "403!!",
    "heading" => "Begone, trespasser!",
    "subheading" => "This page is forbidden. You best be headed back the way you came.",
    "image_href" => "/img/coebotsketch_1080.png",
    "img_src" => "/img/forbidden_400.png",
    "img_srcset" => "/img/forbidden_800.png 2x",
    "img_alt" => "Coebot GTFO sketch by Coestar",
    "img_title" => "Sketch by Coestar"
  ),
  "404" => (object) array(
    "title" => "404!!",
    "heading" => "Sorry dude, that page totally doesn't exist.",
    "subheading" => "Learn how to type better, I guess.",
    "image_href" => "/img/notfound_800.png",
    "img_src" => "/img/notfound_400.png",
    "img_srcset" => "/img/notfound_800.png 2x",
    "img_alt" => "404 art by ryuski",
    "img_title" => "Art by ryuski"
  ),
  "500" => (object) array(
    "title" => "Uh oh...",
    "heading" => "Internal server error",
    "subheading" => "Something's not working quite right, hopefully we'll have it fixed ASAP!",
  )
);

$resp = false;

if (isset($responses[$code])) {
  $resp = $responses[$code];

} else {
  $resp = (object) array(
    "title" => $code . " error",
    "heading" => "Error: " . $code,
    "subheading" => "A " . $code . " error has occurred.",
  );
}


printHead($resp->title);
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <?php 

      if (property_exists($resp, "img_src")) {
        if (property_exists($resp, "image_href")) { echo '<a href="' . $resp->image_href . '" target="_blank">'; }

        echo '<img class="center-block img-responsive"';
        if (property_exists($resp, "img_src"))      { echo ' src="'     . $resp->img_src    . '"'; }
        if (property_exists($resp, "img_srcset"))   { echo ' srcset="'  . $resp->img_srcset . '"'; }
        if (property_exists($resp, "img_alt"))      { echo ' alt="'     . $resp->img_alt    . '"'; }
        if (property_exists($resp, "img_title"))    { echo ' title="'   . $resp->img_title  . '"'; }
        echo '>';

        if (property_exists($resp, "image_href")) { echo '</a>'; }
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