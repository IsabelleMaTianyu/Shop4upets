<?php
// Class that provides methods for working with the form data.
// There should be NOTHING in this file except this class definition.

class SimpleController3 {
	private $mapper;
	private $quizmapper;

	public function __construct() {
		global $f3;						// needed for $f3->get()
		$this->mapper = new DB\SQL\Mapper($f3->get('DB'),"simpleModel");	// create DB query mapper object
		// for the "simpleModel" table
		$this->quizmapper = new DB\SQL\Mapper($f3->get('DB'),"simpleQuiz");	// create DB query mapper object
		// for the "simpleModel" table
	}

	public function putIntoDatabase($data) {
		$this->mapper->name = $data["name"];					// set value for "name" field
		$this->mapper->colour = $data["colour"];				// set value for "colour" field
		$this->mapper->gender = $data["gender"];				// set value for "gender" field
		$this->mapper->save();									// save new record with these fields
	}

	public function getData() {
		$list = $this->mapper->find();
		return $list;
	}

	public function getQuiz() {
		$list = $this->quizmapper->find();
		return $list;
	}
	public function getQuizVals() {
		$list = $this->quizmapper->find();
		$vals = array();
		foreach ($list as $row) {
			$arr = $this->quizmapper->cast($row);
			array_push($vals, $arr);
		}
		return $vals;
	}

	public function putIntoQuiz($data)
	{
		$this->quizmapper->question = $data["question"];
		$this->quizmapper->a1 = $data["a1"];
		$this->quizmapper->a2 = $data["a2"];
		$this->quizmapper->a3 = $data["a3"];
		$this->quizmapper->a4 = $data["a4"];
		$this->quizmapper->correct = $data["correct"];
		$this->quizmapper->image = $data["image"];
		$this->quizmapper->save();                                    // save new record with these fields
	}

	public function deleteFromDatabase($idToDelete) {
		$this->mapper->load(['id=?', $idToDelete]);				// load DB record matching the given ID
		$this->mapper->erase();									// delete the DB record
	}

}

?>
