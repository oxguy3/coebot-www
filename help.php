<?php

require_once("common.php");


printHead("Help", array("/css/help.css"), array("/js/help.js"));
printNav('help');

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Help</h1>


      <h2 id="faq">Frequently Asked Questions</h2>

      <div class="panel-group" id="faqAccordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingHowToJoin">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#faqAccordion" href="#questionHowToJoin" aria-expanded="false" aria-controls="questionHowToJoin">
                Q: How can I get CoeBot on my channel?
              </a>
            </h4>
          </div>
          <div id="questionHowToJoin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingHowToJoin">
            <div class="panel-body">
              Click the "Log in" button at the top right corner of this website and sign in with your Twitch account, then click the join button to have CoeBot enter your channel. If you would rather not sign in with Twitch, you can also join by typing <kbd>+join</kbd> in <a href="http://twitch.tv/coebot" target="_blank">CoeBot's Twitch chat</a>.
              <br><br>
              Getting everything set up for the first time may seem daunting, so feel free to tweet <a href="http://twitter.com/coebottv" target="_blank">@coebottv</a> if you need any help or have any questions.
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingSetupBOICompanion">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionSetupBOICompanion" aria-expanded="false" aria-controls="questionSetupBOICompanion">
                Q: How do I enable CoeBot's special features for Binding of Isaac: Rebirth?
              </a>
            </h4>
          </div>
          <div id="questionSetupBOICompanion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSetupBOICompanion">
            <div class="panel-body">
              CoeBot's BOI features require the use of a special companion app, which you can download <a href="http://coebot.tv/files/isaac_build_updater.zip">here</a>.
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingIsOpenSource">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionIsOpenSource" aria-expanded="false" aria-controls="questionIsOpenSource">
                Q: Is CoeBot open source?
              </a>
            </h4>
          </div>
          <div id="questionIsOpenSource" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingIsOpenSource">
            <div class="panel-body">
              Absolutely it is! CoeBot, a fork of <a href="https://bitbucket.org/bashtech/geobot" target="_blank">bashtech's Geobot</a>, is maintained primarily by endsgamer and is freely available <a href="https://bitbucket.org/tucker_gardner/coebot" target="_blank">on Bitbucket</a>. The website is maintained by oxguy3 and is available <a href="https://github.com/oxguy3/coebot-www" target="_blank">on GitHub</a>.
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingLomCoebotRelated">
            <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#faqAccordion" href="#questionLomCoebotRelated" aria-expanded="false" aria-controls="questionLomCoebotRelated">
                Q: Who roleplays as CoeBot on the Lords of Minecraft server?
              </a>
            </h4>
          </div>
          <div id="questionLomCoebotRelated" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingLomCoebotRelated">
            <div class="panel-body">
              The CoeBot account is managed by our friends <a href="https://twitter.com/hanhula" target="_blank">Hanhula</a> and <a href="https://twitter.com/vrisvi" target="_blank">Vrisvi</a>.
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