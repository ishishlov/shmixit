<?php

use Domain\Word;
use Services\Game as GameService;
use Services\RequestData\GetData;
use Services\RequestData\RequestData;

class Game extends Common
{
    /** @var GameService  */
    private $gameService;

    public function __construct()
    {
        parent::__construct();
        $this->gameService = new GameService();
    }

    public function play(): void
    {
        $gameId = GetData::get('game_id', RequestData::INT) ?: 0;
        $answer = $this->gameService->getGameProcess($this->user, $gameId);
        $this->appendTplData($answer);

        $this->display('play.tpl');
    }

    public function update(): void
    {
        $errors = [];
        if (!$this->isAjax()) {
            $errors[] = 'Ooops, something wrong';
        }
        $gameId = GetData::get('game_id', RequestData::INT) ?: 0;
        $status = GetData::get('status', RequestData::INT) ?: 0;
        $lastRoundStatus = $this->gameService->getLastRoundStatus($gameId);

        if ($status === $lastRoundStatus) {
            $response = $this->gameService->getResponse(false, $this->user, $errors);
            $this->toJson($response);
        }

        $this->toJson($this->gameService->getGameProcess($this->user, $gameId, true, $errors));
    }

    public function makeWord(): void
    {
        if (!$this->isAjax()) {
            return;
        }

        $word = Word::create($_POST['word']);
        $this->gameService->saveWord($word);

        $this->toJson(['errors' => $word->getErrors()]);
    }
}
