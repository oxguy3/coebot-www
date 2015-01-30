<?php

require_once("common.php");

if (!isset($_GET['channel'])) {
  header("Location: /");
  die("Missing channel");
}
$channel = $_GET['channel'];
if (!validateChannel($channel)) {
  header("Location: /");
  die("Invalid channel");
}

$extraHeadCode = "<script>";
$extraHeadCode .= "var channel = \"$channel\";";
$extraHeadCode .= "</script>";

printHead(
  $channel, 
  array("/css/channel.css"), 
  array("//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js",
    "//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js",
    "/js/later.min.js", 
    "/js/prettycron.js", 
    "/js/channel.js"
  ), 
  $extraHeadCode
);
printNav();

?>
<div class="container-fluid">
  <div class="row" role="tabpanel">
    <div class="col-sm-3 col-lg-2 sidebar">

      <div class="panel panel-default channel-sidebar-panel">
        <div class="panel-heading visible-xs-block" role="tab" id="channelSidebarHeading">
          <h4 class="panel-title">
            <div class="channel-sidebar-heading-title">
              <span class="js-channel-title"></span>
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
                <span class="sidebar-icon"><i class="fa fa-user fa-fw"></i></span>
                <span class="sidebar-title">Overview</span>
              </a></li>

              <!-- <li class="nav-sidebar-divider"></li> -->

              <li><a href="#tab_commands" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-terminal fa-fw"></i></span>
                <span class="sidebar-title">Commands</span>
              </a></li>

              <li><a href="#tab_quotes" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-quote-left fa-fw"></i></span>
                <span class="sidebar-title">Quotes</span>
              </a></li>

              <li><a href="#tab_autoreplies" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-comments-o fa-fw"></i></span>
                <span class="sidebar-title">Auto-replies</span>
              </a></li>

              <li><a href="#tab_scheduled" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-calendar fa-fw"></i></span>
                <span class="sidebar-title">Scheduled commands</span>
              </a></li>

              <!-- <li class="nav-sidebar-divider"></li> -->

              <li><a href="#tab_regulars" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-users fa-fw"></i></span>
                <span class="sidebar-title">Regulars</span>
              </a></li>

              <li><a href="#tab_chatrules" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-gavel fa-fw"></i></span>
                <span class="sidebar-title">Chat rules</span>
              </a></li>

              <li><a href="#tab_highlights" class="js-sidebar-link">
                <span class="sidebar-icon"><i class="fa fa-star fa-fw"></i></span>
                <span class="sidebar-title">Highlights</span>
              </a></li>
              
            </ul>
            <?php printFooter(); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- </div> -->
    <script>enableSidebar()</script>


    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

      <h2 class="page-header">
        <span class="js-islive islive-indicator small" data-placement="bottom"><i class="js-islive-icon fa fa-fw"></i></span>
        <span class="js-channel-title channel-title hidden-xs"></span>
        <span class="js-channel-tab-title channel-tab-title"><span>
      </h2>
      <script>displayChannelTitle()</script>


      <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="tab_overview">
          <div class="js-channel-overview"></div>
        </div><!--/.tab-pane -->
        <script>displayChannelOverview()</script>


        <div role="tabpanel" class="tab-pane fade" id="tab_commands">
          <p>
            Here are the special commands defined for this channel. You can also use any of the universal/shared commands, listed <a href="/commands" class="js-link-commands">here</a>.
          </p>
          <div class="">
            <table class="table table-striped js-commands-table">
              <thead>
                <tr>
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
          <div class="">
            <table class="table table-striped js-quotes-table">
              <thead>
                <tr>
                  <th><i class="sorttable-icon"></i>#</th>
                  <th><i class="sorttable-icon"></i>Quote</th>
                </tr>
              </thead>
              <tbody class="js-quotes-tbody"></tbody>
            </table>
            <script>displayChannelQuotes()</script>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_autoreplies">
          <p>
            Here are the auto-replies defined for this channel. Whenever Coebot sees anyone say any of these phrases, it will automatically give the appropriate reply. Asterisks (*) represent wildcards.
          </p>
          <div class="">
            <table class="table table-striped js-autoreplies-table">
              <thead>
                <tr>
                  <th><i class="sorttable-icon"></i>#</th>
                  <th><i class="sorttable-icon"></i>Trigger</th>
                  <th><i class="sorttable-icon"></i>Response</th>
                </tr>
              </thead>
              <tbody class="js-autoreplies-tbody"></tbody>
            </table>
            <script>displayChannelAutoreplies()</script>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="tab_scheduled">
          <p>
            Here are the scheduled and repeating commands defined for this channel. Coebot will automatically execute these commands according to the given time interval.
          </p>
          <div class="">
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
          </div>
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
          <p>
            Highlights are still being moved over to the new site. 
            For now, the highlights are still available 
            <a href="http://coebot.tv/highlights/<?php echo $channel; ?>" target="_blank">here</a>.
          </p>
          <div class="js-highlights-loading">
            <h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3>
          </div>

          <div class="">
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