<?php

require_once("common.php");


printHead("Cookie Manager", array(), array("/js/cookieman.js"));
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
      <h1>Cookie Manager</h1>
      <p><strong>Hold up!</strong> This page is super duper secret, and if you don't know what this page does, I recommend that you just <a href="/">return to the home page</a> and pretend you never saw this. The options on this page may enable features that are not yet completed or are not intended for broad use.</p>

      <div class="alert alert-info hidden" role="alert" id="statusMessage">Not yet loaded</div>

      <div id="cookieOptions"></div>
      <button id="cookieSubmit" class="btn btn-default">Submit</button>
    </div>
    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>