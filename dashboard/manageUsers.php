<?php

require_once 'core/init.php';


$user = new User();



if($user->isLoggedIn()){
	if($user->data()->group_id != 0){
		Redirect::to('index.php');
	}
$pageTite = 'Manage Users';
$token = Token::generate();
	include 'includes/Html/header.php';
	include 'includes/Html/navbar.php';
?>

<section class="all-contact">
      	
	      	<div class="container text-center" id="search-form">
	            <h3>Manage Users</h3>
	    
	            <table class="table table-bordered text-center" id="all-data" >
	                <thead>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Acount UserName</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Acount State</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Acount Type</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Info | Delete | privileges</th>
	                </thead>
	                <tbody id="Users-data">
	                  
	                </tbody>
	            </table>
	            <a class="btn btn-primary" href="addUser.php">Add User</a>
	            <nav class="text-center" style="padding-top:12px; ">
				  <ul class="pagination justify-content-center" id="pagination_users">
				    
				  </ul>
				</nav>
	                
	            
	          
	        </div>
	          
	    </section>

	        <div class="modal fade " id="InfoUser" tabindex="-1" role="dialog" aria-labelledby="InfoUsersTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="InfoUsersTitle">User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="info-user-modal-body">
                   <form id="edit-user-from-modal" name="edit-user-from-modal" action="" method="post">
                      

                   </form>
                  </div>
                  <div class="modal-footer">
                    <button id="close-add" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="user-edit-modal" type="button" class="btn btn-success">Edit</button>
                    <button id="user-save-change" type="submit" form="edit-user-from-modal" class="btn btn-primary" style="display: none;">Save Change</button>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal fade " id="Userprivi" tabindex="-1" role="dialog" aria-labelledby="UsersPriviTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="UsersPriviTitle">User Privilige</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="info-user-modal-body">
                   <form id="edit-user-privi-from-modal" name="edit-user-privi-from-modal" action="" method="post">
                      

                   </form>
                  </div>
                  <div class="modal-footer">
                    <button id="close-add" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  
                    <button id="user-privi-save-change" type="submit" form="edit-user-privi-from-modal" class="btn btn-primary">Save Change</button>
                  </div>
                </div>
              </div>
            </div>

<?php
	include 'includes/Html/footer.php';
}else{
	Redirect::to('../login.php');
}