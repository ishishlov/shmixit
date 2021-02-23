<?php

require_once __DIR__ . '/Common.php';

use Services\RequestData\RequestData;
use Services\RequestData\PostData;
use Services\RequestData\GetData;
use Services\Room as RoomService;

class Room extends Common
{
    /**
     * @var RoomService
     */
    private $service;

    private const TEMPLATE_NAME = 'room.tpl';

    public function __construct()
    {
        parent::__construct();
        $this->service = new RoomService();
    }

    public function create(): void
    {
        $this->ajaxProcessRequest(function () {
            $answer = $this->service->createRoom(
                $this->user,
                PostData::get('room_name')
            );

            $this->toJson($answer);
        });
    }

    public function connecting(): void
    {
        $this->processRequest(function () {
            $data = $this->service->connecting(
                $this->user,
                GetData::get('id', RequestData::INT));
            $this->appendTplData($data);
        });

        $this->display(self::TEMPLATE_NAME);
    }

    public function update(): void
    {
        $this->ajaxProcessRequest(function () {
            $answer = $this->service->update(
                $this->user,
                PostData::get('room_id', RequestData::INT)
            );

            $this->toJson($answer);
        });

    }

    public function leave(): void
    {
        $this->ajaxProcessRequest(function () {
            $answer = $this->service->leave(
                $this->user,
                PostData::get('user_id', RequestData::INT),
                PostData::get('room_id', RequestData::INT)
            );

            $this->toJson($answer);
        });
    }

    public function gameStart(): void
    {
        $this->ajaxProcessRequest(function () {
            $answer = $this->service->gameStart(
                $this->user,
                PostData::get('room_id', RequestData::INT)
            );

            $this->toJson($answer);
        });
    }
}
