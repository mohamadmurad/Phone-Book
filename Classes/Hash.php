<?php

/**
* 
*/
class Hash {


	
	public static function make($string,$salt = ''){
		return hash('sha1',$string . $salt);
	}

	public static function salt($length){
		 $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $length) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
	}


	public static function unique(){
		return self::make(uniqid());

	}
}