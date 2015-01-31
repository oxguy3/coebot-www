<?

	include_once("database.php");

	include_once("safeconfig.php");

	//include_once("templatePower/class.TemplatePower.inc.php");

	class Highlight

	{

		

		function __construct()

		{



			$this->db = new DataBase();

			$this->db->dbOpen();

		}

		

		function coeBotHighlight($twitchchannel,$twitchuser)

		{

			$json_array = json_decode(file_get_contents('https://api.twitch.tv/kraken/streams/'.strtolower($twitchchannel).'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'), true);



			if(isset($_COOKIE[$twitchchannel.'_'.$twitchuser.'_highlight']))

			{

				echo json_encode($twitchuser.", don't spam the highlight button!",JSON_FORCE_OBJECT);

				exit();

			}

			else

			{

				if ($json_array['stream'] != NULL) {

					setcookie($twitchchannel.'_'.$twitchuser.'_highlight',$twitchchannel." ".$twitchuser." Highlight Cookie",time()+60);					

					date_default_timezone_set('UTC');

					$timestamp = strtotime("now")-60; // - ($offset * 60);

					$this->db->query("insert into highlights set stamp = '".$timestamp."', `type` = 'highlight', channel = '".$twitchchannel."'");

					echo json_encode("Highlight submitted!",JSON_FORCE_OBJECT);

					exit();

				}

				else

				{

					echo json_encode("Hey ".$twitchuser.", ".$twitchchannel." is currently not streaming so you cannot submit a highlight!",JSON_FORCE_OBJECT);

					exit();

				}

			}

		}

		

		// function highlightThat($channel)

		// {

		// 	$tpl = new TemplatePower("templates/button.html");

		// 	$tpl->prepare();

		// 	$json_array = json_decode(file_get_contents('https://api.twitch.tv/kraken/streams/'.$channel.'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'), true);

		// 	if($_POST["highlight"])

		// 	{

		// 		if(isset($_COOKIE[$channel.'_highlight']))

		// 		{

		// 			$tpl->newBlock("heylisten");

		// 		}

		// 		else

		// 		{

		// 			if ($json_array['stream'] != NULL) {

		// 				setcookie($channel."_highlight",$channel." Highlight Cookie",time()+60);					

		// 				date_default_timezone_set('UTC');

		// 				$timestamp = strtotime("now")-60;

		// 				$this->db->query("insert into highlights set stamp = '".$timestamp."', `type` = 'highlight', channel = '".$channel."'");

		// 				$tpl->newBlock("highlighted");

		// 				$tpl->assign("time",date("m/d/Y H:i:s",$timestamp-14400));

		// 			}

		// 			else

		// 			{

		// 				$tpl->newBlock("nostream");

		// 				$tpl->assign("channel",$channel);

		// 			}

		// 		}

		// 	}

		// 	$tpl->printToScreen();

		// }

		

		// function directHighlightThat($channel)

		// {

		// 	$tpl = new TemplatePower("templates/direct.html");

		// 	$tpl->prepare();

		// 	$json_array = json_decode(file_get_contents('https://api.twitch.tv/kraken/streams/'.$channel.'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'), true);

		// 	if(isset($_COOKIE[''.$channel.'_highlight']))

		// 	{

		// 		$tpl->newBlock("heylisten");

		// 	}

		// 	else

		// 	{

		// 		if ($json_array['stream'] != NULL) {

		// 			setcookie($channel."_highlight",$channel." Highlight Cookie",time()+60);					

		// 			date_default_timezone_set('UTC');

		// 			$timestamp = strtotime("now")-60;

		// 			$this->db->query("insert into highlights set stamp = '".$timestamp."', `type` = 'highlight', channel = '".$channel."'");

		// 			$tpl->newBlock("directhighlighted");

		// 			$tpl->assign("time",date("m/d/Y H:i:s",$timestamp-14400));

		// 		}

		// 		else

		// 		{

		// 			$tpl->newBlock("nostream");

		// 			$tpl->assign("channel",$channel);

		// 		}

		// 	}

		// 	$tpl->printToScreen();

		// }

		

		// function viewHighlights($channel, $streamid)

		// {

		// 	//fetch stream

		// 	$stream = json_decode(file_get_contents('https://api.twitch.tv/kraken/videos/a'.$streamid.'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'));

		// 	$tpl = new TemplatePower("templates/stream.html");

		// 	$tpl->prepare();

			

		// 	$tpl->assign("title",htmlentities($stream->title,ENT_QUOTES));

		// 	$tpl->assign("channel",$channel);

		// 	$tpl->assign("id",$streamid);

		// 	date_default_timezone_set('UTC');

		// 	$streamstart = strtotime($stream->recorded_at);

		// 	$streamend = $streamstart + $stream->length;



		// 	$result = $this->db->query("select stamp as `time`, count(*) as hits, `type` from highlights where channel = '$channel' and stamp >= '".$streamstart."' and stamp <= '".$streamend."' group by  YEAR(FROM_UNIXTIME(stamp)), MONTH(FROM_UNIXTIME(stamp)), DAY(FROM_UNIXTIME(stamp)), HOUR(FROM_UNIXTIME(stamp)), MINUTE(FROM_UNIXTIME(stamp)), `type` order by stamp");

		// 	$rows = $this->db->fetchAllRecords();

		// 	foreach($rows as $row)

		// 	{

		// 		$tpl->newBlock("highlight");

		// 		$tpl->assign("hits",$row["hits"]);

		// 		$streamposition = $row["time"] - $streamstart;

		// 		$hours = floor($streamposition / 3600);

		// 		$minutes = floor(($streamposition - ($hours*3600)) / 60);

		// 		$seconds = $streamposition - ($hours*3600) - ($minutes*60);

		// 		$tpl->assign(

		// 			Array

		// 			(

		// 				"hours" => $hours,

		// 				"minutes" => $minutes,

		// 				"seconds" => $seconds,

		// 				"seekseconds" => $streamposition

		// 			)

		// 		);

		// 	}

			

		// 	$tpl->printToScreen();

		// }
		

		function jsonifyHighlights($channel, $streamid)
		{

			header('content-type: application/json; charset=utf-8');

			//fetch stream
			$stream = json_decode(file_get_contents('https://api.twitch.tv/kraken/videos/a'.$streamid.'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'));
			// $tpl = new TemplatePower("templates/stream.html");
			// $tpl->prepare();

			$obj = array();

			$obj['title'] = htmlentities($stream->title,ENT_QUOTES);
			$obj['channel'] = $channel;
			$obj['id'] = $streamid;

			date_default_timezone_set('UTC');
			$streamstart = strtotime($stream->recorded_at);
			$streamend = $streamstart + $stream->length;

			$result = $this->db->query("select stamp as `time`, count(*) as hits, `type` from highlights where channel = '$channel' and stamp >= '".$streamstart."' and stamp <= '".$streamend."' group by  YEAR(FROM_UNIXTIME(stamp)), MONTH(FROM_UNIXTIME(stamp)), DAY(FROM_UNIXTIME(stamp)), HOUR(FROM_UNIXTIME(stamp)), MINUTE(FROM_UNIXTIME(stamp)), `type` order by stamp");
			$rows = $this->db->fetchAllRecords();

			$obj['highlights'] = array();

			foreach($rows as $row)
			{

				$highlight = array(); //$tpl->newBlock("highlight");

				$highlight["hits"] = $row["hits"];

				$streamposition = $row["time"] - $streamstart;
				$highlight["position"] = $streamposition;

				$obj['highlights'][] = $highlight;

				// $hours = floor($streamposition / 3600);
				// $minutes = floor(($streamposition - ($hours*3600)) / 60);
				// $seconds = $streamposition - ($hours*3600) - ($minutes*60);

				// $tpl->assign(
				// 	Array
				// 	(
				// 		"hours" => $hours,
				// 		"minutes" => $minutes,
				// 		"seconds" => $seconds,
				// 		"seekseconds" => $streamposition
				// 	)
				// );

			}

			spitOutJson($obj);

			//$tpl->printToScreen();

		}

		

		// function showStatsv2($channel,$limit = 50)

		// {

		// 	$tpl = new TemplatePower("templates/stats.html");

		// 	$tpl->prepare();

			

		// 	if($channel)

		// 	{

		// 		$tpl->newBlock("stats");

		// 		date_default_timezone_set('UTC');

		// 		$pastBroadcasts = json_decode(file_get_contents('https://api.twitch.tv/kraken/channels/'.$channel.'/videos?client_id=1edbt02x273wfht9ad4goa4aabv00fw&amp;broadcasts=true&amp;limit='.$limit), true);

		// 		$pastBroadcasts = $pastBroadcasts["videos"];				

		// 		foreach($pastBroadcasts as $pastBroadcast)

		// 		{

		// 			$tpl->newBlock("streamrow");

		// 			$tpl->assign("streamtitle",$pastBroadcast["title"]);

		// 			$tpl->assign("id",substr($pastBroadcast["_id"],1));

		// 			$tpl->assign("channel",$channel);

		// 			$streamstart = strtotime($pastBroadcast["recorded_at"]);

		// 			$streamend = strtotime($pastBroadcast["recorded_at"])+$pastBroadcast["length"];

		// 			$hours = floor($pastBroadcast["length"] / 3600);

		// 			$minutes = floor(($pastBroadcast["length"] - ($hours*3600)) / 60);

		// 			$seconds = $pastBroadcast["length"] - ($hours*3600) - ($minutes*60);

		// 			$tpl->assign("streamstart",date("m/d/Y H:i:s",$streamstart-14400));

		// 			$tpl->assign("streamend",date("m/d/Y H:i:s",$streamend-14400));

		// 			$result = $this->db->query("select stamp as `time`, count(*) as hits, `type` from highlights where channel = '$channel' and stamp >= '".$streamstart."' and stamp <= '".$streamend."' group by  YEAR(FROM_UNIXTIME(stamp)), MONTH(FROM_UNIXTIME(stamp)), DAY(FROM_UNIXTIME(stamp)), HOUR(FROM_UNIXTIME(stamp)), MINUTE(FROM_UNIXTIME(stamp)), `type` order by stamp");

					

		// 			//number of unique highlights

		// 			$uniquecount = $this->db->getNumRows();

		// 			$tpl->assign("hlcount",$uniquecount);

		// 			$tpl->assign("duration",$hours."h".$minutes."m".$seconds."s");

		// 		}

		// 	}

		// 	else

		// 	{

		// 		echo json_encode("No channel specified!",JSON_FORCE_OBJECT);

		// 	}

		// 	$tpl->printToScreen();

		// }

		

		function jsonifyStats($channel, $limit = 50) {

			header('content-type: application/json; charset=utf-8');

			// $tpl = new TemplatePower("templates/stats.html");
			// $tpl->prepare();

			$obj = array();
			
			if ($channel) {

				// $tpl->newBlock("stats");
				$obj['streams'] = array();

				date_default_timezone_set('UTC');

				$pastBroadcasts = json_decode(file_get_contents('https://api.twitch.tv/kraken/channels/'.$channel.'/videos?client_id=1edbt02x273wfht9ad4goa4aabv00fw&amp;broadcasts=true&amp;limit='.$limit), true);
				$pastBroadcasts = $pastBroadcasts["videos"];				

				foreach($pastBroadcasts as $pastBroadcast) {

					$streamObj = array(); // $tpl->newBlock("streamrow");

					$streamObj["title"] = $pastBroadcast["title"];
					$streamObj["id"] = substr($pastBroadcast["_id"],1);
					//$streamObj["channel"] = $channel;

					$streamstart = strtotime($pastBroadcast["recorded_at"]);
					$streamend = strtotime($pastBroadcast["recorded_at"]) + $pastBroadcast["length"];

					$streamObj["start"] = $streamstart;
					$streamObj["end"] = $streamend;

					$streamObj["duration"] = $pastBroadcast["length"]; // is this really necessary? A: no

					// $hours = floor($pastBroadcast["length"] / 3600);
					// $minutes = floor(($pastBroadcast["length"] - ($hours*3600)) / 60);
					// $seconds = $pastBroadcast["length"] - ($hours*3600) - ($minutes*60);

					// $tpl->assign("streamstart",date("m/d/Y H:i:s",$streamstart-14400));
					// $tpl->assign("streamend",date("m/d/Y H:i:s",$streamend-14400));

					$result = $this->db->query("select stamp as `time`, count(*) as hits, `type` from highlights where channel = '$channel' and stamp >= '".$streamstart."' and stamp <= '".$streamend."' group by  YEAR(FROM_UNIXTIME(stamp)), MONTH(FROM_UNIXTIME(stamp)), DAY(FROM_UNIXTIME(stamp)), HOUR(FROM_UNIXTIME(stamp)), MINUTE(FROM_UNIXTIME(stamp)), `type` order by stamp");


					//number of unique highlights

					$uniquecount = $this->db->getNumRows();
					$streamObj["hlcount"] = $uniquecount;

					//$tpl->assign("duration",$hours."h".$minutes."m".$seconds."s");

					$obj['streams'][] = $streamObj;

				}

			} else {

				die(json_encode("No channel specified!",JSON_FORCE_OBJECT));

			}

			spitOutJson($obj);

		}

		

		function Highlight()

		{

			$this->__construct();

		}

	}

	function spitOutJson($obj) {

		$json = json_encode($obj);

		if (isset($_GET['callback'])) {
			$json = $_GET['callback'] . '(' . $json . ')';
		}

		echo $json;
	}

?>