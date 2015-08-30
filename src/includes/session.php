<?php
/**
* Session class
*
* A class to help work with sessions
* In this case, primarily to manage logging users in and out
* @author     Dharshana Jayamaha <me@geewantha.com>
* @copyright  2014 Dharshana Jayamaha
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    Release: @package_version@
* @link       http://geewantha.com
* @since      Class available since Release 1.0.0
*/
class Session {

	private $logged_in = false;

	public $user_id;
	public $message;

	function __construct(){
		session_start();
		$this->check_message();
		$this->check_login();
	}

	public function is_logged_in(){
		return $this->logged_in;
	}

	public function login($user){
		if($user){
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->logged_in = true;
		}
	}

	public function logout(){
		unset($this->user_id);
		unset($_SESSION['user_id']);
		$this->logged_in = false;
	}

	public function message($msg=""){
		if(!empty($msg)){
			// Set message
			$_SESSION['message'] = $msg;
		}else{
			// get message
			return $this->message;
		}
	}

	private function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->user_id = $_SESSION['user_id'];
			$this->logged_in = true;
		}else{
			unset($this->user_id);
			$this->logged_in = false;
		}
	}

	private function check_message(){
		// if there a message stored in the session
		if(isset($_SESSION['message'])){
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}else{
			$this->message = "";
		}
	}
}

$session = new Session();
$message = $session->message();