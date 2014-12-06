<?php

require_once("common.php");

printHead("Home");
printNav();

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
      <h2>Select a channel...</h2>
      <div class="list-group">
        <a href="<?php echo getUrlToChannel("endsgamer"); ?>" class="list-group-item">endsgamer</a>
        <a href="<?php echo getUrlToChannel("coestar"); ?>" class="list-group-item">Coestar</a>
      </div>
    </div>
  </div>
</div>
<?php
printFoot();
?>