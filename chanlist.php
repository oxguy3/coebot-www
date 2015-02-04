<?php

require_once("common.php");

printHead("Channels", array("/css/chanlist.css"), array("/js/chanlist.js"));
printNav('channels');

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
printFooter();
printFoot();
?>