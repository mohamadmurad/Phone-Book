<?php
/**
* 
*/
class DB {

	private static $_instance = null;
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0;
	
		private function __construct(){
			$op = array(
		        PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',
		    );
			$dsn = "mysql:host=" . Config::get('mysql/host') . ";dbname=". Config::get('mysql/db');
			try{

				$this->_pdo = new PDO($dsn,Config::get('mysql/username'),Config::get('mysql/password'),$op);


				
			//$this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			}catch(PDOException $e){
				die($e->getMessage());
			}}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new DB();
			}
			return self::$_instance;}


		/*
		*	
		*query("UPDATE `users` SET username = ? WHERE user_id = 14",array(
		*	'username' => 'mamar',
		*	));
		*
		*/	
		public function query($sql, $params =  array(0)){

			$this->_error = false;
			if($this->_query = $this->_pdo->prepare($sql)){
				$x = 1;
				if(count($params)){

					foreach ($params as $param) {
						$this->_query->bindValue($x,$param);
						$x++;


					}
				}
				if($this->_query->execute()){

				
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();


				}else{

					$this->_error = true;
				}
			}


			return $this;
		}

		/*
		 * action('SELECT Email ','users',array('user_id','=',11));
		 *
		 */
		public function action($action,$table,$where=array()){
			if(count($where) === 3){

				$operators = array('=','>','<','>=','<=');
				$field 		= $where[0];
				$operator 	= $where[1];
				$value 		= $where[2];


				if(in_array($operator, $operators)){

					$sql = $action . " FROM ". $table . " WHERE " . $field . " " . $operator ." ?" ;
		
					if(!$this->query($sql,array($value))->error()){

						return $this;

					}


				}
			}

			return false;
		}

		/*
		 *
		 * get('users',array('user_id','=',11));
		 *
		 */

		public function get($table,$where){return $this->action("SELECT * ", $table , $where);}

		/*
		 * delete('users',array('user_id','=',22));
		 *
		 */
		public function delete($table,$where){return $this->action("DELETE ", $table , $where);}

		/*
		 * insert('users',array(
		 *		'user_id' => NULL,
		 *		'username' => 'mddaram',
		 *		'password' => sha1('123'),
		 *		'Email'		=> 'd@sdd.com',
		 *		'full_name' => 'fdfd',
		 *		));
		 */
		public function insert($table,$fields = array()){

			if(count($fields)){

				$keys = array_keys($fields);
				$values = null;
				$x = 1;

				foreach ($fields as $field) {
					$values.= "?";
					if($x < count($fields)){
						$values.= ', ';
					}
					$x++;
				}
				$sql = "INSERT INTO ". $table ." (`" . implode('`,`', $keys) . "`) VALUES (". $values .")";
				

				
				

				if(!$this->query($sql,$fields)->error()){
				
					return $this;
				}
				

			}
			return false;

		}

		/*
		 * update('users',array(
		 *		'id_field_name' => 'user_id',
		 *		'id_value' => 14
		 *		),
		 *		array(
		 *		'username'	=> 'martgtttam',
		 *	));
		 */
		public function update($table,$id = array() , $fields =  array()){

			if(count($fields)){

				$set = '';
				$x = 1;

				foreach ($fields as $name => $value) {
					$set.= $name .' = ? ';
					if($x < count($fields)){
						$set.= ', ';
					}
					$x++;
				}

				$sql = "UPDATE `". $table ."` SET " . $set . " WHERE " . array_values($id)[0] . " = " . array_values($id)[1];
				
				
				if(!$this->query($sql,$fields)->error()){
				
					return $this;
				}
				

			}
			return false;

		}

		public function results(){return $this->_results;}

		public function first(){return $this->results()[0];}

		public function error(){return $this->_error;}

		public function count(){return $this->_count;}


		public function pdo(){ return $this->_pdo;}
}