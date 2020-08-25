<?php
require_once __DIR__ . '/Common.php';

class Shmixit extends Common {
	
	private $_model = null;

	public function index() {
	    $this->_data['name'] = 'Шмиксит!';
        $this->display('index.tpl');
	}

    public function room() {
	    $model = new Models\Room();
	    $data = $model->getRooms();
	    $this->vd($data);
	    exit;
//        $this->display('index.tpl');
    }
}