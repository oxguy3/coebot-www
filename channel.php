<?php

require_once("common.php");

if (!isset($_GET['channel'])) {
  throw404();
}

$channel = strtolower($_GET['channel']);

if (!validateChannel($channel)) {
  throw404();
}


//if (getUserAccessLevel($_SESSION['channel']) > $USER_ACCESS_LEVEL_NONE) 


$channelCoebotData = dbGetChannel($channel);

if (!$channelCoebotData || $channelCoebotData['isActive'] == false) {
  if (getUserAccessLevel($channel) >= $USER_ACCESS_LEVEL_OWNER) {

    printHead("Join CoeBot?");
    printNav('', true);

    ?>

    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <h2 class="text-center">Join CoeBot?</h2>
          <p class="lead text-center">You haven't joined CoeBot yet! Care to change that?</p>
          <p class="text-center">Already hit the join button? Your request may still be processing; wait a few seconds and refresh the page.</p>
          <p class="text-center">
            <a class="btn btn-primary btn-lg" href="/botaction.php?a=join&amp;bot=coebot&amp;channel=<?php echo $channel; ?>">
              Join <?php echo $channel; ?> with CoeBot
            </a>
          </p>
          <p class="text-center">
            <a class="btn btn-primary btn-lg" href="/botaction.php?a=join&amp;bot=automodbot&amp;channel=<?php echo $channel; ?>">
              Join <?php echo $channel; ?> with AutoModBot
            </a>
          </p>
        </div>
      </div>
    </div>

    <?php

    printFooter();
    printFoot();
    die();

  } else {
    throw403();
  }
}

$extraHeadCode = "<script>";
$extraHeadCode .= "var channel = \"$channel\";";
$extraHeadCode .= "var channelCoebotData = " . json_encode($channelCoebotData) . ";";
$extraHeadCode .= "var userAccessLevel = " . getUserAccessLevel($channel) . ";";
$extraHeadCode .= "</script>";

if (!isCookieTrue("experimentalFeatures")) {
  $extraHeadCode .= "<style>.js-commands-addbtn, .js-commands-editcolumn, .js-quotes-addbtn, .js-quotes-editcolumn, .js-autoreplies-addbtn, .js-autoreplies-editcolumn, .hidden-if-experimental { display: none!important; }</style>";
}

if (!isCookieTrue("showWhalePenis")) {
  $extraHeadCode .= "<style>.whale-penis { display: none!important; }</style>";
}

printHead(
  $channelCoebotData["displayName"], 
  array("/css/channel.css"), 
  array("//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js",
    "//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js",
    "/js/later.min.js", 
    "/js/prettycron.js", 
    "/js/channel.js"
  ), 
  $extraHeadCode
);
printNav('', true);

