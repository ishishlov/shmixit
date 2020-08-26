<?php
require_once __DIR__ . '/Common.php';

class Shmixit extends Common {
	
	private $serviceUser;

	public function index(): void
    {
        $userService = new Services\User();
	    $this->tplData['userName'] = $this->user->getName();
	    $this->tplData['availableRooms'] = (new Services\Room())->getAvailableRooms();
	    $this->tplData['users'] = $userService->getAll();

        $this->display('index.tpl');
	}

    public function room(): void
    {
	    $model = new Models\Room();
	    $data = $model->getRooms();
	    $this->vd($data);
	    exit;
    }
}