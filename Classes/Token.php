<?php

/**
* 
*/
class Token{

	public static function generate(){

		return Sesstion::put(Config::get('session/token_name'), md5(uniqid()));
	}

	public static function check($token){
		$token_name = Config::get('session/token_name');
		if(Sesstion::exists($token_name) &&  $token === Sesstion::get($token_name)){
			Sesstion::delete($token_name);
			return true;
		}

		return false;
	}
}

?>