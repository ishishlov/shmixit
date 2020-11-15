<?php

namespace Domain;

class Word
{
    private const MAX_LENGTH_WORD = 20;

    private $word;
    private $errors = [];

    private function __construct(string $word)
    {
        $this->word = $word;
    }

    public static function create(string $word): self
    {
        return new self($word);
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function cutDangerousCharacters(): void
    {
        $this->word = trim($this->word);
        $this->word = preg_replace('/[^0-9а-яА-Яa-zA-ZёЁ,.!?() -]/ui', '', $this->word);
    }

    public function checkLength(): void
    {
        if (!$this->word) {
            $this->errors[] = 'Введите корректное слово';
        }

        if (mb_strlen($this->word) > self::MAX_LENGTH_WORD) {
            $this->errors[] = sprintf('Слишком длинное слово. Уложись в %d символов', self::MAX_LENGTH_WORD);
        }
    }
}
