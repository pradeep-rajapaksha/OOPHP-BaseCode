<?php
include_once("config.php");

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
class MySQLDatabase {

	private $connection;
	private $db_server = "localhost";
	private $db_user = "root";
	private $db_pass = "";
	private $db_name = "lab_oop_photogallery";
	private $magic_quotes_active;
	private $real_escape_string_exists;

	public $last_query;

	function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysql_real_escape_string");
	}

	/**
     * Purpose of the function is to Open the Database Connection
     *
     * @return Nothing
     */
	public function open_connection(){
		$this->connection = mysql_connect($this->db_server, $this->db_user, $this->db_pass);
		if(!$this->connection){
			die("Database connection failed: ". mysql_error());
		}else{
			$db_select = mysql_select_db($this->db_name, $this->connection);
			if(!$db_select){
				die("Database selection failed: ".mysql_error());
			}
		}
	}

	/**
     * Purpose of the function is to Close the Database Connection
     *
     * @return Nothing
     */
	public function close_connection(){
		if($this->connection){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	/**
     * Purpose of the function execute database query
     *
     * @param  String      $sql    sql query string
     * @return sql query result set
     */
	public function query($sql) {
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result){
		if(!$result){
			$output = "Database Query failed: ".mysql_error()."<br/><br/>";
			$output .= "Last SQL query : ".$this->last_query;
			die($output);
		}
	}

	public function fetch_array($result_set){
		return mysql_fetch_array($result_set);
	}

	public function num_rows($result_set){
		return mysql_num_rows($result_set);
	}

	public function insert_id(){
		return mysql_insert_id($this->connection);
	}

	public function affected_rows(){
		return mysql_affected_rows($this->connection);
	}

	// Perpare values before submitting to SQL
	public function scape_value($value){
		if($this->real_escape_string_exists){ // PHP v4.3.0 or higher
			if($this->magic_quotes_active){$value = stripslashes($value);}
			$value = mysql_real_escape_string($value);
		} else { // before 4.3.0
			if(!$this->magic_quotes_active){$value = addslashes($value);}
		}
		return $value;
	}
}

$database = new MySQLDatabase();
?>