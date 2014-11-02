<?php
require_once('database.php');

/**
* User class
*
* This class contain all operation required to working Users
* @author     Dharshana Jayamaha <me@geewantha.com>
* @copyright  2014 Dharshana Jayamaha
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    Release: @package_version@
* @link       http://geewantha.com
* @since      Class available since Release 1.0.0
*/
class User extends DatabaseObject {
	protected static $table_name = "tbl_users";
	protected static $db_feilds = array('id','username','password','firstname','lastname','created','modified');
	public $id;
	public $username;
	public $password;
	public $firstname;
	public $lastname;
	public $created;
	public $modified;

	private $temp_path;

	public function fullname() 	{
 		if(isset($this->firstname) && isset($this->lastname)){
 			return $this->firstname." ".$this->lastname;
 		}else{
 			return "";
 		}
 	}

 	public static function authenticate($username="", $password="") {
 		global $database;
 		$username = $database->scape_value($username);
 		$password = $database->scape_value($password);

 		$sql  = "SELECT * FROM  ".self::$table_name;
 		$sql .= " WHERE username = '{$username}' ";
 		$sql .= " AND password = '{$password}' ";
 		$sql .= " LIMIT 1";

 		$result_array = self::find_by_sql($sql);
 		return !empty($result_array)?array_shift($result_array):false;
 	}

 	// public function delete()
 	// {
 	// 	global $database;
 	// 	$sql  = "DELETE FROM tbl_users ";
 	// 	$sql .= "WHERE id=".$database->scape_value($this->id);
 	// 	$sql .= " LIMIT 1";

 	// 	$database->query($sql);
 	// 	return $database->affected_rows()===1 ? true : false;
 	// }

 	
    
}