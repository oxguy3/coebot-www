<?php

require_once("common.php");


printHead("Help", array("/css/help.css"), array("/js/help.js"));
printNav('help');

function makeQA($id, $question, $answer) {
    ?>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="heading<?php echo $id; ?>">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#faqAccordion" href="#question<?php echo $id; ?>" aria-expanded="false" aria-controls="question<?php echo $id; ?>">
            Q: <?php echo $question; ?>
          </a>
        </h4>
      </div>
      <div id="question<?php echo $id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $id; ?>">
        <div class="panel-body">
          <?php echo $answer; ?>
        </div>
      </div>
    </div>
    <?php
}

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Help</h1>

      <p class="lead">For any questions you may have, feel free to tweet us <a href="http://twitter.com/coebottv" target="_blank">@CoeBotTV</a>. You can also reach out to us individually; <a href="http://twitter.com/endsgamer" target="_blank">@endsgamer</a> is the chat bot developer and <a href="http://twitter.com/oxguy3" target="_blank">@oxguy3</a> is the website developer.</p>


      <h2 id="faq">Frequently Asked Questions</h2>

      <div class="panel-group" id="faqAccordion" role="tablist" aria-multiselectable="true">
<?php
makeQA(
    "HowToJoin",
    "How can I get CoeBot on my channel?",
    "Click the \"Log in\" button at the top right corner of this website and sign in with your Twitch account, then click the join button to have CoeBot enter your channel. If you would rather not sign in with Twitch, you can also join by typing <kbd>!join</kbd> in <a href=\"http://twitch.tv/coebot\" target=\"_blank\">CoeBot's Twitch chat</a>.\n<br><br>\nGetting everything set up for the first time may seem daunting, so feel free to tweet <a href=\"http://twitter.com/coebottv\" target=\"_blank\">@coebottv</a> if you need any help or have any questions."
);
makeQA(
    "SetupBOICompanion",
    "How do I enable CoeBot's special features for Binding of Isaac: Rebirth?",
    "CoeBot's BOI features require the use of a special companion app, which you can download <a href=\"http://coebot.tv/files/isaac_build_updater.zip\">here</a>."
);
makeQA(
    "IsOpenSource",
    "Is CoeBot open source?",
    "Absolutely it is! CoeBot, a fork of <a href=\"https://bitbucket.org/bashtech/geobot\" target=\"_blank\">bashtech's Geobot</a>, is maintained primarily by endsgamer and is freely available <a href=\"https://bitbucket.org/tucker_gardner/coebot\" target=\"_blank\">on Bitbucket</a>. The website is maintained by oxguy3 and is available <a href=\"https://github.com/oxguy3/coebot-www\" target=\"_blank\">on GitHub</a>. Additional contributions have been made by <a href=\"https://twitter.com/stinusmeret\" target=\"_blank\">stinusmeret</a>, <a href=\"https://twitter.com/alefnull\" target=\"_blank\">alefnull</a>, <a href=\"https://twitter.com/twisol\" target=\"_blank\">Twisol</a>, and <a href=\"https://twitter.com/m60IRL\" target=\"_blank\">m60</a>."
);
makeQA(
    "LomCoebotRelated",
    "Who roleplays as CoeBot on the Lords of Minecraft server?",
    "The CoeBot account is managed by our friends <a href=\"https://twitter.com/hanhula\" target=\"_blank\">Hanhula</a> and <a href=\"https://twitter.com/vrisvi\" target=\"_blank\">Vrisvi</a>."
);
makeQA(
    "ArtCredit",
    "Who makes your art?",
    "The original imagery of CoeBot as a robot was conceived by the marvelous <a href=\"https://twitter.com/ertzyl\" target=\"_blank\">ertzyl</a>, who incidentally also designed our Twitter profile picture. Our <a href=\"http://coebot.tv/img/coebotsketch_1080.png\">403 forbidden page art</a> was created by the dastardly <a href=\"https://twitter.com/coestar\" target=\"_blank\">Coestar</a>, during one of <a href=\"https://twitch.tv/coestar\" target=\"_blank\">his #SketchADay streams</a>. Coestar also made the <a href=\"https://twitchemotes.com/emote/17242\" target=\"_blank\">coeBot emote</a>, which is used for CoeBot's message bullet and for the favicon on this site. Our <a href=\"http://ryuski.deviantart.com/art/Coebot-tv-404-Art-512992689\">404 page art</a> was created by the stupendous <a href=\"https://twitter.com/xxryuskixx\" target=\"_blank\">ryuski</a>. Lots of love as well to everyone else who has made fan art of CoeBot over the years; you guys are the best! &lt;3"
);
?>

<!--         <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingDifferentTwitchName">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionDifferentTwitchName" aria-expanded="false" aria-controls="questionDifferentTwitchName">
                Q: Can I use CoeBot with a different Twitch username than "CoeBot"?
              </a>
            </h4>
          </div>
          <div id="questionDifferentTwitchName" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDifferentTwitchName">
            <div class="panel-body">
              Yes, it is possible to run your own copy of CoeBot that uses a custom Twitch account, though it's not as simple to get set up. You'll need to have your own hosting environment (a server or other machine that you can constantly run a Java application on). Once you have a place to host your copy of CoeBot, tweet <a href="http://twitter.com/endsgamer" target="_blank">@endsgamer</a> and he can walk you through setting it up.
            </div>
          </div>
        </div> -->

      </div><!-- /#faqAccordion -->

    </div>
  </div>
</div>
<?php
printFooter();
printFoot();
?>
