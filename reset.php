<?php
require_once 'core/init.php';
	if(Input::exists('get')){
		

		


		if(Input::exists()){
		      if(Token::check(Input::get('token'))){

		        $validate = new Validate();
		        $validation = $validate->check($_POST,array(
		            'newpass' => array(
		                'required' => true,
                  		 'min' => 8,
		             
		             ),
		            'newpass2' => array(
		                'required' => true,
                        'matches' => 'newpass',
		             )
		        ));


		      if($validation->passed()){

		      	$user = new User(Input::get('un'));

		        $result = $user->resetpass(Input::get('un'),Input::get('ch'),Input::get('newpass'));
       
		        switch ($result) {
		          case 1 :
		            Redirect::to('login.php');
		            break;
		          
              case 0:
                Redirect::to('index.php');
                break;
		          default:
		            # code...
		            break;
		        }

	

		      }

		    }

    }

	
	}else{
		
		Redirect::to('login.php');
	}

$pageTite = 'Telephone Book | Re-Set Password';

    include 'includes/Html/header.php';
    include 'includes/Html/navbar.php';

?>

<section class="home">
            
            <div class="container " id="search-form">
                <div class="logo col-sm-12 text-center">
                    <img src="<?php echo Config::get("target/images"); ?>Phonebook-icon.png">
                    <h1>Tele<span>phone</span> book <span>Re-set Password</span></h1>
                </div>
                
                <div class="form text-center">          
                    <form id="reset-form" class="" method="post" action="">
                       
                        <div class="input-fi  col-12 col-sm-12">

                        	<input id="newpass" type="Password" name="newpass" class="form-control input-phones" placeholder="Enter new password">
                        </div>
                        <div class="input-fi  col-12 col-sm-12">

                        	<input id="newpass2" type="Password" name="newpass2" class="form-control input-phones" placeholder="Re-Type new Password">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

                        <button id="new_pass_btn" type="submit" class="search-btn btn">
                            Save
                        </button>
                        
                    </form>

                    <p class="have-account">Forgot Password? <span><a href="resetpassword.php">Re-set Password</a></span></p>
                    
                     <p class="have-account">Don't Have Account? <span><a href="register.php">Register</a></span></p>
                    
                </div>

                 <div class="error" id="error-alert">

                   <?php
                        if(Input::exists()){
                            if(isset($validation)){

                                if($validation->passed()){



                                   
                                  
                                }else{
                                  foreach ($validation->errors() as $error) {
                                      echo '<div class="alert alert-danger" role="alert">
                                              '.  $error .'
                                            </div>';
                                  }
                          
                                }

                            }
                            
                        }
                        ?>
                        
                       
                           

                    </div>
                
            </div>
            
        </section>

<?php

       include 'includes/Html/footer.php';

      ?>

