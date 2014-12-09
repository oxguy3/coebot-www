<?php

require_once("common.php");

printHead("Home", array("/css/index.css"), array("/js/index.js"));
printNav();

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <h2>Channels</h2>
      <div class="list-group js-list-channels">
      </div>
      <script>displayListChannels();</script>
    </div>
  </div>
</div>
<?php
printFoot();
?>