<?php

require_once("common.php");

if (!isset($_GET['channel'])) {
  header("Location: /");
  die();
}
$channel = $_GET['channel'];
if (!validateChannel($channel)) {
  header("Location: /");
  die();
}

if (isset($_GET['tab']) && htmlspecialchars($_GET['tab']) == $_GET['tab']) {
  $jumpToTab = $_GET['tab'];
}

$extraHeadCode = "<script>";
$extraHeadCode .= "var channel = \"$channel\";";
if (isset($jumpToTab)) {
  $extraHeadCode .= "var jumpToTab = \"$jumpToTab\";";
}
$extraHeadCode .= "</script>";

printHead($channel, array("/css/dashboard.css"), array("/js/later.min.js", "/js/prettycron.js", "/js/dashboard.js"), $extraHeadCode);
printNav();

?>
<div class="container-fluid">
  <div class="row" role="tabpanel">
    <div class="col-sm-3 col-lg-2 sidebar">
      <ul class="nav nav-sidebar sidebar-collapse collapse" id="navSidebar" role="tablist">
        <li class="active"><a href="#overview">Overview</a></li>
        <li><a href="#commands">Commands</a></li>
        <li><a href="#quotes">Quotes</a></li>
        <li><a href="#autoreplies">Auto-replies</a></li>
        <li><a href="#scheduled">Scheduled commands</a></li>
      </ul>
    </div>
    <script>enableSidebar()</script>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

      <h2 class="page-header js-channel-title"></h2>
      <script>displayChannelTitle()</script>


      <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="overview">
          <div class="js-channel-overview"></div>
        </div><!--/.tab-pane -->
        <script>displayChannelOverview()</script>


        <div role="tabpanel" class="tab-pane fade" id="commands">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Command</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody class="js-commands-tbody"></tbody>
              <script>displayChannelCommands()</script>
            </table>
          </div>

        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="quotes">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Quote</th>
                </tr>
              </thead>
              <tbody class="js-quotes-tbody"></tbody>
              <script>displayChannelQuotes()</script>
            </table>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="autoreplies">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Trigger</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody class="js-autoreplies-tbody"></tbody>
              <script>displayChannelAutoreplies()</script>
            </table>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="scheduled">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Command</th>
                  <th>Frequency</th>
                </tr>
              </thead>
              <tbody class="js-scheduled-tbody"></tbody>
              <script>displayChannelScheduled()</script>
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