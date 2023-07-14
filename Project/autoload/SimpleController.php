<?php
// Class that provides methods for working with the form data.
// There should be NOTHING in this file except this class definition.

class SimpleController {
	private $mapper;
    private $loginMapper;//login

	public function __construct($table)
    {
		global $f3;						// needed for $f3->get()
		$this->mapper = new DB\SQL\Mapper($f3->get('DB'), $table);	// create DB query mapper object
        $this->loginMapper = new DB\SQL\Mapper($f3->get('DB'), $table);//登陆
	}


	public function putIntoDatabase($data)
	{
		$this->mapper->name   = $data["name"];
		$this->mapper->colour = $data["colour"];
        $this->mapper->comment = $data["comment"];
        $this->mapper->number = $data["number"];
        $this->mapper->address1 = $data["address1"];
        $this->mapper->address2 = $data["address2"];
        $this->mapper->city = $data["city"];
        $this->mapper->country = $data["country"];
        $this->mapper->postcode = $data["postcode"];
		$this->mapper->save();					 // save new record with these fields
	}

	public function getData()
    {
		return $this->mapper->find();
	}

	public function deleteFromDatabase($idToDelete)
    {
		$this->mapper->load(['id=?', $idToDelete]); // load DB record matching the given ID
		$this->mapper->erase();						// delete the DB record
	}
    public function loginUser($user,$pwd)
    {
        $auth= new \Auth($this->loginMapper, array('id'=>'username','pw'=>'password')); // fields in table
        return $auth->login($user,$pwd);						// return true on successful login
    }//登陆
}