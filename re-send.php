<?php

require_once 'core/init.php';
	if(Input::exists('get')){
		

		$user = new User(Input::get('un'));

		$result = $user->Resend(Input::get('un'));
		
		switch ($result) {
			case 1:
				Sesstion::flash('success','<div class="alert alert-success" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Please check your Email After <span class="alert-link">LogIn</span>
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