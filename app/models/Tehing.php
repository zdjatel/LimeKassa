<?php

class Tehing extends DB\SQL\Mapper{
	
	public function __construct(DB\SQL $db) {
        parent::__construct($db,'tehing');
    }


    // Specialized query
	public function listByCity() {
        
		//return $this->select('doknr',null,array('order'=>'doknr DESC', 'limit' => 1));
		//return $this->find("doknr",array('order'=>'doknr DESC', 'limit'=>1));
        
        $this->load(
         null,
            [
                'order'=>'doknr DESC',
                'limit'=>1
            ]
        );
		// We could have done the same thing with plain vanilla SQL:
		// return $this->db->exec(
		// 	'SELECT "doknr" FROM tehing'.
        //     'ORDER BY doknr DESC;'
            
        // );
        return $this->query;
		
	}

    public function all() {
        $this->load();
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    public function getByName($name) {
        $this->load(array('username=?', $name));
    }

    public function add() {
        $this->copyFrom('POST');
        $this->save();
    }

    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array('id=?',$id));
        $this->erase();
    }
}