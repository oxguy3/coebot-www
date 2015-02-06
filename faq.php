<?php

require_once("common.php");


printHead("FAQ", array("/css/faq.css"), array("/js/faq.js"));
printNav('faq');

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Frequently Asked Questions</h1>


      <div class="panel-group" id="faqAccordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingHowToJoin">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#faqAccordion" href="#questionHowToJoin" aria-expanded="false" aria-controls="questionHowToJoin">
                Q: How can I get <?php echo $SITE_TITLE; ?> on my channel?
              </a>
            </h4>
          </div>
          <div id="questionHowToJoin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingHowToJoin">
            <div class="panel-body">
              Go to <a href="http://twitch.tv/coebot" target="_blank">CoeBot's Twitch channel</a> and send <kbd>+join</kbd> in chat, and <?php echo $SITE_TITLE; ?> will start monitoring your channel. Setting up <?php echo $SITE_TITLE; ?> on a new channel can be tricky sometimes, so feel free to tweet <a href="http://twitter.com/endsgamer" target="_blank">@endsgamer</a> if you need assistance.
            </div>
          </div>
        </div>

<!--         <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingWhyNoWebsite">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionWhyNoWebsite" aria-expanded="false" aria-controls="questionWhyNoWebsite">
                Q: Why isn't my channel showing up on the <?php echo $SITE_TITLE; ?> website?
              </a>
            </h4>
          </div>
          <div id="questionWhyNoWebsite" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingWhyNoWebsite">
            <div class="panel-body">
              The website is still fairly early in development, and unfortunately, the process for a new channel to show up on the website is not yet fully automated. Tweet <a href="http://twitter.com/oxguy3" target="_blank">@oxguy3</a> and he'll get you set up on the website in no time.
            </div>
          </div>
        </div> -->

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingSetupBOICompanion">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionSetupBOICompanion" aria-expanded="false" aria-controls="questionSetupBOICompanion">
                Q: How do I enable <?php echo $SITE_TITLE; ?>'s special features for Binding of Isaac: Rebirth?
              </a>
            </h4>
          </div>
          <div id="questionSetupBOICompanion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSetupBOICompanion">
            <div class="panel-body">
              <?php echo $SITE_TITLE; ?>'s BOI features require the use of a special companion app, which you can download <a href="http://coebot.tv/files/isaac_build_updater.zip">here</a>.
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingIsOpenSource">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionIsOpenSource" aria-expanded="false" aria-controls="questionIsOpenSource">
                Q: Is <?php echo $SITE_TITLE; ?> open source?
              </a>
            </h4>
          </div>
          <div id="questionIsOpenSource" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingIsOpenSource">
            <div class="panel-body">
              Absolutely it is! <?php echo $SITE_TITLE; ?>, a fork of <a href="https://bitbucket.org/bashtech/geobot" target="_blank">bashtech's Geobot</a>, is maintained primarily by endsgamer and is freely available <a href="https://bitbucket.org/tucker_gardner/coebot" target="_blank">on Bitbucket</a>. The website is maintained by oxguy3 and is available <a href="https://github.com/oxguy3/coebot-www" target="_blank">on GitHub</a>.
            </div>
          </div>
        </div>

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