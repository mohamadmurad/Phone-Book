<?php

/**
* 
*/
class Sesstion{
	
	public static function put($name,$value){
		 return $_SESSION[$name] = $value;
	}

	public static function exists($token_name){
		return (isset($_SESSION[$token_name])) ? true : false;
	}

	public static function delete($token_name){
		if(self::exists($token_name)){
			unset($_SESSION[$token_name]);
		}
	}

	public static function get($name){
		return $_SESSION[$name];
	}

	public static function flash($name,$string = ''){
		if(self::exists($name)){

			$session = self::get($name);
			self::delete($name);
			return $session;

		}else{
			
			self::put($name,$string);
		}
	}
}