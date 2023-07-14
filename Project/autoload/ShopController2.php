<?php

class ShopController2
{
    private $mapper;

    public function __construct($table)
    {
        global $f3;						// needed for $f3->get()
        $this->mapper = new DB\SQL\Mapper($f3->get('DB'), $table);	// create DB query mapper object

    }


    public function putIntoDatabase($data)
    {
        $this->mapper->id   = $data["id"];
        $this->mapper->title = $data["title"];
        $this->mapper->thumbnail = $data["thumbnail"];
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

    public function findkeyword($keyword)
    {
        $list = $this->mapper->find(["title LIKE ?", "%" .$keyword . "%"]);
        return $list;
    }



}