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
                'fullName' => array(
                    'required' => true,
                    'min' => 5,
                    'max' => 30,
                 ),
                'username' => array(
                    'required' => true,
                    'min' => 5,
                    'max' => 30,
                    'unique' => 'users',
                 ),
                'email' => array(
                    'required' => true,
                    'unique' => 'users',
                 ),
                'password' => array(
                    'required' => true,
                    'min' => 8,

                 ),
                're-password' => array(
                    'required' => true,
                    'matches' => 'password',

                 ),
            ));

            if($validation->passed()){
                $user = new User();

                $salt = Hash::salt(32);
                $confirmHash = md5(Input::get('email')).Hash::unique();
                
                
                try {

                    $user->create(array(
                        'user_id'  => NULL,
                        'Email'    => Input::get('email'),
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'),$salt),
                        'full_name'=> Input::get('fullName'),
                        'salt'     => $salt,
                        'join_date' => date('Y=m-d H:i:s'),
                        'active'    => 1,
                        'confirm_hash' => $confirmHash,
                    ),array(
                        'p_id'      => NULL,
                     
                        
                    ));




                    $url = $_SERVER['HTTP_HOST'] . '/phoneOOP/confirm.php?un=' . Input::get('username') . '&ch='.$confirmHash;

                    $message = '<html><body>';
                    $message.= 'hello ' . Input::get('fullName') ;
                    $message.= '<p welcome to Telephone Book </p>';
                    $message.= '<p>pleas Confirm Your Email by Click on the link</p>';
                    $message.= '<p><a target="_blank" href="' . $url . '">Confirm Email</a></p>';
                    $message.= '</body></html>';
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                     
                    // Create email headers
                    $headers .= 'From: telephoneBook@syad.com'."\r\n".
                        'Reply-To: telephoneBook@syad.com'."\r\n" .
                        'X-Mailer: PHP/' . phpversion();
      
                  
                    //mail(Input::get('email'), 'Telephone Book | Confirm Email', $message, $headers);
                        


                    //$headers = 'MIME-Version: 1.0\\r\\n';
                  //  $headers .= 'From: TelePhonesBook@syad.000webhostapp.com' . '\\r\\n' . 'X-Mailer: PHP/' . phpversion();

                  //  mail(Input::get('email'), 'confirm', 'Hey '. Input::get('fullName') .' welcome to my site', $headers);

                    


                    
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }

        }
    }

    $pageTite = 'Telephone Book | Register';

    include 'includes/Html/header.php';
    include 'includes/Html/navbar.php';
?>

        
        <section class="home signup_home">
            
            <div class="container " id="search-form">
                <div class="logo col-sm-12 text-center">
                    <img src="<?php echo Config::get("target/images"); ?>Phonebook-icon.png">
                    <h1>Tele<span>phone</span> book <span>Register</span></h1>
                </div>
                <div class="form text-center">
                    
                    <form method="post" action="" id="register_form">
                        
                        <div class="input-fi col-md-12 col-xs-12">
                            <label>Full Name : <span id="fullname-error" style="color: red;"></span></label>
                            <input type="text" id="fullname" name="fullName" class="form-control input-phones" placeholder="Enter your Full Name" required value="<?php echo escape(Input::get('fullName')); ?>">
                        </div>
                        
                        <div class="input-fi col-md-12 col-xs-12">
                            <label>Email : <span id="email-error" style="color: red;"></span></label>
                            <input type="email" id="email" name="email" class="form-control input-phones" placeholder="Enter your Email" required value="<?php echo escape(Input::get('email')); ?>">
                        </div>
                        
                        <div class="input-fi col-md-12 col-xs-12 ">
                            <label id="un_lable">UserName : <span id="username-error" style="color: red;"></span></label>
                            <input type="text" id="username" name="username" class="form-control input-phones" placeholder="Enter your new username" required value="<?php echo escape(Input::get('username')); ?>">
                        </div>
                        
                        
                        <div class="input-fi col-md-12 col-xs-12">
                            <label id="pass_label">Password :</label>
                            <input type="password" id="pass1" name="password" class="form-control input-phones " placeholder="Enter your new password"  required>
                        </div>
                        
                        <div class="input-fi col-md-12 col-xs-12">
                            <label id="re-pass" >Re-type password :</label>
                            <input type="password" id="pass2" name="re-password" class="form-control input-phones " placeholder="Re-type password" required>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                         
                       
                       
                        <button id="register_btn" type="button" class="search-btn btn" >
                           Register
                        </button>

                        
                    </form>


                    
                    <p class="have-account">Have Account? <span><a href="login.php">Login</a></span></p>
                    
                </div>

                <div class="error" id="error-alert">
                        <?php
                        if(Input::exists()){
                            if(isset($validation)){

                                if($validation->passed()){
                                   
                                    Sesstion::flash('success','<div class="alert alert-success" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Register Success <span class="alert-link">Pleas Check your Email to Confirm Email after LogIn</span>
                                            </div>');
                                    
                                 Redirect::to('login.php');
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