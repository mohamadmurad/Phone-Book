<?php
/**
* 
*/
function getContactOutPut($result,$userGroup,$privilege){
	$output = '';
	$uploadDirectory = "../public/ContactImages/";
	switch ($userGroup) {
		case 0:
			foreach ($result as $result) {

				$output.= "<tr data-contact-id='".  $result->contact_id   ."'>
								<td scope='row' style='border: 1px solid #dee2e6;    text-align: center;' class='edit-delete'>
									<img class='contact-user' src='". $uploadDirectory . $result->c_image ."' title='Contact user' style='width: 50px;border-radius: 50%;height: 50px;'>
								</td>
		                        <td scope='row' style='border: 1px solid #dee2e6;'>". $result->c_first_name . " " .$result->c_last_name ."</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->mobile_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->phone_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->birthdate . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->location . "</td>
		                        <td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='' data-toggle='modal' data-target='#EditContact'>Edit</a> | <a class='delete-contact'   href=''>Delete</a></td>
		                    </tr>";
			}
			break;
		case 1:

			foreach ($result as $result) {


				$output.= "<tr data-contact-id='".  $result->contact_id   ."'>
								<td scope='row' style='border: 1px solid #dee2e6;    text-align: center;' class='edit-delete'>
									<img class='contact-user' src='". $uploadDirectory . $result->c_image ."' title='Contact user' style='width: 50px;border-radius: 50%;height: 50px;'>
								</td>
	                        <td scope='row' style='border: 1px solid #dee2e6;'>". $result->c_first_name . " " .$result->c_last_name ."</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->mobile_number . "</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->phone_number . "</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->birthdate . "</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->location . "</td>";

	            

				if($privilege->user_edit == 1 && $privilege->user_delete == 1){

		        $output.= "<td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='' data-toggle='modal' data-target='#EditContact'>Edit</a> | <a class='delete-contact'   href=''>Delete</a></td>
			                    </tr>";

		        }elseif($privilege->user_edit == 1 && !$privilege->user_delete == 1){

		        	$output.= "<td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='' data-toggle='modal' data-target='#EditContact'>Edit</a></td>
			                    </tr>";

		        }elseif(!$privilege->user_edit == 1 && $privilege->user_delete == 1){

		        	$output.= "<td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='delete-contact'   href=''>Delete</a></td>
			                    </tr>";

		        }
	        }
			break;
		
		default:
			foreach ($result as $result) {

				$output.= "<tr data-contact-id='".  $result->contact_id   ."'>
								<td scope='row' style='border: 1px solid #dee2e6;    text-align: center;' class='edit-delete'>
									<img class='contact-user' src='". $uploadDirectory . $result->c_image ."' title='Contact user' style='width: 50px;border-radius: 50%;height: 50px;'>
								</td>
		                        <td scope='row' style='border: 1px solid #dee2e6;'>". $result->c_first_name . " " .$result->c_last_name ."</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->mobile_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->phone_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->birthdate . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->location . "</td>
		                        <td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='#' data-toggle='modal' data-target='#EditContact'>Edit</a> | <a class='delete-contact'   href='#'>Delete</a></td>
		                    </tr>";
			}
			break;
	}

	return $output;
}



function getUsersOutPut($result){

	$output = '';

	foreach ($result as $result) {
		$active = ''; $admin='';
		if($result->active == 1){
			$active = 'active';
		}else{
			$active = 'Not active';
		}


		if($result->group_id == 1){
			$admin = 'User';
		}else{
			$admin = 'Admin';
		}



		$output.= "<tr data-contact-id='".  $result->user_id   ."'>
	                <td scope='row' style='border: 1px solid #dee2e6;'>". $result->username . "</td>
	                <td style='border: 1px solid #dee2e6;'>". $active . "</td>
	                <td style='border: 1px solid #dee2e6;'>". $admin . "</td>
	                <td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='btn btn-info user-info-btn' href='#' data-toggle='modal' data-target='#InfoUser'>Info</a> <a class='btn btn-danger deleteUser' href='#'>Delete</a> <a class='btn btn-warning privibtn' href='#' style='color:#fff;' data-toggle='modal' data-target='#Userprivi'>privileges</a></td>
	            </tr>";

	}

	return $output;

}


