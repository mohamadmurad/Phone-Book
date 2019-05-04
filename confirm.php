<?php
require_once 'core/init.php';
	if(Input::exists('get')){
		

		$user = new User(Input::get('un'));

		$result = $user->confirm(Input::get('un'),Input::get('ch'));
		
		switch ($result) {
			case 1:
				Sesstion::flash('success','<div class="alert alert-success" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Confirm Email Success <span class="alert-link">LogIn Now</span>
                                            </div>');
                                    
                Redirect::to('login.php');
				break;
			default:
				Redirect::to('login.php');
				break;
		}


	
	}else{
		
		Redirect::to('login.php');
	}