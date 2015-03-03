<?php

require_once('common.php');

$errorMessage = false;
$successMessage = false;



if (isset($_POST['edit'])) {

  if (!isset($_POST['xsrf']) || $_POST['xsrf'] != $_SESSION['settingsEditXSRF']) {
    $errorMessage = "A security check failed!";

  } else if (!isset($_POST['channel']) || $_POST['channel'] != $_SESSION['channel']) {
    $errorMessage = "Editing other people's channels isn't available yet.";

  } else if (!isset($_POST['youtube']) || !isset($_POST['twitter'])) {
    $errorMessage = "A required value was missing.";

  } else {

    $channel = $_POST['channel'];
    $youtube = $_POST['youtube'];
    $twitter = $_POST['twitter'];
    $shouldShowOffensiveWords = isset($_POST['shouldShowOffensiveWords']) ? 1 : 0;
    $shouldShowBoir = isset($_POST['shouldShowBoir']) ? 1 : 0;

    if (!validateChannel($channel)) {
      $errorMessage = "Invalid channel";

    } else if (!validateYoutubeUsername($youtube) && $youtube!="") {
      $errorMessage = "Invalid YouTube username";

    } else if (!validateTwitterUsername($twitter) && $twitter!="") {
      $errorMessage = "Invalid Twitter username";
    } else {
      
      if (dbUpdateChannel($channel, $youtube, $twitter, $shouldShowOffensiveWords, $shouldShowBoir)) {
        $successMessage = "Settings successfully updated!";
      } else {
        $errorMessage = "Failed to update database!";
      }

    }
  }
}

$editingChannel = $_SESSION['channel'];
$dbChannel = dbGetChannel($editingChannel);

$_SESSION['settingsEditXSRF'] = randString(32);

printHead("Settings");
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Settings</h1>

      <?php if ($successMessage !== false) { ?>
      <div class="alert alert-success"><?php echo $successMessage; ?></div>
      <?php } ?>

      <?php if ($errorMessage !== false) { ?>
      <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
      <?php } ?>

      <?php if (!$dbChannel) { ?>
        <p>You don't have a channel tied to your account! There is nothing for you to edit (yet).</p>

      <?php } else { ?>

      <form method="post" action="/settings">
        <input type="hidden" name="edit" value="1">
        <input type="hidden" name="xsrf" value="<?php echo $_SESSION['settingsEditXSRF'];?>">
        <input type="hidden" name="channel" value="<?php echo $editingChannel; ?>">
        <div class="form-group">
          <label for="settingsYoutube">YouTube username</label>
          <input type="text" class="form-control" id="settingsYoutube" name="youtube" value="<?php echo $dbChannel['youtube']; ?>">
        </div>
        <div class="form-group">
          <label for="settingsTwitter">Twitter handle</label>
          <input type="text" class="form-control" id="settingsTwitter" name="twitter" value="<?php echo $dbChannel['twitter']; ?>">
        </div>
         <div class="checkbox">
          <label>
            <input type="checkbox" name="shouldShowOffensiveWords"<?php if($dbChannel['shouldShowOffensiveWords']==1) { echo " checked"; } ?>> Publicly list offensive words
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="shouldShowBoir"<?php if($dbChannel['shouldShowBoir']==1) { echo " checked"; } ?>> Show Binding of Isaac: Rebirth run data
          </label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

      <?php } ?>
    </div>
  </div>
</div>

<?php
printFooter();
printFoot();
?>