<?php

require_once __DIR__ . '/Common.php';

class Shmixit extends Common
{

	public function index(): void
    {
        $this->processRequest(function () {
            $userService = new Services\User();

            $this->tplData['user'] = $this->user;
            $this->tplData['rooms'] = (new Services\Room())->getAllRooms();
            $this->tplData['users'] = $userService->getAll()->toArray();
        });

        $this->display('index.tpl');
	}
}
