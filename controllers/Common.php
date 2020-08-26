<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Services\User;
use Services\Auth;

class Common {
    /** @var array  */
	protected $tplData = [];
	/** @var User */
	protected $user;

	public function __construct()
    {
//        setcookie('user_id', 1, time() + 3600);
        $userId = (new Auth())->getUserId();
        $this->user = (new User())->get($userId);
    }

    public function display($template) {
		$twig = new Twig\Environment(new Twig\Loader\FilesystemLoader('views/tpl'));
		$twig->display($template, $this->tplData);
	}

	public function toJson($data): void
    {
		print(json_encode($data));
		exit;
	}

	/**
	 * Привести вложенность массива к числу
	 * 
	 * @param array $data
	 * @return array Description
	 */
	public function arrayToInt($data): array
    {
		if (is_array($data)) {
			foreach ($data as &$value) {
				$value = (int) $value;
			}
		}
		return $data;
	}

	public function vd($data): void
    {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}
}