<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

require_once(INCLUDES_PATH . '/debug_functions.php');
abstract class MySQLiConnection
{
	protected $command;
	protected $host;
	protected $db;
	protected $user;
	protected $pass;
	
	protected function connect()
	{
		global $config;
		if (!isset($this->host) || empty($this->host)) {
			$this->host = $config["db"]["main"]["host"];
		}
		if (!isset($this->db) || empty($this->db)) {
			$this->db = $config["db"]["main"]["dbname"];
		}
		$this->command = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($this->command->connect_errno) {
			die( "Failed to connect to MySQL: (" . $this->command->connect_errno . ") " . $this->command->connect_error );
		};
		return true;
	}
	
	protected function disconnect()
	{
		$this->command->close();
	}
	
	public function ExecuteQuery($sql)
	{
		$this->connect();
		$result = $this->command->query($sql)
			or die("Error executing query:\n\n[$sql]\n Error Message: [".$this->command->error."]");			
		$this->disconnect();
		return $result;
	}
	
	public function ExecuteStatement($sql, $params)
	{
		$this->connect();
		trace("Connected.");
		$statement = $this->command->prepare($sql);
		trace("Command: ");
		trace(print_r($this->command, true));
		trace("Statement: ");
		trace(print_r($statement, true));
		trace("Binding Params...");
		$this->bindParameters($statement, $params);
		trace("Executing...");
		try {
			$statement->execute();
			if (strstr($sql, "INSERT INTO") || strstr($sql, "DELETE FROM") || (strstr($sql, "UPDATE") && strstr($sql, "SET"))) {
				trace("Affected Rows: ".$statement->affected_rows);
				$results = $statement->affected_rows;
			}
			else {
				trace("Result.");
				$results = $this->getResults($statement);
			}
		}
		catch (Exception $e) {
			trace(print_r("Exception: ".$e, true));
		}
		$statement->close();
		$this->disconnect();
		return $results;
	}
	
	public function ExecuteQueries($sqlStatements, $stopOnError = true)
	{
		$this->connect();
		for ($i = 0; $i < count($sqlStatements); $i++)
		{
			if (!$result[$i] = $this->command->query($sqlStatements[$i])) {
				if ($stopOnError) die("Error executing query:\n\n[".$sqlStatements[$i]."]\n Error Message: [".$this->command->error."]");
				else $result[$i] = $this->command->error;
			}
		}			
		$this->disconnect();
		return $result;	
	}
	
	public function ExecuteStatements($sqlStatements, $params, $stopOnError = true)
	{
		$this->connect();
		for ($i = 0; $i < count($sqlStatements); $i++)
		{
			$sql = $sqlStatements[$i];
			$statement = $this->command->prepare($sql);			
			$this->bindParameters($statement, $params[$i]);
			try {
				$statement->execute();
				if (strstr($sql, "INSERT INTO") || strstr($sql, "DELETE FROM") || (strstr($sql, "UPDATE") && strstr($sql, "SET"))) {
					$results[$i] = $statement->affected_rows;
				}
				else {
					$results[$i] = $this->getResults($statement);
				}
			}
			catch (Exception $e) {
				trace(print_r("Exception: ".$e, true));
				if ($stopOnError) trace("Error executing query:\n\n[".$sql[$i]."]\n Error Message: [".$this->command->error."]");
				else $results[$i] = $this->command->error;
			}
			$statement->close();
		}			
		$this->disconnect();
		return $results;	
	}
	
	private function bindParameters($stmt, $params) {
		if ($params != null)
		{
			trace("bindParameters: ".print_r($params, true));
			
			// Generate the Type String (eg: 'issisd')
			$types = '';
			foreach($params as $param)
			{
				if(is_int($param)) {
					// Integer
					$types .= 'i';
				} elseif (is_float($param)) {
					// Double
					$types .= 'd';
				} elseif (is_string($param)) {
					// String
					$types .= 's';
				} else {
					// Blob and Unknown
					$types .= 'b';
				}
			}
	  
			// Add the Type String as the first Parameter
			$bind_names[] = $types;
	  
			// Loop thru the given Parameters
			for ($i=0; $i<count($params);$i++)
			{
				// Create a variable Name
				$bind_name = 'bind' . $i;
				// Add the Parameter to the variable Variable
				$$bind_name = $params[$i];
				// Associate the Variable as an Element in the Array
				$bind_names[] = &$$bind_name;
			}
			
			trace("parameters to bind: ".print_r($bind_names, true));
			 
			// Call the Function bind_param with dynamic Parameters
			call_user_func_array(array($stmt,'bind_param'), $bind_names);
			
			trace(print_r($stmt, true));
		}
	}
	
	private function getResults($stmt) {
	 	// Get metadata for field names
		$meta = $stmt->result_metadata();
	
		// initialise some empty arrays
		$fields = $results = array();
	
		// This is the tricky bit dynamically creating an array of variables to use
		// to bind the results
		while ($field = $meta->fetch_field()) { 
			$var = $field->name; 
			$$var = null; 
			$fields[$var] = &$$var; 
		}
		
		trace(" - getResults - fields: ".print_r($fields,true));
	
		// Bind Results
		call_user_func_array(array($stmt,'bind_result'),$fields);
	
		// Fetch Results
		$i = 0;
		while ($stmt->fetch()){
			$results[$i] = array();
            foreach($fields as $k => $v)
                $results[$i][$k] = $v;
            $i++;
			trace(" - - fields: ".print_r($fields,true));
		}
		trace(" - getResults - results: ".print_r($results,true));
		
		return $results;
	}
}

class SuperConnection extends MySQLiConnection
{	
	function __construct() {
		global $config;
		$this->user = $config["db"]["main"]["username"];
		$this->pass = $config["db"]["main"]["password"];
	}
}

function EnterLog($message)
{
	$ip = $_SERVER['REMOTE_ADDR'];
	$user = $_SESSION['user'];
	$conn = new SuperConnection(); //new LogDataConnection();
	$sql = "INSERT INTO log (ip, username, text) VALUES ('$ip', '$user', '$message')";
	$conn->ExecuteQuery($sql);
}

function esc($string)
{
	$string = str_replace("'", "&#39;", $string);
	$string = str_replace("%", "&#37;", $string);
	$string = str_replace('"', "&#34;", $string);
	return $string;
}

function unesc($string)
{
	$string = str_replace("&#39;", "'", $string);
	$string = str_replace("&#37;", "%", $string);
	$string = str_replace("&#34;", '\"', $string);
	return $string;
}
?>