<?php 
/**
* Database class
*
* This class contain all operation required to working with database. 
* coding constructed to work with MySQL only, for Other DB's small alteration required.
* @author     Dharshana Jayamaha <me@geewantha.com>
* @copyright  2014 Dharshana Jayamaha
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    Release: @package_version@
* @link       http://geewantha.com
* @since      Class available since Release 1.0.0
*/
class Database{
	
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exists;

	public $last_query;

	function __construct()
	{
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysql_real_escape_string");
	}

	// Open Database Connection
	public function open_connection(){
		$this->connection  = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if(!$this->connection){
			die("Database Connection failed! : ".mysql_error());
		}else{
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if(!$db_select){
				die("Database Selection failed : ". mysql_error());
			}
		}		
	}

	// Close Database Connection
	public function close_connection(){
		if(isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	// Database Query 
	public function query($sql){
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirmed_query($result);
		return $result;
	}

	private function confirmed_query($result){
		if(!$result){
			$output = "Database Query Failed : ". mysql_error()."<br/>";
			// $output .= "Last SQL Query : ". $this->last_query; // comment this on deplyment st
			die($output);
		}
	}

	public function scape_value($value){
		if($this->real_escape_string_exists){ // PHP v4.3.0 or higher
			if($this->magic_quotes_active){$value = stripslashes($value);}
			$value = mysql_real_escape_string($value);
		} else { // before 4.3.0
			if(!$this->magic_quotes_active){$value = addslashes($value);}
		}
		return $value;
	}

	public function fetch_array($result_set){
		return mysql_fetch_array($result_set);
	}

	// return number of rows in a result set
	public function num_rows($result_set){
		return mysql_num_rows($result_set);
	}

	// return last inserted ID
	public function insert_id(){
		return mysql_insert_id($this->connection);
	}

	// retun number of rows effected in last query
	public function affected_rows(){
		return mysql_affected_rows($this->connection);
	}
}

$database = new Database();