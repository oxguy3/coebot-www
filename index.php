<?php

require_once("common.php");

printHead("Home", array(), array("/js/index.js"));
printNav();

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
      <h2>Select a channel...</h2>
      <div class="list-group js-list-channels">
<!--         <a href="<?php echo getUrlToChannel("endsgamer"); ?>" class="list-group-item">endsgamer</a>
        <a href="<?php echo getUrlToChannel("beyondsanitylol"); ?>" class="list-group-item">BeyondSanityLoL</a> -->
      </div>
      <script>displayListChannels();</script>
    </div>
  </div>
</div>
<?php
printFoot();
?>