<?php

require_once __DIR__ . '/Common.php';

class Shmixit extends Common
{

	public function index(): void
    {
        $userService = new Services\User();

	    $this->tplData['user'] = $this->user;
	    $this->tplData['rooms'] = (new Services\Room())->getAllRooms();
	    $this->tplData['users'] = $userService->getAll();
        $this->display('index.tpl');
	}
}
