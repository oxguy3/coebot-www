<?php

require_once("common.php");


printHead("COESTREAM500 helper stuffs");
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>COESTREAM500 helper stuffs</h1>

      <h2>Rafflify</h2>
      <p>Copy a row from the spreadsheet and paste it here, and the site will generate a nice clean message you can PM to the winner via Twitch.</p>
      <h4>Paste here</h4>
      <textarea id="rafflify_in" rows="4" cols="50"></textarea>
      <h4>Output here</h4>
      <textarea id="rafflify_out" rows="14" cols="50"></textarea>
    </div>
  </div>
</div>
<script>

$("#rafflify_in").change(function(){
  var text = $(this).val();
  var cols = text.split("\t");

  var game = cols[0];
  var donor = cols[1];
  var key = cols[2];
  var redeem = cols[3];

  var message = "";

  message += "Congrats, you won a copy of \"";
  message += game;
  message += "\", provided by ";
  message += donor;
  message += ", in a giveaway during Coestar's 500th #StreamADay!";
  message += "\n\n";
  if (key == "") {
    message += "You can redeem this item at: ";
    message += redeem;
  } else {
    message += "Here's your key: ";
    message += key;
    message += "\n\n";
    message += "Info on how to redeem this key is available at: ";
    message += redeem;
  }
  message += "\n\n";
  message += "Message us if you have any problem redeeming this. We hope you enjoy it!";

  $("#rafflify_out").text(message);
  $(this).val("");
});
</script>
<?php
printFooter();
printFoot();
?>