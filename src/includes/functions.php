<?php 

function redirect_to($location = null){
	if($location != null){
		header("Location: {$location}");
		exit;
	}
}

function output_message($message = ""){
	if(!empty($message)){
		return "<p class=\"class\"> {$message} </p>";
	}else {
		return "";
	}
}

function __autoload($class_name){
	$class_name = strtolower($class_name);
	$path = "../includes/{$class_name}.php";
	if(file_exists($path)){
		require_once($path);
	}else{
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template){
	include(SITE_ROOT."public/layouts/".$template);
}