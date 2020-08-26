<?php
require_once __DIR__ . '/Common.php';

class Shmixit extends Common {
	
	private $serviceUser;

	public function index(): void
    {
        $userService = new Services\User();
	    $this->tplData['user'] = $this->user;
	    $this->tplData['rooms'] = (new Services\Room())->getAllRooms();
	    $this->tplData['users'] = $userService->getAll();
//        $this->vd($this->tplData['availableRooms']);exit;

        $this->display('index.tpl');
	}

    public function room(): void
    {
//	    $model = new Models\Room();
//	    $data = $model->getRooms();
//	    $this->vd($data);
//	    exit;
    }
}