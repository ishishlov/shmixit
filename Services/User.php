<?php

namespace Services;

use Exception;
use Models\Users as Model;
use Domain\User as Domain;

class User
{
    /** @var Model model */
    private $model;
    /** @var Auth authService */
    private $authService;

    public function __construct()
    {
        $this->model = new Model();
        $this->authService = new Auth();
    }

    public function get(?int $userId): Domain
    {
        if(!$userId) {
            return new Domain();
        }

        $user = (new Model())->get($userId);
        if (!$user) {
            return new Domain();
        }

        return new Domain($user['user_id'], $user['name'], $user['avatar']);
    }

    /**
     * @param array|null $userIds
     * @return Domain[]
     */
    public function getByIds(?array $userIds): array
    {
        if(!$userIds) {
            return [];
        }
        $users = $this->model->getByIds($userIds);

        return $this->map($users);
    }

    /**
     * @return Domain[]
     */
    public function getAll(): array
    {
        $users = $this->model->getAll();

        return $this->map($users);
    }

    public function save($name): array
    {
        $user = new Domain(null, $name);
        $user->cutDangerousCharacters();
        $error = $user->validateName($user->getName());
        if ($error) {
            return $this->getAnswer($error);
        }

        $isNameExist = $this->model->isNameExist($name);
        if ($isNameExist) {
            return $this->getAnswer('Такое имя уже существует. Придумайте другое');
        }

        try {
            $this->model->save($user);
            $this->authService->logIn($user->getUserId());
        } catch (Exception $e) {
            $error = ('Error save - ' . $e->getMessage());
        }

        return $this->getAnswer($error);
    }

    public function logIn(int $userId): array
    {
        if ($userId) {
            $this->authService->logIn($userId);
            return $this->getAnswer();
        }

        return $this->getAnswer('Ошибка при авторизации');
    }

    public function logOut(): array
    {
        $this->authService->logOut();

        return $this->getAnswer();
    }

    /**
     * @param array $data
     * @return Domain[]
     */
    private function map(array $data): array
    {
        $users = [];
        foreach ($data as $user) {
            $users[] = new Domain($user['user_id'], $user['name'], $user['avatar']);
        }

        return $users;
    }

    private function getAnswer(?string $error = ''): array
    {
        return [
            'error' => $error ?: '',
            'result' => $error ? false : true
        ];
    }
}
