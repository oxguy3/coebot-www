<?

	include_once("highlight.class.php");

	$hl = new Highlight();

	$args = explode("/", $_GET["arg"]);



	if ($args[0] == "botadd") {
		$hl->coeBotHighlight($args[1], $args[2]);

		
	} else if ($args[0] == "add") {

		if ($args[1] == "direct") {
			die("rip in pepperinos");
			//$hl->directHighlightThat($args[2]);

		} else if ($args[1] == "coebot") {
			$hl->coeBotHighlight($args[2], $args[3]);

		} else {
			die("rip in pepperinos");
			//$hl->highlightThat($args[1]);

		}

		
	} else if ($args[0] == "view") {
		die("rip in pepperinos");
		$hl->viewHighlights($args[1], $args[2]);


	} else if ($args[0] == "api") {

		if ($args[1] == "hl") {
			$hl->jsonifyHighlights($args[2], $args[3]);

		} else if ($args[1] == "stats") {

			if ($args[3]) {
				$hl->jsonifyStats($args[2], $args[3]);

			} else {
				$hl->jsonifyStats($args[2]);

			}

		} else {
			die("ya dun goofed");

		}


	} else {
		die("rip in pepperinos");

		if ($args[1]) {
			//$hl->showStatsv2($args[0], $args[1]);

		} else {
			//$hl->showStatsv2($args[0]);

		}

	}

?>