?>
<div class="container-fluid">
  <div class="row" role="tabpanel">
    <div class="sidebar">

      <div class="panel panel-default channel-sidebar-panel">
        <div class="panel-heading visible-xs-block" role="tab" id="channelSidebarHeading">
          <h4 class="panel-title">
            <div class="channel-sidebar-heading-title">
              <span class="js-islive islive-indicator-small" data-placement="bottom"><i class="js-islive-icon icon-fw"></i></span>
              <span class="js-channel-title channel-title-small"></span>
            </div>
            <div class="channel-sidebar-heading-toggle">
              <a data-toggle="collapse" href="#channelSidebarCollapse" aria-expanded="true" aria-controls="channelSidebarCollapse" class="btn btn-default btn-sm js-channel-tab-icon"></a>
            </div>
            <div class="clearfix"></div>
          </h4>
        </div>
        <div id="channelSidebarCollapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="channelSidebarHeading" data-toggle="false">
          <div class="panel-body" id="navSidebar">
            <ul class="nav nav-sidebar" role="tablist">

              <li class="active"><a href="#tab_overview" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-user icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Overview">Overview</span>
              </a></li>

              <li id="sidebarItemSettings" class="hidden"><a href="#tab_settings" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-cog-alt icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Settings">Settings</span>
              </a></li>

              <li class="nav-sidebar-divider"></li>

              <li><a href="#tab_commands" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-terminal icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Commands">Commands</span>
              </a></li>

              <li><a href="#tab_quotes" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-quote-left icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Quotes">Quotes</span>
              </a></li>

              <li class="hidden-if-experimental"><a href="#tab_vars" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-chart-bar icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Variables">Variables</span>
              </a></li>
              
              <li class="nav-sidebar-divider"></li>

              <li><a href="#tab_autoreplies" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-chat-empty icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Auto-replies">Auto-replies</span>
              </a></li>

              <li><a href="#tab_scheduled" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-calendar icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Scheduled <span class='visible-a1000-inline'>commands</span><span class='hidden-a1000'>cmds</span>">Scheduled commands</span>
              </a></li>

              <li class="nav-sidebar-divider"></li>

              <li><a href="#tab_regulars" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-users icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Regulars">Regulars</span>
              </a></li>

              <li><a href="#tab_chatrules" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-hammer icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Chat rules">Chat rules</span>
              </a></li>

              <li class="nav-sidebar-divider"></li>

              <li><a href="#tab_highlights" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-bookmark icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="Past broadcasts">Past broadcasts</span>
              </a></li>

              <li id="sidebarItemGames" class="hidden"><a href="#tab_boir" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="icon-biblethump icon-fw"></i></span>
                <span class="sidebar-title" data-bigtitle="<span class='visible-a1000-inline'>Binding of Isaac</span><span class='hidden-a1000'>BOI</span>: Rebirth">Binding of Isaac: Rebirth</span>
              </a></li>
              
            </ul>
            <?php printFooter(); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- </div> -->
    <script>enableSidebar()</script>


    <div class="main">

      <h2 class="page-header">
        <span class="js-islive islive-indicator hidden-xs" data-placement="bottom"><i class="js-islive-icon icon-fw"></i></span>
        <span class="js-channel-title channel-title hidden-xs"></span>
        <span class="js-channel-tab-title channel-tab-title"><span>
      </h2>
      <script>displayChannelTitle()</script>


      <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="tab_overview">
          <div class="js-channel-overview"></div>
        </div><!--/.tab-pane -->
        <script>displayChannelOverview()</script>


        <div role="tabpanel" class="tab-pane fade" id="tab_settings">

          <p><button id="settingsPartModalBtn" class="btn btn-danger" data-toggle="modal" data-target="#settingsPartModal">Leave</button></p>

          <div class="modal fade" id="settingsPartModal" tabindex="-1" role="dialog" aria-labelledby="settingsPartModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="settingsPartModalLabel">Wait, don't go!</h4>
                </div>
                <div class="modal-body">
                  Are you sure you want to remove CoeBot from your channel? You can always re-add CoeBot later, and all your settings will be saved.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="settingsPartConfirmBtn" data-loading-text="Submitting...">Yes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
              </div>
            </div>
          </div>

          <h4>The rest of this page doesn't work yet, sorry!</h4>
          <div class="js-channel-settings">

            <div class="settings-form-box">
              <div class="form-group">
                <!-- TODO: Will want to have a thingy that converts any steam ID to a STEAM64 ID to make things simpler for the user -->
                <label for="settingsFormSetSteam">Steam64 ID</label>
                <input type="text" class="form-control" id="settingsFormSetSteam" placeholder="e.g. 76561197996608666">
              </div>
            </div>

            <div class="settings-form-box">
              <div class="form-group">
                <label for="settingsFormSetGamertag">Xbox Live Gamertag</label>
                <input type="text" class="form-control" id="settingsFormSetGamertag" placeholder="e.g. Oxguy3">
              </div>
            </div>

            <div class="settings-form-box">
              <div class="form-group">
                <label for="settingsFormSetLastfm">Last.fm username</label>
                <input type="text" class="form-control" id="settingsFormSetLastfm" placeholder="e.g. oxguy3">
              </div>
            </div>

          </div>
        </div><!--/.tab-pane -->
        <script>displayChannelSettings()</script>


        <div role="tabpanel" class="tab-pane fade" id="tab_commands">
          <p>
            Here are the custom commands, or "triggers", defined for this channel. You can also use any of the universal/shared commands, listed <a href="/commands" class="js-link-commands">here</a>.
          </p>
          <div class="js-commands-addbtn">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commandAddModal" data-command="" data-accesslevel="1" data-response="" data-modaltitle="Add command"><i class="icon-plus"></i> Add command</button>
          </div>

          <!-- add command modal -->
          <div class="modal fade" id="commandAddModal" tabindex="-1" role="dialog" aria-labelledby="commandAddModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="commandAddModalLabel">Set command</h4>
              </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="commandAddModalCommand">Command</label>
                    <div class="input-group">
                      <span class="input-group-addon command"></span>
                      <input type="text" class="form-control" id="commandAddModalName">
                      <input type="hidden" class="form-control" id="commandAddModalOldName">
                    </div>
                  </div>
                  <div class="form-group">
                    <label style="display:block">Access level</label>
                    <div class="btn-group js-commands-addmodal-accesslevel" id="commandAddModalAccessLevel" data-toggle="buttons">
                      <label class="btn btn-default level0">
                        <input type="radio" name="accessLevel" value="everyone" autocomplete="off"> Everyone
                      </label>
                      <label class="btn btn-default level1">
                        <input type="radio" name="accessLevel" value="regular" autocomplete="off"> Regs <!-- TODO: Dynamically replace with "Subs" if necessary -->
                      </label>
                      <label class="btn btn-default level2">
                        <input type="radio" name="accessLevel" value="mod" autocomplete="off"> Mods
                      </label>
                      <label class="btn btn-default level3">
                        <input type="radio" name="accessLevel" value="owner" autocomplete="off"> Owners
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="commandAddModalResponse">Response</label>
                    <input type="text" class="form-control" id="commandAddModalResponse" name="response">
                  </div>
