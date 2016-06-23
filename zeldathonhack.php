<?php

require_once("common.php");

requireLoggedIn();

if (!in_array($_SESSION['channel'], array("itsoxguy3", "supermcgamer", "endsgamer", "0rganics", "1862011", "22angel35", "360chrism", "8bitbrigadier", "ainkayes", "animejessica", "aubis2", "avvvee", "awildabra", "axlrosie", "bbaass_tmh", "blip", "bluehairirl", "bomb_mask", "bushelofchewygoodness", "carlsagan42", "choco", "clarelms", "coebot", "dansalvato", "dewtroid", "diredwarf", "endsgamer", "erythsea", "fakearcticlght", "fakearcticlight", "femtastic", "frosty10001", "fuzzy_wolf", "gaspra_", "greatscottlp", "hewhoamareismyself", "insaneintherain", "jacksonparodi", "jamesrct", "jb2448", "jellybeee", "johnmackay13", "jyggy11", "kampydk", "legosjedi", "letsnarvik", "lindsaypez", "lizerdoo", "lucarimew", "marishkabob", "metalninjawolf", "mika_w", "mistress_fi", "mojmann", "narcissawright", "nathan_eel", "nytsura", "oc1_", "ortholabs", "pauseunpause", "pkmnnerdfighter", "poodleskirtfanclub", "poptartgamer", "ppeach2010", "princeofcosmos", "purplesteph", "revlobot", "richard_mackay", "ridleyplays", "sariathesage", "sethbling", "shado_temple", "shoop63", "shoop631", "silverdslite", "sixelona", "skippingmonkeyplays", "smoople", "snarfybobo", "soaringchris137", "sora107", "stinusmeret", "surfimp", "tbforgood", "teddymoose", "thepurplesteph", "thereallemon", "thesideofrice", "thunderscott6267", "tompa", "torchbane", "toxicxeternity", "vidya__james", "wilicolo", "xanadu777", "zelda_queen", "zwolfenstein"))) {
  throw400("This page is restricted to Zeldathon moderators.");
}

if (isset($_POST["message"])) {
  $botSession = BotSession::getBotSessionCurrentUser("coebot", "supermcgamer");
  $botSession->doSay($_POST["message"]);
  $botSession->finalize();
}

if (isset($_POST["repeat"]) && ($_POST["repeat"]=="add"||$_POST["repeat"]=="delete")) {
  $botSession = BotSession::getBotSessionCurrentUser("coebot", "supermcgamer");
  $repeatOptions = array(
    "key" => $_POST["key"],
    "delay" => $_POST["delay"],
    "difference" => $_POST["difference"]
  );
  $botSession->addAction($_POST["repeat"]." repeat", $options);
  $botSession->finalize();

}

printHead("zeldathon hack");
printNav();

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <?php if (isset($repeatOptions)) { echo "<p>Sent this repeat command:".json_encode($repeatOptions)."</p>"; } ?>
      <h1>zeldathon hack</h1>
<p>FYI: If you refresh the page, you'll end up re-doing whatever the last command you sent was. (but, your web browser will give you an "are you sure?" pop-up, so don't worry about it).</p>
<p>If you need me to add anything else to this page, it's no trouble at all; just tweet me <a href="https://twitter.com/oxguy3">@oxguy3</a>! :)</p>
<h2>Commands</h2>
<form method="post" action="">
<input type="hidden" name="message" value="Want to get to know the attendees? Find their twitters at https://goo.gl/PVKpya">
<input type="submit" value="attendees">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Zeldathon Recovery Smash Brackets http://zeldathon.challonge.com">
<input type="submit" value="brackets">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="To see some cool donation amount ideas based on the current donation total (so you can represent Team Fixers, Breakers, Palindrome, etc.), visit http://0rganics.org/calc/">
<input type="submit" value="calc">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="For more information about Direct Relief, the charity Zeldathon Recovery benefits, visit https://www.directrelief.org/about/">
<input type="submit" value="charity">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Donate to Direct Relief right now! - http://donate.zeldathon.net">
<input type="submit" value="donate">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Create some art for the marathon! - http://www.reddit.com/r/zeldathon/">
<input type="submit" value="fanart">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Any donation of $30 or more qualifies for a goal wheel spin.">
<input type="submit" value="goalwheel">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="To host Zeldathon, in YOUR OWN CHANNEL'S chat, type out /host supermcgamer">
<input type="submit" value="host">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="The highest donation for Zeldathon Recovery so far was $25,000 on Sunday at 1:30 PM EDT, made by Scott Cawthon, the creator of Five Nights at Freddy's.">
<input type="submit" value="scott">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Keep it chill in the chat! Links aren’t allowed, neither is spam!">
<input type="submit" value="spam">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="For links to all of the Zeldathon team member's individual Twitch pages, visit https://www.twitch.tv/team/zeldathon">
<input type="submit" value="twitch">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Share the marathon on Twitter! - https://goo.gl/ObRcU7">
<input type="submit" value="twitter">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Visit the website for the BEST stream experience! - http://zeldathon.net">
<input type="submit" value="website">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Want to know what games are coming up next? - Check zeldathon.net/schedule for the schedule">
<input type="submit" value="ztschedule">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Get cool Zeldathon shirts: theyetee.com/Zeldathon">
<input type="submit" value="ztshirts">
</form>
<form method="post" action="">
<input type="hidden" name="message" value="Zeldathon Recovery Secret Sound Tracker: https://goo.gl/8h5ia9">
<input type="submit" value="ztsounds">
</form>
<br />
<form method="post" action="">
<input type="text" name="message" value="" placeholder="Enter a custom message here" style="min-width:300px;">
<input type="submit" value="Send">
</form>

<h2>Repeats</h2>
<form method="post" action="">
<select name="repeat">
  <option>add</option>
  <option>delete</option>
</select>
<p>name of command: <input type="text" name="key" value=""></p>
<p>delay: <input type="text" name="delay" value=""></p>
<p>difference: <input type="text" name="difference" value=""></p>
<input type="submit" value="send">
</form>

    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>
