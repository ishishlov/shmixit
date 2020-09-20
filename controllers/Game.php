<?php

use Services\Game as GameService;

class Game extends Common
{
    public function play(): void
    {
        $gameService = new GameService();
        $this->tplData['game'] = $gameService->getGame();

        $this->display('play.tpl');
    }

    public function update(): void
    {

    }
}