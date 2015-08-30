<?php
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
class User extends Databaseobject{

	protected static $table_name = "tbl_users";
	protected static $db_fields = array('id', 'username', 'password', 'firstname', 'lastname' );

	public $id;
	public $username;
	public $password;
	public $firstname;
	public $lastname;

	public function fullname() 	{
 		if(isset($this->firstname) && isset($this->lastname)){
 			return $this->firstname." ".$this->lastname;
 		}else{
 			return "";
 		}
 	}

 	public static function authanticate($username="", $password=""){
 		global $database;
 		$username = $database->scape_value($username);
 		$password = $database->scape_value($password);

 		$sql = "SELECT * FROM tbl_users ";
 		$sql .="WHERE username = '{$username}' ";
 		$sql .="AND password = '{$password}' ";
 		$sql .="LIMIT 1";

 		$result_array = self::find_by_sql($sql);
 		return !empty($result_array) ? array_shift($result_array) : false;
 	}
}