<?php



class DataBase {



	var $res;

	

	var $server;

	var $user;

	var $password;

	var $database;

	

	function set_server($string){

		$this->server = $string;

	}

	function set_user($string){

		$this->user = $string;

	}

	function set_password($string){

		$this->password = $string;

	}

	function set_database($string){

		$this->database = $string;

	}

	function set_alternative_connection($array){

		if(is_array($array)){

			extract($array);

			$this->set_server($server);

			$this->set_user($user);

			$this->set_password($password);

			$this->set_database($database);

		}

	}

	function get_server(){

		return $this->server;

	}

	function get_user(){

		return $this->user;

	}

	function get_password(){

		return $this->password;

	}

	function get_database(){

		return $this->database;

	}

	function get_connection_info(){

		return array('user'=>$this->get_user(), 'password'=>$this->get_password(),'server'=>$this->get_server(), 'database'=>$this->get_database());

	}

	function select_database($database){

		@mysql_select_db($database) or die ("To admin: Could not select database, check if the database name is correct.");

	}

	

	

	function getLog() {



		$logmsg = "<hr /><p><strong>Mysql query log:</strong></p>";



		$errors = 0;

		if (is_array($this->mysql_log) && count($this->mysql_log)) {

			$pre .= "<p>Query count: ".count($this->mysql_log)."</p>";

			foreach ($this->mysql_log as $mysql_rec) {

				if($mysql_rec['error'] != ''){ $errors ++; }

				$logmsg .= "<p>Query: ".$mysql_rec["query"]."<br />Num rows: ".$mysql_rec["numrows"]."<br />Affected rows: ".$mysql_rec["affectedrows"]."<br />Insert id: ".$mysql_rec["resultid"]."<br />Error: ".$mysql_rec["error"]."</p>";

			}

			if($errors > 0){ $pre .= '<p>Error count: '.$errors.'</p>';	}else{ $pre .= '<p>No errors</p>'; }

		}

		else {

			$logmsg .= "<p>No queries have been executed.</p>";

		}

		$this->errors = $errors;

		$return = $pre.$logmsg;

		return $return;

	}



	function getNumRows() {

		return $this->numrows;

	}



	function getAffectedRows() {

		return $this->affectedrows;

	}



	function getInsertId() {

		return $this->insertid;

	}



	function getResultId() {

		return $this->insertid;

	}



	function getError() {

		return $this->error;

	}



	function getQueryCount() {

		if (is_array($this->mysql_log) && count($this->mysql_log)) {

			return count($this->mysql_log);

		}

		else {

			return 0;

		}

	}



	function addToLog($query) {



		$this->numrows = @mysql_num_rows($this->res);

		$this->affectedrows = @mysql_affected_rows();

		$this->insertid = @mysql_insert_id();

		$this->error = @mysql_error();



		array_push($this->mysql_log, array(	"query" =>			$query,

											"numrows" =>		$this->numrows,

											"affectedrows" =>	$this->affectedrows,

											"resultid" =>		$this->resultid,

											"error" =>			$this->error));

	}



	function query($query, $otherdb = "") {



		if ($otherdb) {

			$otherdb = mysql_real_escape_string($otherdb);

			@mysql_select_db($otherdb);

		}



		$this->res = mysql_query($query); //or die ("Could not execute one or more queries, check if SQL session is started.")



		//add to mysql log

		$this->addToLog($query);



		if ($otherdb) {

			@mysql_select_db($this->database);

		}



		return $this->res;

	}



	function doSQL($query, $otherdb = "") {

		return $this->query($query, $otherdb);

	}	

	

	function fetchObject($res = ""){

		$res = $res ? $res : $this->res;

		return @mysql_fetch_object($res);

	}

	function fetchRecord($res = "") {

		//if no result given, get record from last executed query

		$res = $res ? $res : $this->res;

		return @mysql_fetch_array($res);

	}



	function fetchField($res = "") {

		//if no result given, get first field from last executed query

		$res = $res ? $res : $this->res;



		$myrow = $this->fetchRecord($res);



		return $myrow[0];

	}



	function fetchAllRecords($res = "", $reverse = false) {

		//if no result given, get records from last executed query

		$res = $res ? $res : $this->res;



		$myrows = array();



		while ($myrow = $this->fetchRecord($res)) {

			if ($reverse) {

				array_unshift($myrows, $myrow);

			}

			else {

				array_push($myrows, $myrow);

			}

		}



		return $myrows;

	}



	function fetchAllFields($res = "", $reverse = false) {



		//if no result given, get fields from last executed query

		$res = $res ? $res : $this->res;



		$myrows = array();



		while ($myrow = $this->fetchField($res)) {

			if ($reverse) {

				array_unshift($myrows, $myrow);

			}

			else {

				array_push($myrows, $myrow);

			}

		}

		return $myrows;

	}



	function dbOpen() {

		@mysql_connect($this->server, $this->user, $this->password) or die ("To admin: Could not connect to database server, check if the SQL login information is correct.");

		@mysql_query("SET NAMES UTF8"); //UTF-8 compatibility fix

		@mysql_select_db($this->database) or die ("To admin: Could not select database, check if the database name is correct.");

	}

	

	function dbClose() {

		mysql_close();

	}

	function DataBase() {

		$this->server = DB_HIGHLIGHTS_SERV;

		$this->user = DB_HIGHLIGHTS_USER;

		$this->password = DB_HIGHLIGHTS_PASS;

		$this->database = DB_HIGHLIGHTS_DATA;

		

		$this->mysql_log = array();

	}

}

/**
 * Verifies that a string is a valid Twitch username
 */
function validateChannel($channel) {
	return preg_match('/^[A-Z0-9\-_]{4,25}$/i', $channel);
}

?>