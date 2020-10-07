<?php

namespace Models;

use Domain\Card;

class Cards {

    private const CARDS_DIR = __DIR__ . '/../views/image/card';
    private const EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * @return Card[]
     */
    public function getAllCards(): array
    {
        $fileNames = scandir(self::CARDS_DIR);

        $cards = [];
        foreach ($fileNames as $fileName) {
            $idAndExt = explode('.', $fileName);
            if (isset($idAndExt[0], $idAndExt[1]) && in_array($idAndExt[1], self::EXTENSIONS, true)) {
                $id = (int) $idAndExt[0];
                $ext = '.' . $idAndExt[1];

                $cards[] = Card::create($id, $ext);
            }
        }

        return $cards;
    }
}
