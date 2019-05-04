<?php
session_start();

$GLOBALS['config'] = array(
	'title' => array(
		'register' => 'Telephone Book | Register',

	),
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'newphone',
),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 86400,

	),
	'session'=> array(
		'session_name' => 'user',
		'token_name'   => 'token',
	),
	'target' => array(
		'js' 	=> 'public/js/',
		'css'	=> 'public/css/',
		'images'=> 'public/images/',
		'fontawesome' => 'public/fontawesome/'
	),
);


spl_autoload_register(function($class){
	require_once '../Classes/'. $class . '.php';
});

require_once '../functions/sanitize.php';


if(Cookie::get(Config::get('remember/cookie_name')) && !Sesstion::exists(Config::get('session/session_name'))){

	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashcheck = DB::getInstance()->get('user_sesstion',array('hash','=',$hash));
	if($hashcheck->count()){
		$user = new User($hashcheck->first()->user_id);
		$user->login();
	}

}