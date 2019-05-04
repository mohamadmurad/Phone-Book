<?php
/**
* 
*/
class User {
	
	private $_db,
			$_data = null,
			$_sesstion_name,
			$_cookie_name,
			$_cookie_expiry,
			$_isLoggedIn,
			$_privilige;

	function __construct($user = null){
		$this->_db = DB::getInstance();
		$this->_sesstion_name = Config::get('session/session_name');
		$this->_cookie_name = Config::get('remember/cookie_name');
		$this->_cookie_expiry = Config::get('remember/cookie_expiry');

		if(!$user){

			if(Sesstion::exists($this->_sesstion_name)){
				$user = Sesstion::get($this->_sesstion_name);
				if($this->find($user)){
					$this->_isLoggedIn = true;
					$this->get_privileges($user);
				}else{
					// logout
				}
			}

		}else{
			$this->find($user);
		}
	}

	public function create($filds = array() ,$privilige = array()){
		if(!$this->_db->insert('users',$filds)){
			throw new Exception("ther was a problem creating an acount");
		}

		$p = array('user_id' => $this->_db->pdo()->lastInsertId());
		$privilige+= $p;
		if(!$this->_db->insert('user_privileges',$privilige)){
			throw new Exception("ther was a problem creating an acount");
		}
	}

	private function find($user = null){

		if($user){
			$fild = (is_numeric($user)) ? 'user_id' : 'username';
			$data = $this->_db->get('users',array($fild,'=',$user));

			if($data ->count()){
				$this->_data = $data->first();
				return true;
			}

			return false;
		}

	}

	public function login($username = null,$password = null,$remember = false){
		

		if(!$username && !$password && $this->exists()){

			Sesstion::put($this->_sesstion_name,$this->data()->user_id);

		}else{


			$user = $this->find($username);

			if($user){
				
				if($this->data()->password === Hash::make($password, $this->data()->salt)){
				//

					if($this->data()->confirmed == 1){

						if($this->data()->active == 1){

							

							Sesstion::put($this->_sesstion_name,$this->data()->user_id);

							if($remember){

								$hash = Hash::unique();
								$hashcheck = $this->_db->get('user_sesstion',array('user_id','=',$this->data()->user_id));

								if(!$hashcheck->count()){

									$this->_db->insert('user_sesstion',array(
										'id' => NULL,
										'user_id' => $this->data()->user_id ,
										'hash'    => $hash ,
									));

								}else{

									$hash = $hashcheck->first()->hash;

								}

									
								Cookie::put($this->_cookie_name,$hash,$this->_cookie_expiry);

							}

							return true;



						}else{
							return 'active';
						}

					}else{
						return 'confirm';
					}

					
				//	
				}
			}
		}

		return false;
	}

	public function confirm($username = null , $hash = null){
		if($username && $hash){
			$data = $this->_db->query('SELECT * FROM users WHERE username = ? AND confirm_hash = ?',array(
				'username' => $username,
				'confirm_hash' => $hash,
			));



			if($data->count()){

				$data = $data->first();

				if($data->confirmed == 0){

					$this->_db->update('users',array(
						'id_field_name' => 'user_id',
						'id_value'=> $data->user_id,
					),array(
						'confirmed' => 1,
					));
					
					
					if(!$this->_db->error()){
						
						return true;
					}
				}
				
			}

		}

		return false;
	}


	public function Resend($username){

		if($username){
			$data = $this->_db->query('SELECT * FROM users WHERE username = ?',array(
				'username' => $username,
				
			));



			if($data->count()){

				$data = $data->first();

				if($data->confirmed == 0){

					$url = $_SERVER['HTTP_HOST'] . '/phoneOOP/confirm.php?un=' . $username . '&ch='.$data->confirm_hash;

                    $message = '<html><body>';
                    $message.= 'hello ' . $data->full_name ;
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
      

                    Mail::send($data->Email,'Telephone Book | Confirm Email',$message,$headers);
                    return true;
                   
				
				}
				
			}

		}

		return false;

	}

	public function Send_reset_password($email){

		if($email){
			$data = $this->_db->query('SELECT * FROM users WHERE Email = ?',array(
				'Email' => $email,
				
			));



			if($data->count()){

				$data = $data->first();

				$resetHash = md5(Input::get('email')).Hash::unique();

				$this->_db->update('users',array(
						'id_field_name' => 'user_id',
						'id_value'=> $data->user_id,
					),array(
						'recover_hash' => $resetHash,
					));

					$url = $_SERVER['HTTP_HOST'] . '/phoneOOP/reset.php?un=' . $data->username . '&ch='.$resetHash;

                    $message = '<html><body>';
                    $message.= 'hello ' . $data->full_name ;
                    $message.= '<p welcome to Telephone Book </p>';
                    $message.= '<p>We receve Request to reset your Passeord</p>';
                    $message.= '<p><a target="_blank" href="' . $url . '">Reset Password</a></p>';
                    $message.= '</body></html>';
                    
					$headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                     
                    // Create email headers
                    $headers .= 'From: telephoneBook@syad.com'."\r\n".
                        'Reply-To: telephoneBook@syad.com'."\r\n" .
                        'X-Mailer: PHP/' . phpversion();
      

                    Mail::send($data->Email,'Telephone Book | Reset Password',$message,$headers);
                    return true;
                   
				
				
				
			}else{
				return 'notFound';
			}


		}

		return false;



	}

	public function resetpass($username,$hash,$password){

		if($username && $hash){
			$data = $this->_db->query('SELECT * FROM users WHERE username = ? AND recover_hash = ?',array(
				'username' => $username,
				'recover_hash' => $hash,
			));



			if($data->count()){

				$data = $data->first();

				$salt = Hash::salt(32);

				$this->_db->update('users',array(
						'id_field_name' => 'user_id',
						'id_value'=> $data->user_id,
					),array(
						'password' => Hash::make($password,$salt),
						'salt'	   => $salt,
						'recover_hash' => '',
					));


				if(!$this->_db->error()){
						
					return true;
				}
				
			}

		}

		return false;


	}

	public function get_privileges($uid){


		$data = $this->_db->get('user_privileges',array("user_id",'=',$uid));

			if($data->count()){

				$this->_privilige = $data->first();
				return true;
			}

			return false;
	}


	public function updateInfo($fullname, $username, $email){

		if($fullname && $username && $email){
			if( $this->_db->update('users',array(
				'id_field_name' => 'user_id',
		 		'id_value' => $this->data()->user_id,
			),array(
				'full_name' =>$fullname,
				'Email'		=>$email,
				'username'	=>$username,

			))){
				return true;
			}
		}
		return false;

	}	

	public function updatePass($pass,$salt){

		if($pass && $salt){
			if( $this->_db->update('users',array(
				'id_field_name' => 'user_id',
		 		'id_value' => $this->data()->user_id,
			),array(
				'password' =>Hash::make($pass,$salt),
				

			))){
				return true;
			}

		}
		return false;
	}


	private function set_privileges($uid,$add,$edit,$delete){

	}

	public function privilige(){
		return $this->_privilige;
	}
	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function logout(){

		$this->_db->delete('user_sesstion',array('user_id','=',$this->data()->user_id));
		Sesstion::delete($this->_sesstion_name);
		Cookie::delete($this->_cookie_name);
	}


	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}


}


