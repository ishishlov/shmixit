<?php
require_once __DIR__ . '/Common.php';

class User extends Common {
	
	private $_model = null;

	public function __construct()
    {
        $this->_model = new Models\User();
    }

    public function create(): void
    {
	    $this->tplData['name'] = 'Шмиксит!';
        $this->display('index.tpl');
	}

    public function delete(): void
    {

    }
}