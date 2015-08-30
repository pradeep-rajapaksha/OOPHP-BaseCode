<?php
/**
* DatabaseObject class
*
* A class to help work with Common database objects
* @author     Dharshana Jayamaha <me@geewantha.com>
* @copyright  2015 Dharshana Jayamaha
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    Release: @package_version@
* @link       http://geewantha.com
* @since      Class available since Release 1.0.0
*/
class DatabaseObject{

	protected static $table_name;
	
	// Get all Records
	public static function find_all(){
		global $database;
		return static::find_by_sql("SELECT * FROM ".static::$table_name);
	}

	// Get record by table id
	public static function find_by_id($id=0){
		global $database;
		$result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id = ".$database->scape_value($id)." LIMIT 1");
		return !empty($result_array)?array_shift($result_array):false; // if not empty pull out the first element out of the array
	}

	// Get record by SQL, returns data object
	public static function find_by_sql($sql){
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}

	// Count all record listed in the table
	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM ".static::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}

	// Instantiate each record object
	private static function instantiate($record){
		// Late static binding , create object from the calling class
 		$class_name = get_called_class();
		$object = new $class_name;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}

	// check whether class having requested database attribute, 
	private function has_attribute($attribute){
		// get object_vars return an associative array with all attributes
		$object_vars = get_object_vars($this);
		// will not care the value only whether the key is exists
		return array_key_exists($attribute, $object_vars);
	}

	public function save()
 	{
 		return isset($this->id)?$this->update(): $this->create();
 	}

 	// Update record
 	protected function update(){
 		global $database;
 		// Convert object properties in to array
 		$sql = "UPDATE ".static::$table_name." SET ";
 		// get each object property which are stored in database
 		foreach (static::$db_fields as $feild) {
 			$sql .= $feild."= '".$database->scape_value($this->$feild)."', ";
 		}
 		$sql .= "modified ='".date('Y-m-d h:i:s',time())."' ";
 		$sql .= "WHERE id = ".$database->scape_value($this->id);
 		$database->query($sql);
 		return $database->affected_rows()===1 ? true : false;
 	}

 	// create a new record
 	protected function create(){
 		global $database;

 		$dataArray = (array) $this;
 		$saveArray = array();
 		foreach (static::$db_fields as $feild) {
 			$saveArray[$feild] = $this->$feild;
 		}
 		unset($saveArray['id']); // remove id property
 		$currTime = date('Y-m-d h:i:s',time());
 		$saveArray['created'] = $currTime;
 		$saveArray['modified'] = $currTime;

 		$columns = implode(", ",array_keys($saveArray));
 		$scaped_values = array_map(array($database,'scape_value'),array_values($saveArray)); 		
 		$values = "'".implode("','", array_values($scaped_values))."'";

 		$sql = "INSERT INTO ".static::$table_name." (".$columns.") VALUES (".$values.")";

		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
 	}

 	// Delete record
 	public function delete()
 	{
 		global $database;
 		$sql  = "DELETE FROM ".static::$table_name;
 		$sql .= " WHERE id=".$database->scape_value($this->id);
 		$sql .= " LIMIT 1";

 		$database->query($sql);
 		return $database->affected_rows()===1 ? true : false;
 	}

}