function getUserInfo($results){

	$output = '';

	

		$output.='<div class="add-input col-md-12">
                    <label>Full Name :</label>
                    <input type="text" id="edit-fullname" name="fullname" class="form-control" value="'. $results->full_name .'" disabled>
                </div>

                <div class="add-input col-md-12">
                    <label>UserName :</label>
                    <input type="text" id="edit-username" name="username" class="form-control" value="'.  $results->username .'" disabled>
                </div>

                <div class="add-input col-md-12 ">
                    <label id="un_lable">Email :</label>
                    <input type="email" id="edit-email" name="email" class="form-control" value="'.  $results->Email .'" disabled>
                   
                </div>


                <div class="add-input col-md-12 ">
                    <label id="un_lable">Join Date : '. $results->join_date .' </label>
                </div>

                <div class="add-input col-md-12 ">
					<label id="un_lable">Acount Type : </label>
	      			<div class="custom-control custom-radio custom-control-inline">
					    <input type="radio" class="custom-control-input" id="admin-radio" name="group_id" value="admin" '. ($results->group_id == 0 ? 'checked' : '') . ' disabled>
					    <label class="custom-control-label" for="admin-radio">Admin</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
					    <input type="radio" class="custom-control-input" id="user-radio" name="group_id" value="user" '. ($results->group_id == 1 ? 'checked' : '') .' disabled>
					    <label class="custom-control-label" for="user-radio">User</label>
					</div> 
				</div>

				 <div class="add-input col-md-12 ">
					<label id="un_lable">Acount State : </label>
	      			<div class="custom-control custom-radio custom-control-inline">
					    <input type="radio" class="custom-control-input" id="active-radio" name="state" value="active" '. ($results->active == 1 ? 'checked' : '') .' disabled>
					    <label class="custom-control-label" for="active-radio">Active</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
					    <input type="radio" class="custom-control-input" id="disabled-radio" name="state" value="disabled" '. ($results->active == 0 ? 'checked' : '') .' disabled>
					    <label class="custom-control-label" for="disabled-radio">Disabled</label>
					</div> 
				</div>
				<input type="hidden" value="'. $results->user_id . '" name="user_id">
				';

	return $output;


}


function getUserPrivilige($result){

	$output='';

	$output.='<div class="add-input col-md-12 ">
		                 	<div class="custom-control custom-checkbox">
							    <input type="checkbox" class="custom-control-input" id="p_add" name="p_add" '. ($result->user_add == 1 ? 'checked' : '') . '>
							    <label class="custom-control-label" for="p_add">Privilege Add Contact</label>
							</div>
						</div>
						<div class="add-input col-md-12 ">
		                 	<div class="custom-control custom-checkbox">
							    <input type="checkbox" class="custom-control-input" id="p_edit" name="p_edit" '. ($result->user_edit == 1 ? 'checked' : '') . '>
							    <label class="custom-control-label" for="p_edit">Privilege Edit Contact</label>
							</div>
						</div>
						<div class="add-input col-md-12 ">
		                 	<div class="custom-control custom-checkbox">
							    <input type="checkbox" class="custom-control-input" id="p_delete" name="p_delete" '. ($result->user_delete == 1 ? 'checked' : '') . '>
							    <label class="custom-control-label" for="p_delete">Privilege Delete Contact</label>
							</div>
						</div>
						<input type="hidden" value="'. $result->user_id . '" name="user_id">';



	return $output;

}

function getInfoForContact($result){

			$output='';
			$output.='
			<div class="add-input col-md-12 col-xs-12" style="text-align: center;margin-bottom: 20px;">
                <img width="100" height="100" class="contact-info-img" src="../public/ContactImages/'. $result->c_image .'" title="contat image">
                
            </div>

			<div class="add-input col-md-6 col-xs-12">
                <label>First Name :</label>
                <input type="text" id="edit-firstname" name="firstName" class="form-control" placeholder="Enter First Name" autocomplete="off" required value="'. $result->c_first_name .'">
            </div>

            <div class="add-input col-md-6 col-xs-12">
                <label>Last Name :</label>
                <input type="text" id="edit-LastName" name="LastName" class="form-control" placeholder="Enter Last Name" autocomplete="off" required value="'. $result->c_last_name .'">
            </div>

            <div class="add-input col-md-6 col-xs-12 ">
                <label id="un_lable">Phone Number :</label>
                <input type="text" id="edit-phone" name="phone" class="form-control" placeholder="Enter Phone Number ex:345xxxx" autocomplete="off" required value="'. $result->phone_number .'">
            </div>

            <div class="add-input col-md-6 col-xs-12">
                <label>Mobile Nuber :</label>
                <input type="tel" id="edit-mobile" name="mobile" class="form-control" placeholder="Enter Mobile ex: +963xxxxxxxxx" required value="'. $result->mobile_number .'">
            </div>
            <div class="add-input col-md-6 col-xs-12">
                <label>BirthDay :</label>
                <input type="date" id="edit-birth" name="birth" class="form-control" required value="'. $result->birthdate .'">
            </div>
            <div class="add-input col-md-6 col-xs-12">
                <label>Location :</label>
                <input type="text" id="edit-location" name="location" class="form-control" placeholder="Enter Location ex: Damascus" required value="'. $result->location .'">
            </div>
            <div class="add-input col-md-12">
		        <label>Contact Photo :</label>
				<input type="file" class="file-input" id="customFile" name="c_image">
			</div>
            <input type="hidden" value="'. $result->contact_id .'" id="edit-cid" name="cid">
             <input type="hidden" value="'. $result->c_image .'" id="old-image" name="old-image">';

			return $output;
}

