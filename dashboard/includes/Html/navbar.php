

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" style="height: auto; overflow: unset;border-bottom: 2px solid #f9cf26;">
  <a class="navbar-brand" href="#">
    <img src="<?php echo Config::get("target/images"); ?>Phonebook-icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
    <?php echo $pageTite; ?>
      
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      

      <?php
      


        if($user->data()->group_id == 0){
            // admins
            
            echo '<li class="nav-item">
                  <a class="nav-link" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manageUsers.php">Manage Users</a>
                 </li>';
            echo '<li class="nav-item">
                    <a class="nav-link" href="addContact.php">Add Contact</a>
                  </li>';
            echo '<li class="nav-item">
                    <a class="nav-link" href="allContact.php">All Contact</a>
                  </li>
                  ';

          }else if($user->data()->group_id == 1){

            // user
            $privilige = $user->privilige();

            if($privilige->user_add == 1){
              echo '<li class="nav-item">
                    <a class="nav-link" href="addContact.php">Add Contact</a>
                  </li>';
            }
            

          }

      ?>
      
    </ul>
    <ul class=" navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $user->data()->full_name; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="    right: 0 !important;left: auto;">
          <a class="dropdown-item" href="profile.php">Profile</a>
          <a class="dropdown-item" href="changePassword.php">change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li> 

    </ul>
    
   
  </div>
</nav>