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

printHead(
  $channel, 
  array("/css/dashboard.css"), 
  array("//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js",
    "//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js",
    "/js/later.min.js", 
    "/js/prettycron.js", 
    "/js/dashboard.js"
  ), 
  $extraHeadCode
);
printNav();

?>
<div class="container-fluid">
  <div class="row" role="tabpanel">
    <div class="col-sm-3 col-lg-2 sidebar">
      <ul class="nav nav-sidebar sidebar-collapse collapse" id="navSidebar" role="tablist">
        <li class="active"><a href="#overview"><i class="fa fa-user fa-fw"></i>&nbsp; <span class="sidebar-title">Overview</span></a></li>
        <li><a href="#commands"><i class="fa fa-terminal fa-fw"></i>&nbsp; <span class="sidebar-title">Commands</span></a></li>
        <li><a href="#quotes"><i class="fa fa-quote-left fa-fw"></i>&nbsp; <span class="sidebar-title">Quotes</span></a></li>
        <li><a href="#autoreplies"><i class="fa fa-comments-o fa-fw"></i>&nbsp; <span class="sidebar-title">Auto-replies</span></a></li>
        <li><a href="#scheduled"><i class="fa fa-calendar fa-fw"></i>&nbsp; <span class="sidebar-title">Scheduled commands</span></a></li>
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
          <div class="">
            <table class="table table-striped js-commands-table">
              <thead>
                <tr>
                  <th>Command</th>
                  <th>Access</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody class="js-commands-tbody"></tbody>
            </table>
            <script>displayChannelCommands()</script>
          </div>

        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="quotes">
          <div class="">
            <table class="table table-striped js-quotes-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Quote</th>
                </tr>
              </thead>
              <tbody class="js-quotes-tbody"></tbody>
            </table>
            <script>displayChannelQuotes()</script>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="autoreplies">
          <div class="">
            <table class="table table-striped js-autoreplies-table">
              <thead>
                <tr>
                  <th>Trigger</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody class="js-autoreplies-tbody"></tbody>
            </table>
            <script>displayChannelAutoreplies()</script>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="scheduled">
          <div class="">
            <table class="table table-striped js-scheduled-table">
              <thead>
                <tr>
                  <th>Command</th>
                  <th>Frequency</th>
                </tr>
              </thead>
              <tbody class="js-scheduled-tbody"></tbody>
            </table>
            <script>displayChannelScheduled()</script>
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