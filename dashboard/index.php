<?php
require_once 'core/init.php';


$user = new User();



if($user->isLoggedIn()){

	

	if($user->data()->group_id == 0){
		$pageTite = 'Dashboard';
		$token = Token::generate();
		include 'includes/Html/header.php';
		include 'includes/Html/navbar.php';
		// admins
		?>
		<section class="all-contact">
			<div class="row">
	          <div class="col-xl-3 col-sm-6 mb-3">
	            <div class="card text-white bg-primary o-hidden h-100">
	              <div class="card-body">
	                <div class="card-body-icon">
	                  <i class="fas fa-fw fa-comments"></i>
	                </div>
	                <div class="mr-5">26 New Messages!</div>
	              </div>
	              <a class="card-footer text-white clearfix small z-1" href="#">
	                <span class="float-left">View Details</span>
	                <span class="float-right">
	                  <i class="fas fa-angle-right"></i>
	                </span>
	              </a>
	            </div>
	          </div>
	          <div class="col-xl-3 col-sm-6 mb-3">
	            <div class="card text-white bg-warning o-hidden h-100">
	              <div class="card-body">
	                <div class="card-body-icon">
	                  <i class="fas fa-fw fa-list"></i>
	                </div>
	                <div class="mr-5">11 New Tasks!</div>
	              </div>
	              <a class="card-footer text-white clearfix small z-1" href="#">
	                <span class="float-left">View Details</span>
	                <span class="float-right">
	                  <i class="fas fa-angle-right"></i>
	                </span>
	              </a>
	            </div>
	          </div>
	          <div class="col-xl-3 col-sm-6 mb-3">
	            <div class="card text-white bg-success o-hidden h-100">
	              <div class="card-body">
	                <div class="card-body-icon">
	                  <i class="fas fa-fw fa-shopping-cart"></i>
	                </div>
	                <div class="mr-5">123 New Orders!</div>
	              </div>
	              <a class="card-footer text-white clearfix small z-1" href="#">
	                <span class="float-left">View Details</span>
	                <span class="float-right">
	                  <i class="fas fa-angle-right"></i>
	                </span>
	              </a>
	            </div>
	          </div>
	          <div class="col-xl-3 col-sm-6 mb-3">
	            <div class="card text-white bg-danger o-hidden h-100">
	              <div class="card-body">
	                <div class="card-body-icon">
	                  <i class="fas fa-fw fa-life-ring"></i>
	                </div>
	                <div class="mr-5">13 New Tickets!</div>
	              </div>
	              <a class="card-footer text-white clearfix small z-1" href="#">
	                <span class="float-left">View Details</span>
	                <span class="float-right">
	                  <i class="fas fa-angle-right"></i>
	                </span>
	              </a>
	            </div>
	          </div>
	        </div>
		</section>


		<?php
		include 'includes/Html/footer.php';
		echo 'Admin';
		
	}else if($user->data()->group_id == 1){
		// user

		Redirect::to('allContact.php');

		
	}

	
}else{
	Redirect::to('../login.php');
}

?>