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
            'username' => array(
                'required' => true,
             
             ),
            'password' => array(
                'required' => true,
             )
        ));


      if($validation->passed()){

        $user = new User();

        $remember = (Input::get('remember') === 'on') ? true : false;



        $login = $user->login(Input::get('username'),Input::get('password'),$remember);

       
        switch ($login) {
          case 1 :
            if($user->data()->group_id == 0){
              Redirect::to('dashboard/');

            }else{

             Redirect::to('dashboard/allContact.php');
            }
             
            break;
          case 'active':
            //Redirect::to('active.php');
            
            break;

          case 'confirm':
           // Redirect::to('confirm.php');
      
            break;

          default:
            # code...
            break;
        }

        /*if($login){
          Redirect::to('dashboard.php');
        }*/

      }

      }

    }


    $pageTite = 'Telephone Book | Login';

    include 'includes/Html/header.php';
    include 'includes/Html/navbar.php';

?>

<section class="home">
            
            <div class="container " id="search-form">
                <div class="logo col-sm-12 text-center">
                    <img src="<?php echo Config::get("target/images"); ?>Phonebook-icon.png">
                    <h1>Tele<span>phone</span> book <span>Login</span></h1>
                </div>
                
                <div class="form text-center">

                  <?php
                    if(Sesstion::exists('success')){

                      echo Sesstion::flash('success');

                    }
                  ?>
                    
                    <form id="login_form" class="" method="post" action="">
                        
                        <div class="input-fi  col-12 col-sm-12">

                        	<input id="login-username" type="text" name="username" class="form-control input-phones" placeholder="Enter your Username">
                        </div>
                        <div class="input-fi  col-12 col-sm-12">
                        	<input id="login-pass" type="password" name="password" class="form-control input-phones" placeholder="Enter your password" >
                        </div>
                        <div class="input-fi  col-12 col-sm-12">
                          <input type="checkbox"  class="form-check-input" name="remember" id="remember">
                          <label class="form-check-label" for="defaultCheck1">
                            Remember me
                          </label>
                        </div>

                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <button id="login_btn" type="button" class="search-btn btn">
                            Login
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

                                  if(!$login){
                                    
                                  }


                                  switch ($login) {
                                      
                                      case 'active':
                                        echo '<div class="alert alert-danger" role="alert">
                                              Admin deactivate your acount
                                            </div>';
                                        
                                        break;

                                      case 'confirm':
                                         echo '<div class="alert alert-danger" role="alert">
                                              Your Email Not Confirmed Please Check Your Email!<br>
                                              If message Not Recive <a href="re-send.php?un=' . Input::get('username') . '">Re-send</a>
                                            </div>';
                                  
                                        break;
                                      case 0:{
                                          echo '<div class="alert alert-danger" role="alert">
                                              UserName Or Password Not Match
                                            </div>';
                                      }
                                        
                                        break;

                                      default:
                                       
                                        break;
                                    }
                                   
                                  /*  Sesstion::flash('success','<div class="alert alert-success" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Register Success <span class="alert-link">login now</span>
                                            </div>');
                                    //header('location: login.php');
                                    Redirect::to('login.php');*/
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
