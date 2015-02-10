<?php

require_once("common.php");

$code = isset($httpStatusCode) ? $httpStatusCode : $_ENV['REDIRECT_STATUS'];

$responses = array(
  "404" => (object) array(
    "title" => "404!!",
    "heading" => "Sorry dude, that page totally doesn't exist.",
    "subheading" => "Learn how to type better, I guess."
  ),
  "403" => (object) array(
    "title" => "403!!",
    "heading" => "Begone, trespasser!",
    "subheading" => "This page is forbidden. You best be headed back the way you came."
  ),
  "200" => (object) array(
    "title" => "Not an error!",
    "heading" => "Oh, wise guy eh?",
    "subheading" => "Thought you could break the error page by accessing the PHP script directly, huh? Well, it looks like I'm one step ahead of you."
  )
);

$resp = $responses[$code];

printHead($resp->title);
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <?php if ($code == 404) { ?>
        <img src="/img/notfound_400.png" srcset="/img/notfound_800.png 2x" class="img-responsive center-block" alt="404 art by ryuski" title="Art by ryuski">
      <?php } ?>

      <h3 class="text-center"><?php echo $resp->heading; ?></h3>

      <p class="lead text-center"><?php echo $resp->subheading; ?></p>

    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>