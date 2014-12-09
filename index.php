<?php

require_once("common.php");

printHead("Home", array("/css/index.css"), array("/js/index.js"));
printNav();

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
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