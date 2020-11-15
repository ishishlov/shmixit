<?php

use Domain\Word;
use Services\Game as GameService;

class Game extends Common
{
    /** @var GameService  */
    private $gameService;

    public function __construct()
    {
        parent::__construct();
        $this->gameService = new GameService($this->user);
    }

    public function play(): void
    {
        $answer = $this->getAnswer();
        foreach ($answer as $key => $data) {
            $this->tplData[$key] =$data;
        }

        $this->display('play.tpl');
    }

    public function update(): void
    {
        $errors = [];
        if (!$this->isAjax()) {
            $errors[] = 'Ooops, something wrong';
        }

        $this->toJson($this->getAnswer($errors));
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

    private function getAnswer(?array $errors = []): array
    {
        $gameId = 1;
        $game = $this->gameService->getGameProcess($this->user, $gameId);

        return [
            'myMove' => false,
            'word' => '',
            'round' => 1,
            'action' => 1,
            'guest' => false,
            'players' => [],
            'cards' => 0,
            'errors' => $errors
        ];
    }
}
