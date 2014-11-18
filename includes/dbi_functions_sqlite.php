<?php
/* __________ CONFIGURATION ____________ */
if (!defined("INCLUDES_PATH") or !defined("INDEX_PATH")){
	require_once("../config.php");
}
/* ¯¯¯¯¯¯¯¯¯¯ CONFIGURATION ¯¯¯¯¯¯¯¯¯¯¯¯ */

//require_once(INCLUDES_PATH . '/debug_functions.php');
abstract class SQLiteConnection
{
	//protected $command;
	//protected $host;
	protected $db;
	//protected $user;
	//protected $pass;

    protected $dbMode;
	
	protected function connect()
	{
		global $config;
		/*if (!isset($this->host) || empty($this->host)) {
			$this->host = $config["db"]["main"]["host"];
		}
		if (!isset($this->db) || empty($this->db)) {
			$this->db = $config["db"]["main"]["dbname"];
		}
		$this->command = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($this->command->connect_errno) {
			die( "Failed to connect to MySQL: (" . $this->command->connect_errno . ") " . $this->command->connect_error );
		};*/

        if (!isset($this->dbMode) || empty($this->dbMode)) {
            $this->dbMode = $config["db"]["main"]["mode"];
        }

        if($this->db = sqlite_open(INDEX_PATH . '/recipe-book.sqlite', $this->dbMode, $error)) {
            //trace('Connected to the database!');
        } else {
            die('could not find or create database' . PHP_EOL . PHP_EOL . $error);
        }

		return true;
	}
	
	protected function disconnect()
	{
        sqlite_close($this->db);
	}

	public function ExecuteQuery($query)
	{
		$this->connect();

        try {
            $result = sqlite_query($this->db, $query);
        } catch (Exception $e) {
            die($e->getMessage());
        }

		/*$result = $this->command->query($sql)
			or die("Error executing query:\n\n[$sql]\n Error Message: [".$this->command->error."]");*/
        $this->disconnect();
		return $result;
	}

    public function ExecuteArrayQuery($query)
    {
        $this->connect();

        try {
            //echo '<pre>'.$query.'</pre>';
            $result = sqlite_array_query($this->db, $query, SQLITE_ASSOC);
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
                $results[$i] = $this->ExecuteQuery($queries[$i]);
            } catch (Exception $e) {
                if($stopOnError)
                    die($e->getMessage());
                //else
                    //trace($e->getMessage());
            }
        }


		/*for ($i = 0; $i < count($sqlStatements); $i++)
		{
			if (!$result[$i] = $this->command->query($sqlStatements[$i])) {
				if ($stopOnError) die("Error executing query:\n\n[".$sqlStatements[$i]."]\n Error Message: [".$this->command->error."]");
				else $result[$i] = $this->command->error;
			}
		}*/
		$this->disconnect();
		return $results;
	}
}

class SuperConnection extends SQLiteConnection
{	
	function __construct() {
		global $config;
		$this->user = $config["db"]["main"]["username"];
		$this->pass = $config["db"]["main"]["password"];
        $this->dbMode = $config["db"]["main"]["mode"];
	}
}

function EnterLog($message)
{
	/*$ip = $_SERVER['REMOTE_ADDR'];
	$user = $_SESSION['user'];
	$conn = new SuperConnection(); //new LogDataConnection();
	$sql = "INSERT INTO log (ip, username, text) VALUES ('$ip', '$user', '$message')";
	$conn->ExecuteQuery($sql);*/
}
?>