function getInfoForContactSearch($result,$userGroup,$privilege){

	$output = '';
	$uploadDirectory = "../public/ContactImages/";
	switch ($userGroup) {
		case 0:
			foreach ($result as $result) {

				$output.= "<tr data-contact-id='".  $result->contact_id   ."'>
								<td scope='row' style='border: 1px solid #dee2e6;    text-align: center;' class='edit-delete'>
									<img class='contact-user' src='". $uploadDirectory . $result->c_image ."' title='Contact user' style='width: 50px;border-radius: 50%;height: 50px;'>
								</td>
		                        <td scope='row' style='border: 1px solid #dee2e6;'>". $result->c_first_name . " " .$result->c_last_name ."</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->mobile_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->phone_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->birthdate . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->location . "</td>
		                        <td style='border: 1px solid #dee2e6;' class='edit-delete' ><a class='edit-btn' href='' data-toggle='modal' data-target='#EditContact'>Edit</a> | <a class='delete-contact'   href=''>Delete</a></td>
		                    </tr>";
			}
			break;
		case 1:

			foreach ($result as $result) {


				$output.= "<tr data-contact-id='".  $result->contact_id   ."'>
								<td scope='row' style='border: 1px solid #dee2e6;    text-align: center;' class='edit-delete'>
									<img class='contact-user' src='". $uploadDirectory . $result->c_image ."' title='Contact user' style='width: 50px;border-radius: 50%;height: 50px;'>
								</td>
	                        <td scope='row' style='border: 1px solid #dee2e6;'>". $result->c_first_name . " " .$result->c_last_name ."</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->mobile_number . "</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->phone_number . "</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->birthdate . "</td>
	                        <td style='border: 1px solid #dee2e6;'>". $result->location . "</td>";

	            

				if($privilege->user_edit == 1 && $privilege->user_delete == 1){

		        $output.= "<td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='' data-toggle='modal' data-target='#EditContact'>Edit</a> | <a class='delete-contact'   href=''>Delete</a></td>
			                    </tr>";

		        }elseif($privilege->user_edit == 1 && !$privilege->user_delete == 1){

		        	$output.= "<td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='' data-toggle='modal' data-target='#EditContact'>Edit</a></td>
			                    </tr>";

		        }elseif(!$privilege->user_edit == 1 && $privilege->user_delete == 1){

		        	$output.= "<td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='delete-contact'   href=''>Delete</a></td>
			                    </tr>";

		        }
	        }
			break;
		
		default:
			foreach ($result as $result) {

				$output.= "<tr data-contact-id='".  $result->contact_id   ."'>
								<td scope='row' style='border: 1px solid #dee2e6;    text-align: center;' class='edit-delete'>
									<img class='contact-user' src='". $uploadDirectory . $result->c_image ."' title='Contact user' style='width: 50px;border-radius: 50%;height: 50px;'>
								</td>
		                        <td scope='row' style='border: 1px solid #dee2e6;'>". $result->c_first_name . " " .$result->c_last_name ."</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->mobile_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->phone_number . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->birthdate . "</td>
		                        <td style='border: 1px solid #dee2e6;'>". $result->location . "</td>
		                        <td style='border: 1px solid #dee2e6;' class='edit-delete'><a class='edit-btn' href='#' data-toggle='modal' data-target='#EditContact'>Edit</a> | <a class='delete-contact'   href='#'>Delete</a></td>
		                    </tr>";
			}
			break;
	}

	return $output;
}
