<?php

require_once("common.php");

printHead("Home"/*, array("/css/chanlist.css"), array("/js/chanlist.js")*/);
printNav();

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <h2>Welcome to the beta!</h2>
      <p>We are working hard on making Coebot's new website. However, the new home page is still being designed! In the mean time, these other pages probably have whatever you might be looking for:</p>
      <ul>
        <li><a href="/channels">Channels</a></li>
        <li><a href="/commands">Commands</a></li>
      </ul>
    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>