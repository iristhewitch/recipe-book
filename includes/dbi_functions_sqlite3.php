<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH") or !defined("INDEX_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

class Sqlite3Connection extends SQLite3
{
	protected $db;
	protected $dbMode;

	function __construct()
	{
		global $config;

		if (!isset($this->dbMode) || empty($this->dbMode)) {
			$this->dbMode = $config["db"]["main"]["mode"];
		}
	}

	protected function connect()
	{
		try {
			//echo 'opening or connecting to database...';

			$this->open(INDEX_PATH . '/recipe-book.sqlite', $this->dbMode);

			//echo '<strong>opened or connected to database!</strong><br />';
		} catch(Exception $e){
			die('Could not open or create database; '. PHP_EOL . PHP_EOL . $e->getMessage());
		}
	}

	protected function disconnect()
	{
		try {
			//echo 'closing database...';

			if(!$this->close())
				die('<strong>Could not close database!</strong><br />');

			//echo '<strong>closed database!</strong><br />';

		} catch(Exception $e){
			die('Could not close database; '. PHP_EOL . PHP_EOL . $e->getMessage() . '<br />');
		}
	}

	public function ExecuteQuery($query, $reconnect = true)
	{
		if($reconnect)
			$this->connect();

		try {
			$result = $this->query($query);
		} catch (Exception $e) {
			die($e->getMessage());
		}

		if($reconnect)
			$this->disconnect();

		return $result;
	}

	public function ExecuteArrayQuery($query)
	{
		$this->connect();

		try {
			$rows = $this->query($query);
			$row = array();

			$i = 0;

			while($row = $rows->fetchArray()){
				$result[$i] = $row;
				//var_dump($row);
				$i++;
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}

		/*$result = $this->command->query($sql)
            or die("Error executing query:\n\n[$sql]\n Error Message: [".$this->command->error."]");*/
		$this->disconnect();
		return $result;
	}

	public function ExecuteQueries($queries, $stopOnError = true)
	{
		$this->connect();
		$results = array();

		for($i = 0; $i < count($queries); $i++) {
			try{
				$results[$i] = $this->ExecuteQuery($queries[$i], false);
			} catch (Exception $e) {
				if($stopOnError)
					die($e->getMessage());
				//else
				//trace($e->getMessage());
			}
		}

		$this->disconnect();
		return $results;
	}
}

?>