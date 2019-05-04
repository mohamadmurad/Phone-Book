<?php
require_once 'core/init.php';


$user = new User();



if($user->isLoggedIn()){
	if(Input::exists()){
    	if(Token::check(Input::get('token'))){
    		
    		$validate = new Validate();
            $validation = $validate->check($_POST,array(
                'oldpass' => array(
                    'required' => true,
                    'correct_old_pass'  =>  $user->data()->user_id,
                 ),
                'newpass' => array(
                    'required' => true,
                    'min' => 8,
                    
                 ),
                'newpass2' => array(
                    'required' => true,
                    'matches' => 'newpass',
                    
                 ),
                
            ));

            if($validation->passed()){
               
               
                try {

                    $s = $user->updatePass(Input::get('newpass'),$user->data()->salt);

                    if($s){
                    	Sesstion::flash('success','<div class="alert alert-success text-center" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Update success
                                            </div>');
                    	Redirect::to('changePassword.php');
                    }


                   


                    
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }

        }
    }
$pageTite = 'Change Password';
$token = Token::generate();
	include 'includes/Html/header.php';
	include 'includes/Html/navbar.php';
?>


      	
	      	
	           
            	<section id="user-profile">
	              <div class="modal-dialog modal-dialog-centered" role="document">
	                <div class="modal-content">
	                  <div class="modal-header" style="margin: 0 auto;">
	                    <h5 class="modal-title" id="InfoUsersTitle">Change Password</h5>
	                  </div>
	                  <div class="modal-body" id="info-user-modal-body">
	                  	<?php
		                    if(Sesstion::exists('success')){

		                      echo Sesstion::flash('success');

		                    }
		                  ?>
	                   <form id="user-profile-form" name="user-profile-form" action="" method="post">
	                      
	                      	<div class="add-input col-md-12">
			                	<label>Old password :</label>
			                	<input type="password" id="old-pass" name="oldpass" class="form-control">
			             	</div>

			                <div class="add-input col-md-12">
			                    <label>new password :</label>
			                    <input type="password" id="new-pass" name="newpass" class="form-control">
			                </div>

			                <div class="add-input col-md-12 ">
			                    <label id="un_lable">re-type new password :</label>
			                    <input type="password" id="new-pass2" name="newpass2" class="form-control">
			                </div>

			                
							<input type="hidden" value="<?php echo $token; ?>" name="token">

	                   </form>
	                  </div>
	                  <div class="modal-footer">
	                   
	                
	                    <button id="user-save-info" type="submit" form="user-profile-form" class="btn btn-primary" >Save Change</button>
	                  </div>
	                </div>
	              </div>
	              <div class="error container" id="error-alert">

	              	 <?php
                        if(Input::exists()){
                            if(isset($validation)){

                                if(!$validation->passed()){
                                   
                                   foreach ($validation->errors() as $error) {
                                      echo '<div class="alert alert-danger text-center" role="alert">
                                              '.  $error .'
                                            </div>';
                                  }
                              	}
                              

                            }
                            
                        }
                        ?>
	              </div>
	            </section>
	           
	    
	            
	                
	        
	          


	        

<?php
	include 'includes/Html/footer.php';
}else{
	Redirect::to('../login.php');
}