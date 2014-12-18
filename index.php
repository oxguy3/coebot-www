<?php

require_once("common.php");

printHead("Home", array("/css/index.css")/*, array("/js/chanlist.js")*/);
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="jumbotron" id="home_placeholder">
        <h1>Welcome to the beta!</h1>
        <p>We are working hard on making Coebot's new website. However, the new home page is still being designed! In the mean time, these other pages probably have whatever you might be looking for:</p>
        <p>
          <a class="btn btn-primary btn-lg" href="/channels" role="button">Channels</a>
          <a class="btn btn-primary btn-lg" href="/commands" role="button">Commands</a>
        </p>
      </div>
    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>