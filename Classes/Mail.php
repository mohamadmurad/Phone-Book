<?php
/**
* 
*/
class Mail{
	
	public static function send($to , $subject , $message , $headers){
		
        mail($to, $subject , $message, $headers);
	}
}