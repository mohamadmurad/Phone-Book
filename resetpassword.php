<?php
require_once 'core/init.php';

$temp = new User();


    if($temp->isLoggedIn()){
      Redirect::to('dashboard/');
      exit();
    }


    if(Input::exists()){
      if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST,array(
            'email' => array(
                'required' => true,
             
             ),
        ));


      if($validation->passed()){

        $user = new User();

        $login = $user->Send_reset_password(Input::get('email'));

       
        switch ($login) {
          case 1 :
            Sesstion::flash('success','<div class="alert alert-success" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Please check your Email 
                                            </div>');
            break;
         

          default:
            # code...
            break;
        }

      }

      }

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
                
                  <?php
                    if(Sesstion::exists('success')){

                      echo Sesstion::flash('success');

                    }
                  ?>
                <div class="form text-center">          
                    <form id="reset-form" class="" method="post" action="">
                        <h3>Enter Your Email to Send Reset Password Link</h3>
                        <div class="input-fi  col-12 col-sm-12">

                        	<input id="reset-email" type="text" name="email" class="form-control input-phones" placeholder="Enter your Email">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

                        <button id="reset_btn" type="button" class="search-btn btn">
                            Send
                        </button>
                        
                    </form>

                    
                </div>

                 <div class="error" id="error-alert">

                   <?php
                        if(Input::exists()){
                            if(isset($validation)){

                                if($validation->passed()){


                                  switch ($login) {

                                      case 'notFound':
                                         echo '<div class="alert alert-danger" role="alert">
                                               Email Not Found !
                                              
                                            </div>';
                                  
                                        break;
                                      case 0:{
                                          echo '<div class="alert alert-danger" role="alert">
                                             Error!
                                            </div>';
                                      }
                                        
                                        break;

                                      default:
                                       
                                        break;
                                    }
                                   
                                  
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