<!--                   <div class="checkbox">
                    <label>
                      <input type="checkbox" name="isVisible" checked> Should command be publicly listed?
                    </label>
                  </div> -->
                </div>
                <div class="modal-footer">
                  <button id="commandAddModalSave" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>

          <div class="">
            <table class="table table-striped js-commands-table">
              <thead>
                <tr>
                  <th class="js-commands-editcolumn"></th>
                  <th><i class="sorttable-icon"></i>Command</th>
                  <th class="row-command-col-access"><i class="sorttable-icon"></i>Access</th>
                  <th><i class="sorttable-icon"></i>Response</th>
                  <th><i class="sorttable-icon"></i>Count</th>
                </tr>
              </thead>
              <tbody class="js-commands-tbody"></tbody>
            </table>
            <script>displayChannelCommands()</script>
          </div>

        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_quotes">
          <p>
            To retrieve a particular quote, use <kbd class="command">quote get [number]</kbd>. You can also retrieve a random quote with <kbd class="command">quote random</kbd>.
          </p>
          <div class="js-quotes-addbtn">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quoteAddModal" data-quote="" data-quoteid="@" data-modaltitle="Add quote"><i class="icon-plus"></i> Add quote</button>
          </div>

          <!-- add quote modal -->
          <div class="modal fade" id="quoteAddModal" tabindex="-1" role="dialog" aria-labelledby="quoteAddModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="quoteAddModalLabel">Set quote</h4>
                </div>
                <form action="/crap.php?a=post" method="post">
                  <input type="hidden" name="id" id="quoteAddModalId">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="quoteAddModalQuote">Quote</label>
                      <input type="text" class="form-control" id="quoteAddModalQuote" name="quote">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <table class="table table-striped js-quotes-table">
            <thead>
              <tr>
                <th class="js-quotes-editcolumn"></th>
                <th><i class="sorttable-icon"></i>#</th>
                <th><i class="sorttable-icon"></i>Quote</th>
                <th><i class="sorttable-icon"></i>Date added</th>
              </tr>
            </thead>
            <tbody class="js-quotes-tbody"></tbody>
          </table>
          <script>displayChannelQuotes()</script>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_vars">
          <p>
            Here are the variables for this channel. Variables can hold any sort of data that a channel owner wants to use them for; they might be used for running tallies, information about the current game, or just about anything else!
          </p>
          <table class="table table-striped js-variables-table">
            <thead>
              <tr>
                <th><i class="sorttable-icon"></i>Name</th>
                <th><i class="sorttable-icon"></i>Value</th>
                <th><i class="sorttable-icon"></i>Last modified</th>
              </tr>
            </thead>
            <tbody class="js-variables-tbody"></tbody>
          </table>
          <script>/*displayChannelVariables()*/</script>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_autoreplies">
          <p>
            Here are the auto-replies defined for this channel. Whenever Coebot sees anyone say any of these phrases, it will automatically give the appropriate reply. Asterisks (<span class="text-info">*</span>) represent wildcards for any character and ellipses (<span class="text-info">&hellip;</span>) represent any "word" character (i.e. letters, numbers, and underscores).
          </p>
          <div class="js-autoreplies-addbtn">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#autoreplyAddModal" data-trigger="" data-response="" data-arid="@" data-modaltitle="Add auto-reply"><i class="icon-plus"></i> Add auto-reply</button>
          </div>

          <!-- add autoreplies modal -->
          <div class="modal fade" id="autoreplyAddModal" tabindex="-1" role="dialog" aria-labelledby="autoreplyAddModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="autoreplyAddModalLabel">Set auto-reply</h4>
                </div>
                <form action="/crap.php?a=post" method="post">
                  <input type="hidden" name="id" id="autoreplyAddModalArid">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="autoreplyAddModalTrigger">Trigger</label>
                      <input type="text" class="form-control" id="autoreplyAddModalTrigger" name="trigger">
                    </div>
                    <div class="form-group">
                      <label for="autoreplyAddModalResponse">Response</label>
                      <input type="text" class="form-control" id="autoreplyAddModalResponse" name="response">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <table class="table table-striped js-autoreplies-table">
            <thead>
              <tr>
                <th class="js-autoreplies-editcolumn"></th>
                <th><i class="sorttable-icon"></i>#</th>
                <th><i class="sorttable-icon"></i>Trigger</th>
                <th><i class="sorttable-icon"></i>Response</th>
              </tr>
            </thead>
            <tbody class="js-autoreplies-tbody"></tbody>
          </table>
          <script>displayChannelAutoreplies()</script>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_scheduled">
          <p>
            Here are the scheduled and repeating commands defined for this channel. Coebot will automatically execute these commands according to the given time interval.
          </p>
          <table class="table table-striped js-scheduled-table">
            <thead>
              <tr>
                <th><i class="sorttable-icon"></i>Command</th>
                <th><i class="sorttable-icon"></i>Frequency</th>
              </tr>
            </thead>
            <tbody class="js-scheduled-tbody"></tbody>
          </table>
          <script>displayChannelScheduled()</script>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_regulars">
          <p>
            Here are all the users with the "regular" rank for this channel. Regulars can post links in chat and use some commands not available to the general public. Channel owners can give out this rank as they please, so the process and rules to get promoted to regular will differ betweeen channels.
          </p>
          <p class="js-regulars-subsinfo"></p>
          <div class="">
            <table class="table js-regulars-table">
              <thead>
                <tr>
                  <th><i class="sorttable-icon"></i>Twitch name</th>
                </tr>
              </thead>
              <tbody class="js-regulars-tbody"></tbody>
            </table>
            <script>displayChannelRegulars()</script>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_chatrules">
          <div class="js-chatrules_misc"></div>
          <div class="js-chatrules_offensive">
            <h3>Banned phrases</h3>
            <div class="">
              <table class="table js-chatrules_offensive-table">
                <thead>
                  <tr>
                    <th><i class="sorttable-icon"></i>Phrase</th>
                  </tr>
                </thead>
                <tbody class="js-chatrules_offensive-tbody"></tbody>
              </table>
            </div>
          </div>
          <script>displayChannelChatrules()</script>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_highlights">

          <div class="alert alert-warning visible-xs-block">
            <strong>Heads up.</strong> Due to limitations in Twitch's video player, highlights may not be playable on your device. 
            Sorry for the inconvenience.
          </div>
          <p>
            CoeBot keeps track of highlights from every streamer's livestreams. Whenever someone types <kbd class="command">ht</kbd> (meaning "highlight that!") in chat, 
            CoeBot records that as a highlight. Here you can view the highlights from the last 30 days of livestreams.
          </p>
          <div class="js-highlights-loading">
            <h3 class="loading-text"><i></i></h3>
          </div>

          <table class="table table-striped js-highlights-table hidden">
            <thead>
              <tr>
                <th><i class="sorttable-icon"></i>Title</th>
                <th><i class="sorttable-icon"></i>Start time</th>
                <th><i class="sorttable-icon"></i>Duration</th>
                <th><i class="sorttable-icon"></i>Highlights</th>
              </tr>
            </thead>
            <tbody class="js-highlights-tbody"></tbody>
          </table>

          <div class="modal fade" id="hlStreamModal" tabindex="-1" role="dialog" aria-labelledby="hlStreamModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="hlStreamModalLabel">
                    <span class="js-hlstream-loaded-inline js-hlstream-title"></span>
                    <span class="js-hlstream-loading-inline loading-text"><i></i></span>
                  </h4>
                </div>
                <div class="modal-body js-hlstream-loaded">
                  <div class="js-hlstream-player-parent"></div>
                  <p>
                    <a target="_blank" class="btn btn-primary js-hlstream-twitchlink">View on Twitch <i class="icon-twitch"></i></a>
                  </p>
                  <div class="js-hlstream-table-parent"></div>
                </div>
              </div>
            </div>
          </div>

        </div><!--/.tab-pane -->
        <script>beepBeepHeresYourHighlights()</script>


        <div role="tabpanel" class="tab-pane fade" id="tab_boir">
          <div class="js-boir-loading">
            <h3 class="loading-text"><i></i></h3>
          </div>
          <div class="js-boir-loaded hidden">
            <div class="js-boir-container"></div>
          </div>

        </div><!--/.tab-pane -->

      </div>
      <script>tabContentLoaded();</script>
    </div>
  </div>
</div>
<?php
printFoot();
?>