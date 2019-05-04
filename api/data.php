<?php

	require_once 'core/init.php';
	header('Content-Type: text/html; charset=utf-8');
	$temp = new User();

	$total_req_per_page = 10;
	if($temp->isLoggedIn()){

		if(Input::exists()){
      		


			$headers = apache_request_headers();
	
			if (isset($headers['CsrfToken'])) {
				
			    if ($headers['CsrfToken'] !== $_SESSION[Config::get('session/token_name')]) {
			        exit();
			    }else{

			    	if(Input::get('op')){

			    		$op = Input::get('op');
			    		switch ($op) {
			    				case 'get-pages':{
			    				
									$data = DB::getInstance()->query('SELECT count(*) AS total FROM contacts');
			    					echo ceil($data->first()->total/$total_req_per_page);	
			    					
			    						
			    					
			    					
			    				}
			    						
			    					break;
			    				case 'get-data':{
			    					if(Input::get('page')){
			    						$start = (Input::get('page') - 1) * $total_req_per_page;

			    						$data = DB::getInstance()->query('SELECT * FROM contacts LIMIT ' . $start . ' , ' . $total_req_per_page);

			    						$output = getContactOutPut($data->results(),$temp->data()->group_id,$temp->privilige());

			    						echo $output;


			    					}else{
			    						exit();
			    					}

			    			
			    					
			    				}
			    					
			    					break;
			    				case 'get-pages-users':{
			    					if($temp->isLoggedIn()){
			    						$data = DB::getInstance()->query('SELECT count(*) AS total FROM users');
			    						echo ceil($data->first()->total/$total_req_per_page);
			    					}else{exit();}
			    						
			    				}
								break;

								case 'get-data-users':{
									if(Input::get('page')){
			    						$start = (Input::get('page') - 1) * $total_req_per_page;

			    						$data = DB::getInstance()->query('SELECT * FROM users LIMIT ' . $start . ' , ' . $total_req_per_page);


			    						$output = getUsersOutPut($data->results());

			    						echo $output;


			    					}else{
			    						exit();
			    					}
								}
									
									break;

								case 'get-user-info':{
									if(Input::get('cid')){

										$data = DB::getInstance()->get('users',array('user_id','=',Input::get('cid')));

										$output = getUserInfo($data->first());

										echo $output;

									}else{
			    						exit();
			    					}


								}
									
									break;

								case 'get-user-privi':{
									if(Input::get('cid')){

										$data = DB::getInstance()->get('user_privileges',array('user_id','=',Input::get('cid')));

										$output = getUserPrivilige($data->first());

										echo $output;

									}else{
			    						exit();
			    					}
								}
									
									break;

								case 'update-user-privi':{

									$filedss= array(
										'user_add' 		=> (Input::get('p_add') == 'on') ? 1 : 0,
										'user_edit' 	=> (Input::get('p_edit') == 'on') ? 1 : 0,
										'user_delete'   => (Input::get('p_delete') == 'on') ? 1 : 0,
										

									);

									if(DB::getInstance()->update('user_privileges',array(
									 		'id_field_name' => 'user_id',
									 		'id_value' => Input::get('user_id')
									 		),
									 		$filedss)){
										echo 'true';
									}else{
										echo "false";
									}
								}
									
									break;

								case 'update-user-info':{

									$filedss= array(
										'full_name' => Input::get('fullname'),
										'username'  => Input::get('username'),
										'Email'		=> Input::get('email'),
										'active'	=> (Input::get('state') == 'disabled') ? 0 : 1,
										'group_id'	=> (Input::get('group_id') == 'admin') ? 0 : 1,

									);

									if(DB::getInstance()->update('users',array(
									 		'id_field_name' => 'user_id',
									 		'id_value' => Input::get('user_id')
									 		),
									 		$filedss)){
										echo 'true';
									}else{
										echo "false";
									}	
								}
									
									break;


								case 'delete-user':{


									if(DB::getInstance()->delete('user_privileges',array('user_id','=',Input::get('cid')))){
										if(DB::getInstance()->delete('users',array('user_id','=',Input::get('cid')))){
											echo 'true';
										}else{
											echo "false";
										}
									}else{
											echo "false";
										}
								}
									
									break;

								case 'delete-contact':{
									$privilige = $temp->privilige();

									if($temp->data()->group_id == 0 || ( $temp->data()->group_id == 1 && $privilige->user_delete ==1 )){

										if(Input::get('cId')){
											if(DB::getInstance()->delete('contacts',array('contact_id','=',Input::get('cId')))){
												echo "true";
											}else{
												echo "del";
											}
										}else{
											echo "cid";
										}

									}else{
										echo "pri";
									}		
								}
									
									break;

								case 'get-contact-info':{
									$privilige = $temp->privilige();

									if($temp->data()->group_id == 0 || ( $temp->data()->group_id == 1 && $privilige->user_edit ==1 )){

										if(Input::get('cid')){
											$data = DB::getInstance()->get('contacts',array('contact_id','=',Input::get('cid')));

											$output = getInfoForContact($data->first());

											echo $output;

												
										
										}else{
											echo "cid";
										}

									}else{
										echo "pri";
									}
									
								}
									
									break;

								case 'update-contact-info':{

									$privilige = $temp->privilige();

									if($temp->data()->group_id == 0 || ( $temp->data()->group_id == 1 && $privilige->user_edit ==1 )){

										if(Input::get('cid')){
												
											

											$fileName = $_FILES['c_image']['name'];
											
							                try {

							                	if($fileName){
							                		$fileTmpName  = $_FILES['c_image']['tmp_name'];
							                		//$currentDir = getcwd();
						    						$uploadDirectory = "../public/ContactImages/";
						    						$fileExtension = explode('.',$fileName);
											   		$fileExtension = strtolower(end($fileExtension));
											   		$fileNameOnServer = md5(Hash::unique() . $temp->data()->salt) .'.' . $fileExtension;
							                		$uploadPath =   $uploadDirectory . $fileNameOnServer;

								                		
								                	if(move_uploaded_file($fileTmpName, $uploadPath)){
								                		if(Input::get('old-image') != 'avatar.png')
								                			unlink(Input::get('old-image'));
								                		if(DB::getInstance()->update('contacts',array(
														 		'id_field_name' => 'contact_id',
														 		'id_value' => Input::get('cid')
														 		),
														 		array(
										                       
										                        'c_first_name'    => Input::get('firstName'),
										                        'c_last_name' => Input::get('LastName'),
										                        'phone_number' => Input::get('phone'),
										                        'mobile_number'=> Input::get('mobile'),
										                        'birthdate'     => Input::get('birth'),
										                        'location'    => Input::get('location'),
										                        'c_image'	=>       $fileNameOnServer  ,              
										                        'user_id'		=> $temp->data()->user_id ,
										                    ))){

															echo 'true';
														}else{
															echo "false";
														}

								                	}

							                	}else{

							                		if(DB::getInstance()->update('contacts',array(
														 		'id_field_name' => 'contact_id',
														 		'id_value' => Input::get('cid')
														 		),
														 		array(
										                       
										                        'c_first_name'    => Input::get('firstName'),
										                        'c_last_name' => Input::get('LastName'),
										                        'phone_number' => Input::get('phone'),
										                        'mobile_number'=> Input::get('mobile'),
										                        'birthdate'     => Input::get('birth'),
										                        'location'    => Input::get('location'),
										                                    
										                        'user_id'		=> $temp->data()->user_id ,
										                    ))){

															echo 'true';
														}else{
															echo "false";
														}

							                	}
							                	
							                	

							                    

							                    
							                } catch (Exception $e) {
							                    die($e->getMessage());
							                }

												
										
										}else{
											echo "cid";
										}

									}else{
										echo "pri";
									}
									
								}
									
									break;

								case 'get-search-results':{

									if(Input::get('val')){

										$data = DB::getInstance()->query('SELECT * FROM contacts WHERE c_first_name LIKE ? OR c_last_name LIKE ? OR mobile_number LIKE ? ',array(
																							'c_first_name' 	=> '%'.Input::get('val').'%',
																							'c_last_name'	=> '%'.Input::get('val').'%',
																							'mobile_number' => '%'.Input::get('val').'%',
																								));
										$count = $data->count();
										
										if($count > 0){

											$output = getInfoForContactSearch($data->results(),$temp->data()->group_id,$temp->privilige());
										
											echo $output;
											
										}else{
											echo "<tr><td colspan='6' class='text-center'>No Data Found</td></tr>";
										}
										

										

											
									
									}else{
										echo "cid";
									}

									
									
								}
									
									break;
								

			    				default:
			    					
			    					exit();
			    					break;
			    					
			    			}	

      				}

			    	
			    

			    }

			} else {
			    
			    exit();
			}
      	}
      
    }else{

      exit();
    }