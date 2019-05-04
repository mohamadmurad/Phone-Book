<?php

/**
* 
*/


class Contacts{

	private $_db;
	
	function __construct(){

		$this->_db = DB::getInstance();
		
	}

	public function create($filds = array()){
		if(!$this->_db->insert('contacts',$filds)){
			throw new Exception("ther was a problem Adding Contact");
			return false;
		}

		return true;

		
	}
}