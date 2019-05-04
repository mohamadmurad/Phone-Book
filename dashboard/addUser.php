<?php
require_once 'core/init.php';


$user = new User();



if($user->isLoggedIn()){
	if($user->data()->group_id != 0){
		Redirect::to('index.php');
	}
	if(Input::exists()){
        if(Token::check(Input::get('token'))){


            $validate = new Validate();
            $validation = $validate->check($_POST,array(
                'fullname' => array(
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
                'password2' => array(
                    'required' => true,
                    'matches' => 'password',

                 ),
                
            ));

            if($validation->passed()){
                

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
                        'group_id'		=> (Input::get('group_id') == 'admin') ? 0 : 1 ,
                        'confirmed'		=> (Input::get('confirmed') == 'yes') ? 1 : 0 ,
                    ),array(
                        'p_id'      => NULL,
                        'user_add'  => (Input::get('p_add') == 'on') ? 1 : 0 ,
                        'user_edit'	=> (Input::get('p_edit') == 'on') ? 1 : 0 ,
                        'user_delete'=> (Input::get('p_delete') == 'on') ? 1 : 0 ,
                        
                    ));

                    if(Input::get('confirmed') != 'yes'){
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
	      

	                    Mail::send(Input::get('email'),'Telephone Book | Confirm Email',$message,$headers);
                    }


                    
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }

        }
    }
	$pageTite = 'Add User';
	$token = Token::generate();
	include 'includes/Html/header.php';
	include 'includes/Html/navbar.php';
?>
	<section class="addContact_section" id="addContact">
	          <div class="modal-dialog modal-dialog-centered">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h5 class="modal-title" id="addContactModalTitle">Add New User</h5>
	              <div class="error" id="error-alert">
                        <?php
                        if(Input::exists()){
                            if(isset($validation)){

                                if($validation->passed()){
                                 
                                    
                                 Redirect::to('manageUsers.php');
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
	              <div class="modal-body">
	              	<form class="" id="addUser_form" action="" method="post">
		                <div class="add-input col-md-12 ">
		                    <label>Full Name :</label>
		                    <input type="text" id="add-fullname" name="fullname" class="form-control"s required placeholder="Enter User Full Name">
		                </div>

		                <div class="add-input col-md-12 ">
		                    <label>UserName :</label>
		                    <input type="text" id="add-username" name="username" class="form-control"  required placeholder="Enter User Username">
		                </div>

		                <div class="add-input col-md-12  ">
		                    <label id="un_lable">Email :</label>
		                    <input type="email" id="add-email" name="email" class="form-control" required placeholder="Enter User Email">
		                </div>

		                <div class="add-input col-md-12 ">
		                    <label>Password :</label>
		                    <input type="Password" id="add-pass" name="password" class="form-control" required placeholder="Enter User Password">
		                </div>
		                <div class="add-input col-md-12 ">
		                    <label>Re-type Password :</label>
		                    <input type="Password" id="add-pass2" name="password2" class="form-control" required placeholder="Re-type User Password">
		                </div>
		                <div class="add-input col-md-12 ">
		                	<label id="un_lable">Acount Type : </label>
			      			<div class="custom-control custom-radio custom-control-inline">
							    <input type="radio" class="custom-control-input" id="admin-radio" name="group_id" value="admin">
							    <label class="custom-control-label" for="admin-radio">Admin</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
							    <input type="radio" class="custom-control-input" id="user-radio" name="group_id" value="user" checked>
							    <label class="custom-control-label" for="user-radio">User</label>
							</div> 
		                </div>

		                <div class="add-input col-md-12 ">
		                	<label id="un_lable">Acount Email Confirm : </label>
			      			<div class="custom-control custom-radio custom-control-inline">
							    <input type="radio" class="custom-control-input" id="confirm-radio" name="confirmed" value="yes">
							    <label class="custom-control-label" for="confirm-radio">confirmed</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
							    <input type="radio" class="custom-control-input" id="notconfirm-radio" name="confirmed" value="no" checked>
							    <label class="custom-control-label" for="notconfirm-radio">Not confirmed</label>
							</div> 
		                </div>

		                <div class="add-input col-md-12 ">
		                 	<div class="custom-control custom-checkbox">
							    <input type="checkbox" class="custom-control-input" id="p_add" name="p_add">
							    <label class="custom-control-label" for="p_add">Privilege Add Contact</label>
							</div>
						</div>
						<div class="add-input col-md-12 ">
		                 	<div class="custom-control custom-checkbox">
							    <input type="checkbox" class="custom-control-input" id="p_edit" name="p_edit">
							    <label class="custom-control-label" for="p_edit">Privilege Edit Contact</label>
							</div>
						</div>
						<div class="add-input col-md-12 ">
		                 	<div class="custom-control custom-checkbox">
							    <input type="checkbox" class="custom-control-input" id="p_delete" name="p_delete">
							    <label class="custom-control-label" for="p_delete">Privilege Delete Contact</label>
							</div>
						</div>

		                <input type="hidden" name="token" value="<?php echo $token; ?>">
		              </div>
		              <div class="modal-footer">
		                <button id="save-contact" type="submit" class="btn btn-primary" style="margin: 0 auto;">Add User</button>
		              </div>
		          </form>
	            </div>
	          </div>
	        </section>
<?php
	include 'includes/Html/footer.php';
}else{
	Redirect::to('../login.php');
}