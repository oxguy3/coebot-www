<?php

require_once("common.php");

if (!isset($_GET['channel'])) {
  header("Location: /");
  die();
}
$channelName = $_GET['channel'];

printHead($channelName, array("css/dashboard.css"));
printNav();

?>
<div class="container-fluid">
  <div class="row" role="tabpanel">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar" id="navSidebar" role="tablist">
        <li class="active"><a href="#overview">Overview</a></li>
        <li><a href="#commands">Commands</a></li>
        <li><a href="#quotes">Quotes</a></li>
        <li><a href="#autoreplies">Auto-replies</a></li>
        <li><a href="#scheduled">Scheduled commands</a></li>
      </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <h1 class="page-header"><?php echo $channelName; ?></h1>


      <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="overview">

          Some content will probably go here!

        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="commands">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Command</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>+example</td>
                  <td>This is an example!</td>
                </tr>
              </tbody>
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
              <tbody>
                <tr>
                  <td>1</td>
                  <td>"Ox is the best!"</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>"Nooo! Fuck you! Fuck all of you! Fuck everyone! Fuck off! What is this horseshit! What the fuck was that bullshit! I'm fucking, this, fuck fuck this fucking frantic ass shit! Fucking frantic, diarrhea, bullshit, horsefuck, cock, and dick suck, shit balls!"</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="autoreplies">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Prompt</th>
                  <th>Response</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>hey</td>
                  <td>Hey there!</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!--/.tab-pane -->


        <div role="tabpanel" class="tab-pane fade" id="scheduled">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Command</th>
                  <th>Frequency</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>+throw hype</td>
                  <td>every 10 seconds</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!--/.tab-pane -->


      </div>
    </div>
  </div>
</div>
<?php
printFoot(array("js/dashboard.js"));
?>