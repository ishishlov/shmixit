<?php

namespace Domain;

class User
{
    private const MIN_NAME_LENGTH = 3;
    private const MAX_NAME_LENGTH = 20;

    private $userId;
    private $name;
    private $avatar;

    private const BLACK_LIST_USER_NAMES = ['гость'];

    public function __construct(?int $userId = null, ?string $name = null, ?string $avatar = '')
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->avatar = $avatar;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name ?: 'Гость';
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function isGuest(): bool
    {
        return !(bool) $this->userId;
    }

    public function isEqual(int $userId): bool
    {
        return $userId === $this->userId;
    }

    public function cutDangerousCharacters(): void
    {
        $this->name = trim($this->name);
        $this->name = preg_replace('/[^0-9а-яА-Яa-zA-ZёЁ,.!?() -]/ui', '', $this->name);
    }

    public function validateName(string $name): string
    {
        if (!$name) {
            return 'Введите корректное имя';
        }

        $nameLength = mb_strlen($name);
        if ($nameLength < self::MIN_NAME_LENGTH || $nameLength > self::MAX_NAME_LENGTH) {
            return sprintf('Имя должно содержать от %d до %d корректных символов', self::MIN_NAME_LENGTH, self::MAX_NAME_LENGTH);
        }

        if (in_array(mb_strtolower($name), self::BLACK_LIST_USER_NAMES, true)) {
            return sprintf('Имя %s недоступно для сохранения', $name);
        }

        return '';
    }
}
