<?php

require_once __DIR__ . '/Common.php';

class User extends Common
{
	private $_userService = null;

	public function __construct()
    {
        parent::__construct();
        $this->_userService = new Services\User();
    }

    public function create(): void
    {
	    $this->tplData['name'] = 'Шмиксит!';
        $this->display('index.tpl');
	}

    public function delete(): void
    {

    }

    public function addUser(): void
    {
        $answer = $this->_userService->save((string) $_POST['name']);

        $this->toJson($answer);
    }

    public function logIn(): void
    {
        $answer = $this->_userService->logIn((int) $_POST['userId']);

        $this->toJson($answer);
    }

    public function logOut(): void
    {
        $answer = $this->_userService->logOut((string) $_POST['name']);

        $this->toJson($answer);
    }
}
