<?php
/**
* 
*/
class Validate{

	private $_passed = false,
			$_errors = array(),
			$_db = null,
			$_imgae_Extensions = ['jpeg','jpg','png'],
			$_max_img_size = 2000000;
	
	function __construct(){

		$this->_db = DB::getInstance();
		
	}

	public function check($source , $items = array()){

		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {

				

				if($rule === 'file'){

						$fileName = $rule_value['name'];
					    $fileSize = $rule_value['size'];
					    $fileTmpName  = $rule_value['tmp_name'];
					    //$fileType = $rule_value['type'];
					    $fileExtension = explode('.',$fileName);
					    $fileExtension = strtolower(end($fileExtension));

					    if (! in_array($fileExtension,$this->_imgae_Extensions)) {
				            
				            $this->addError("This file extension is not allowed. Please upload a JPEG or PNG file");
				        } 
				        if ($fileSize > $this->_max_img_size) {
				           
				            $this->addError("This file is more than 2MB. Sorry, it has to be less than or equal to 2MB");
				        }

				        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
					    // Check MIME Type by yourself.
					    $finfo = new finfo(FILEINFO_MIME_TYPE);
					    if (false === $ext = array_search(
					        $finfo->file($fileTmpName),
					        array(
					            'jpg' => 'image/jpeg',
					            'png' => 'image/png',
					            'gif' => 'image/jpg',
					        ),
					        true
					    )) {
					        $this->addError("This file extension is not allowed.");
					    }

				}else{

					$value = trim($source[$item]);
					$item = escape($item);

					if($rule === 'required' && empty($value)){
						$this->addError($item.' is required');
					}else{
						switch ($rule) {
							case 'min':{

								if(strlen($source[$item]) < $rule_value){
									$this->addError($item . ' must be minimum of '. $rule_value . ' characters.');
								}
							}
								
								break;

							case 'max':{

								if(strlen($source[$item]) > $rule_value){
									$this->addError($item . ' must be maximum of '. $rule_value . ' characters.');
								}
							}
								
								break;
							case 'unique':{
								$check = $this->_db->get($rule_value,array($item,'=',$value));

								if($check->count()){

									$this->addError($item . ' alredy exists ');

								}
							}
								
								break;

							case 'unique_to_owner':{
								$check = $this->_db->get($rule_value,array($item,'=',$value));

								if($check->count()){
									if($check->first()->user_id != Sesstion::get(Config::get('session/session_name'))){
										$this->addError($item . ' alredy exists ');
									}

									

								}
							}
								
								break;

							case 'correct_old_pass':{
								$check = $this->_db->get('users',array('user_id','=',$rule_value));

								if($check->count()){
									
									if($check->first()->password !== Hash::make($source['oldpass'], $check->first()->salt)){
										$this->addError($item . ' old Pass error ');
									}
								}
							}
								
								break;

							case 'matches':{
								if($value != $source[$rule_value]){
									$this->addError($rule_value . ' must match '. $item . ' characters.');
								}
							}
								
								break;
							
							default:
								
								break;
						}

					}

				}


				

				
				
			}
			
		}

		if(empty($this->_errors)){
			$this->_passed = true;
		}

		return $this;

	}

	private function addError($error){

		$this->_errors[] = $error;

	}

	public function errors(){

		return $this->_errors;
	}

	public function passed(){ return $this->_passed;}
}