<?php

require_once('common.php');

$action = $_GET['a'];

if ($action == "session") {
  print_r($_SESSION);
}

?>