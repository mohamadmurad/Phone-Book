<?php
require_once 'core/init.php';


$user = new User();



if($user->isLoggedIn()){
	if(Input::exists()){
    	if(Token::check(Input::get('token'))){
    		
    		$validate = new Validate();
            $validation = $validate->check($_POST,array(
                'fullname' => array(
                    'required' => true,
                    'min' => 5,
                    'max' => 30,
                 ),
                'email' => array(
                    'required' => true,
                    'unique_to_owner' => 'users',
                    
                 ),
                'username' => array(
                    'required' => true,
                    'unique_to_owner' => 'users',
                    
                 ),
                
            ));

            if($validation->passed()){
               echo 'hello';
               
                try {

                    $s = $user->updateInfo(Input::get('fullname'),Input::get('username'),Input::get('email'));

                    if($s){
                    	Sesstion::flash('success','<div class="alert alert-success text-center" role="alert"style="width: 50%;  margin: 20px auto;">
                                              Update success
                                            </div>');
                    	Redirect::to('profile.php');
                    }


                   


                    
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }

        }
    }
$pageTite = 'User Profile';
$token = Token::generate();
	include 'includes/Html/header.php';
	include 'includes/Html/navbar.php';
?>


      	
	      	
	           
            	<section id="user-profile">
	              <div class="modal-dialog modal-dialog-centered" role="document">
	                <div class="modal-content">
	                  <div class="modal-header" style="margin: 0 auto;">
	                    <h5 class="modal-title" id="InfoUsersTitle">My Profile</h5>
	                  </div>
	                  <div class="modal-body" id="info-user-modal-body">
	                  	<?php
		                    if(Sesstion::exists('success')){

		                      echo Sesstion::flash('success');

		                    }
		                  ?>
	                   <form id="user-profile-form" name="user-profile-form" action="" method="post">
	                      
	                      	<div class="add-input col-md-12">
			                	<label>Full Name :</label>
			                	<input type="text" id="edit-fullname" name="fullname" class="form-control" value="<?php echo $user->data()->full_name; ?>" disabled>
			             	</div>

			                <div class="add-input col-md-12">
			                    <label>UserName :</label>
			                    <input type="text" id="edit-username" name="username" class="form-control" value="<?php echo $user->data()->username; ?>" disabled>
			                </div>

			                <div class="add-input col-md-12 ">
			                    <label id="un_lable">Email :</label>
			                    <input type="email" id="edit-email" name="email" class="form-control" value="<?php echo $user->data()->Email; ?>" disabled>
			                </div>

			                
							<input type="hidden" value="<?php echo $token; ?>" name="token">

	                   </form>
	                  </div>
	                  <div class="modal-footer">
	                   
	                    <button id="user-edit-modal" type="button" class="btn btn-success">Edit</button>
	                    <button id="user-save-info" type="submit" form="user-profile-form" class="btn btn-primary" style="display: none;">Save Change</button>
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
                              	}else{

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