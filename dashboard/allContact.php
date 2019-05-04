<?php
require_once 'core/init.php';


$user = new User();



if($user->isLoggedIn()){
	if($user->data()->group_id == 0 || $user->data()->group_id == 1){

		$pageTite = 'All Contact';
	$token = Token::generate();
	include 'includes/Html/header.php';
	include 'includes/Html/navbar.php';

	?>

		<section class="all-contact">
      	
	      	<div class="container " id="search-form">
	            <div class="input-group mb-3">
	              <div class="input-group-prepend">
	                <span class="input-group-text" id="inputGroup-sizing-default">Search</span>
	              </div>
	              <input type="search" class="form-control" id="search" placeholder="Enter First Name Or Last Name Or Phone Number To Search">
	            </div>
	            
	              <div class="export-btn">
	                <form action="../api/export.php" method="post" id="ex">
	                	
	                    <input type="hidden" name="op" value="create-excel">
	                    <input type="hidden" name="data" value="" id="ex-data"> 
	                    <button type="submit" id="create-excel" class="btn">Create Excel File</button>
	                </form>
	                
	                
	                <form action="../api/export.php" method="post" id="pdf">
	                	
	                    <input type="hidden" name="op" value="exportPDF">
	                    <input type="hidden" name="data" value="" id="pdf-data" > 
	                    <button type="submit" id="create-pdf" class="btn" >Create PDF File</button>
	                </form>
	                
	                <button id="print-btn" class="btn" onclick="printTable();">Print</button>
	                
	                
	            </div>
	            
	            <table class="table table-bordered" id="all-data" >
	                <thead>
	                	<th scope="col" style="border: 1px solid #dee2e6;" class='edit-delete'>Contact Image</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Full Name</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Phone</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Home Phone</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">BirthDate</th>
	                    <th scope="col" style="border: 1px solid #dee2e6;">Location</th>
	        <?php

	        
	        if($user->data()->group_id == 0){
	                    echo '<th scope="col" style="border: 1px solid #dee2e6;" class="edit-delete">Edit | Delete</th>';
	        }elseif($user->data()->group_id == 1){

	        	$privilige = $user->privilige();
	        	if($privilige->user_edit == 1 && $privilige->user_delete == 1){

		         echo '<th scope="col" style="border: 1px solid #dee2e6;" class="edit-delete">Edit | Delete</th>';

		        }elseif($privilige->user_edit == 1 && !$privilige->user_delete == 1){

		        	echo '<th scope="col" style="border: 1px solid #dee2e6;" class="edit-delete">Edit</th>';

		        }elseif(!$privilige->user_edit == 1 && $privilige->user_delete == 1){

		        	echo '<th scope="col" style="border: 1px solid #dee2e6;" class="edit-delete">Delete</th>';

		        }
	        }

	        ?>
	                </thead>
	                <tbody id="Contact-data">
	                  
	                </tbody>
	            </table>
	            <nav style="text-align: center;">
				  <ul class="pagination justify-content-center" id="pagination">
				    
				  </ul>
				</nav>
	                
	            
	          
	        </div>
	          
	    </section>
	            <div class="modal fade " id="EditContact" tabindex="-1" role="dialog" aria-labelledby="EditContactModalTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="EditContactModalTitle">Edit Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" >
    				<form id="edit-contact-form" class="" action="" method="post">
    					
    				</form>
                  </div>
                  <div class="modal-footer">
                    <button id="close-add" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="save-contact-change" type="submit" class="btn btn-primary" form="edit-contact-form">Save Change</button>
                  </div>
                </div>
              </div>
            </div>


	<?php
		include 'includes/Html/footer.php';

	}else{
		Redirect::to('index.php');
	}	
		
	
	
}else{
	Redirect::to('../login.php');
}

?>