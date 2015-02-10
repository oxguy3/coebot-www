<?

	include_once("database.php");
	include_once("../safeconfig.php");

	class Highlight
	{

		function __construct() {
			$this->db = new DataBase();
			$this->db->dbOpen();
		}

		function coeBotHighlight($twitchchannel,$twitchuser)
		{

			if (!validateChannel($twitchchannel) || !validateChannel($twitchuser)) {
				die(json_encode("Invalid parameter",JSON_FORCE_OBJECT));
			}

			$json_array = json_decode(file_get_contents('https://api.twitch.tv/kraken/streams/'.strtolower($twitchchannel).'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'), true);
				
			if (!is_array($json_array)) {
				die(json_encode("Error with Twitch API",JSON_FORCE_OBJECT));
			}


			if(isset($_COOKIE[$twitchchannel.'_'.$twitchuser.'_highlight'])){

				echo json_encode($twitchuser.", don't spam the highlight button!",JSON_FORCE_OBJECT);

				exit();

			} else {

				if ($json_array['stream'] != NULL) {

					setcookie($twitchchannel.'_'.$twitchuser.'_highlight',$twitchchannel." ".$twitchuser." Highlight Cookie",time()+60);					

					date_default_timezone_set('UTC');

					$timestamp = strtotime("now")-60; // - ($offset * 60);

					$this->db->query("insert into highlights set stamp = '".$timestamp."', `type` = 'highlight', channel = '".$twitchchannel."'");

					echo json_encode("Highlight submitted!",JSON_FORCE_OBJECT);

					exit();

				} else {

					echo json_encode("Hey ".$twitchuser.", ".$twitchchannel." is currently not streaming so you cannot submit a highlight!",JSON_FORCE_OBJECT);
					exit();

				}

			}

		}
		

		function jsonifyHighlights($channel, $streamid)
		{

			header('content-type: application/json; charset=utf-8');

			if (!validateChannel($channel) || !preg_match('/^[A-Z0-9]*$/i', $streamid)) {
				die(json_encode("Invalid parameter",JSON_FORCE_OBJECT));
			}

			//fetch stream
			$stream = json_decode(file_get_contents('https://api.twitch.tv/kraken/videos/'.$streamid.'?client_id=1edbt02x273wfht9ad4goa4aabv00fw'));	

			if (!is_object($stream)) {
				die(json_encode("Error with Twitch API",JSON_FORCE_OBJECT));
			}

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

			foreach($rows as $row) {

				$highlight = array(); //$tpl->newBlock("highlight");

				$highlight["hits"] = $row["hits"];

				$streamposition = $row["time"] - $streamstart;
				$highlight["position"] = $streamposition;

				$obj['highlights'][] = $highlight;

			}

			spitOutJson($obj);

		}

		

		function jsonifyStats($channel, $limit = 50) {

			header('content-type: application/json; charset=utf-8');

			if (!validateChannel($channel) || !preg_match('/^[0-9]*$/i', $limit)) {
				die(json_encode("Invalid parameter",JSON_FORCE_OBJECT));
			}

			$obj = array();
			
			if ($channel) {

				$obj['streams'] = array();

				date_default_timezone_set('UTC');

				$pastBroadcasts = json_decode(file_get_contents('https://api.twitch.tv/kraken/channels/'.$channel.'/videos?client_id=1edbt02x273wfht9ad4goa4aabv00fw&amp;broadcasts=true&amp;limit='.$limit), true);
				
				if (!is_array($pastBroadcasts)) {
					die(json_encode("Error with Twitch API",JSON_FORCE_OBJECT));
				}

				$pastBroadcasts = $pastBroadcasts["videos"];

				foreach($pastBroadcasts as $pastBroadcast) {

					$streamObj = array();

					$streamObj["title"] = $pastBroadcast["title"];
					$streamObj["id"] = $pastBroadcast["_id"];
					//$streamObj["channel"] = $channel;

					$streamstart = strtotime($pastBroadcast["recorded_at"]);
					$streamend = strtotime($pastBroadcast["recorded_at"]) + $pastBroadcast["length"];

					$streamObj["start"] = $streamstart;
					$streamObj["end"] = $streamend;

					$streamObj["duration"] = $pastBroadcast["length"]; // is this really necessary? A: no

					$result = $this->db->query("select stamp as `time`, count(*) as hits, `type` from highlights where channel = '$channel' and stamp >= '".$streamstart."' and stamp <= '".$streamend."' group by  YEAR(FROM_UNIXTIME(stamp)), MONTH(FROM_UNIXTIME(stamp)), DAY(FROM_UNIXTIME(stamp)), HOUR(FROM_UNIXTIME(stamp)), MINUTE(FROM_UNIXTIME(stamp)), `type` order by stamp");


					//number of unique highlights

					$uniquecount = $this->db->getNumRows();
					$streamObj["hlcount"] = $uniquecount;

					$obj['streams'][] = $streamObj;

				}

			} else {

				die(json_encode("No channel specified!",JSON_FORCE_OBJECT));

			}

			spitOutJson($obj);

		}

		

		function Highlight() {
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