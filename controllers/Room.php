<?php

require_once __DIR__ . '/Common.php';

use Services\Room as RoomService;

class Room extends Common
{
    /**
     * @var RoomService
     */
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new RoomService();
    }

    public function create(): void
    {
        $answer = $this->service->createRoom($this->user, (string) $_POST['room_name']);

        $this->toJson($answer);
    }

    public function connecting(): void
    {
        $data = $this->service->connecting($this->user, (int) $_GET['id']);
        $this->appendTplData($data);

        $this->display('room.tpl');
    }

    public function update(): void
    {
        $answer = $this->service->update($this->user, (int) $_POST['room_id']);

        $this->toJson($answer);
    }

    public function start(): void
    {
        $answer = $this->service->start($this->user, (int) $_POST['room_id']);

        $this->toJson($answer);
    }
}
