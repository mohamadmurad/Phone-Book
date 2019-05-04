<?php
require_once 'core/init.php';


$user = new User();

if($user->isLoggedIn()){

	if($user->data()->group_id == 0 || ($user->data()->group_id != 0 && $user->privilige()->user_add == 1)){

		if(Input::exists()){
	        if(Token::check(Input::get('token'))){
	        	$validate = new Validate();
	        	$validation = null;
	        	$fileName = $_FILES['c_image']['name'];
	        	if($fileName){

	        		$validation = $validate->check($_POST,array(
		                'c_first_name' => array(
		                    'required' => true,
		                    'min' => 5,
		                    'max' => 10,
		                 ),
		                'c_last_name' => array(
		                    'required' => true,
		                    'min' => 5,
		                    'max' => 10,
		                 ),
		                'phone_number' => array(
		                    'required' => true,
		                    'min' => 7,
		                    'max' => 10,
		                    'unique' => 'contacts',
		                 ),
		                'mobile_number' => array(
		                    'required' => true,
		                    'min' => 10,
		                    'max' => 14,
		                    'unique' => 'contacts',

		                 ),
		                'birthdate' => array(
		                    'required' => true,
		            

		                 ),
		                'location' => array(
		                    'required' => true,
		                    

		                 ),
		                 'c_image' => array(
		                 	'file' => $_FILES['c_image'],
		                 	

							
		                  ),
		                
		            ));	
	        			
	        	}else{
	        		// no image
	        		$validation = $validate->check($_POST,array(
		                'c_first_name' => array(
		                    'required' => true,
		                    'min' => 5,
		                    'max' => 10,
		                 ),
		                'c_last_name' => array(
		                    'required' => true,
		                    'min' => 5,
		                    'max' => 10,
		                 ),
		                'phone_number' => array(
		                    'required' => true,
		                    'min' => 7,
		                    'max' => 10,
		                    'unique' => 'contacts',
		                 ),
		                'mobile_number' => array(
		                    'required' => true,
		                    'min' => 10,
		                    'max' => 14,
		                    'unique' => 'contacts',

		                 ),
		                'birthdate' => array(
		                    'required' => true,
		            

		                 ),
		                'location' => array(
		                    'required' => true,
		                    

		                 ),
		                
		            ));	
	        	}
	        	
	            if($validation->passed()){
	            	
	            	$contact = new Contacts();
	                try {

	                	if($fileName){
	                		$fileTmpName  = $_FILES['c_image']['tmp_name'];
	                		//$currentDir = getcwd();
    						$uploadDirectory = "../public/ContactImages/";
    						$fileExtension = explode('.',$fileName);
					   		$fileExtension = strtolower(end($fileExtension));
					   		$fileNameOnServer = md5(Hash::unique() . $user->data()->salt) .'.' . $fileExtension;
	                		$uploadPath =   $uploadDirectory . $fileNameOnServer;

		                	
		                	if(move_uploaded_file($fileTmpName, $uploadPath)){

		                		$contact->create(array(
			                        'contact_id'  => NULL,
			                        'c_first_name'    => Input::get('c_first_name'),
			                        'c_last_name' => Input::get('c_last_name'),
			                        'phone_number' => Input::get('phone_number'),
			                        'mobile_number'=> Input::get('mobile_number'),
			                        'birthdate'     => Input::get('birthdate'),
			                        'location'    => Input::get('location'),
			                        'c_image'		=> $fileNameOnServer ,
			                        'user_id'		=> $user->data()->user_id ,
			                    ));

		                	}

	                	}else{

	                		$contact->create(array(
			                        'contact_id'  => NULL,
			                        'c_first_name'    => Input::get('c_first_name'),
			                        'c_last_name' => Input::get('c_last_name'),
			                        'phone_number' => Input::get('phone_number'),
			                        'mobile_number'=> Input::get('mobile_number'),
			                        'birthdate'     => Input::get('birthdate'),
			                        'location'    => Input::get('location'),			                        
			                        'user_id'		=> $user->data()->user_id ,
			                    ));

	                	}
	                	
	                	

	                    

	                    
	                } catch (Exception $e) {
	                    die($e->getMessage());
	                }
	            }

	        }
	    }

        $pageTite = 'Add Contact';
        $token = Token::generate();
		include 'includes/Html/header.php';
		include 'includes/Html/navbar.php';



		?>


		<section class="addContact_section" id="addContact">
	          <div class="modal-dialog modal-dialog-centered">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h5 class="modal-title" id="addContactModalTitle">Add New Contact</h5>
	              	
	              </div>
	              <div class="error" id="error-alert">
                        <?php
                        if(Input::exists()){
                            if(isset($validation)){

                                if($validation->passed()){
                                 
                                    
                                 //Redirect::to('manageUsers.php');
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
	              <div class="modal-body">
	              	<form class="" id="addContact_form" action="" method="post" enctype="multipart/form-data">
		                <div class="add-input col-md-12">
		                    <label>First Name :</label>
		                    <input type="text" id="add-firstname" name="c_first_name" class="form-control" placeholder="Enter First Name" autocomplete="off" required>
		                </div>

		                <div class="add-input col-md-12">
		                    <label>Last Name :</label>
		                    <input type="text" id="add-LastName" name="c_last_name" class="form-control" placeholder="Enter Last Name" required>
		                </div>

		                <div class="add-input col-md-12">
		                    <label id="un_lable">Phone Number :</label>
		                    <input type="text" id="add-phone" name="phone_number" class="form-control" placeholder="Enter Phone Number ex:345xxxx" required>
		                </div>

		                <div class="add-input col-md-12">
		                    <label>Mobile Nuber :</label>
		                    <input type="tel" id="add-mobile" name="mobile_number" class="form-control" placeholder="Enter Mobile ex: +963xxxxxxxxx" required>
		                </div>
		                <div class="add-input col-md-12">
		                    <label>BirthDay :</label>
		                    <input type="date" id="add-birth" name="birthdate" class="form-control" required>
		                </div>
		                <div class="add-input col-md-12">
		                    <label>Location :</label>
		                    <input type="text" id="add-location" name="location" class="form-control" placeholder="Enter Location ex: Damascus" required>
		                </div>
		                <div class="add-input col-md-12">
		                	<label>Contact Photo :</label>
			                
							    <input type="file" class="file-input" id="customFile" name="c_image">
							  
							
						</div>
		              </div>
		              <input type="hidden" name="token" value="<?php echo $token;?>">
		              <div class="modal-footer">
		                <button id="save-contact" type="submit" class="btn btn-primary" style="margin: 0 auto;">Add Contact</button>
		              </div>
		          </form>
	            </div>
	          </div>
	        </section>



		<?php

		include 'includes/Html/footer.php';

	}else{
		Redirect::to('index.php');
        exit();

      
	}

}

			

