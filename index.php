<?php

require_once("common.php");

printHead("Home", array("css/dashboard.css"));
printNav();

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
      <h1>Select a channel...</h1>
      <div class="list-group">
        <a href="<?php echo getUrlToChannel("coestar"); ?>" class="list-group-item">Coestar</a>
        <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
        <a href="#" class="list-group-item">Morbi leo risus</a>
        <a href="#" class="list-group-item">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item">Vestibulum at eros</a>
      </div>
    </div>
  </div>
</div>
<?php
printFoot(array("js/dashboard.js"));
?>