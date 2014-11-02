<?php 
function strip_zeros_from_date( $marked_string = "") {
	$no_zeros = str_replace('*0', '', $marked_string);
	$cleanString = str_replace('*', '', $marked_string);
	return $cleanString;
}

function redirect_to( $location = NULL ) {
	if($location != NULL){
		header("Location: {$location}");
		exit;
	}
}

/*
 * Auto load required classes
 */
function __autoload($class_name){
	$class_name = strtolower($class_name);
	$path = "../../includes/{$class_name}.php";
	//echo $path; die();
	if(file_exists($path)){
		require_once($path);
	}else {
		die ("The file {$class_name}.php could not be found!");
	}
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}
?>