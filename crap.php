<?php

require_once('common.php');

$action = $_GET['a'];

if ($action == "session") {
  print_r($_SESSION);

} else if ($action == "get") {
  print_r($_GET);
  
} else if ($action == "post") {
  print_r($_POST);
}

?>