<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Services\User;
use Services\Auth;

class Common
{
    /** @var array  */
	protected $tplData = [];
	/** @var User */
	protected $user;

	public function __construct()
    {
        $this->processRequest(function () {
            $userId = (new Auth())->getUserId();
            $this->user = (new User())->get($userId);
            $this->tplData['currentUser'] = $this->user;
        });

    }

    public function display($template) {
		$twig = new Twig\Environment(new Twig\Loader\FilesystemLoader('views/tpl'));
		$twig->display($template, $this->tplData);
	}

	protected function processRequest($callback): void
    {
        try {
            $callback();
        } catch (Throwable $e) {
            trigger_error($e->getMessage());
            $this->tplData['pageError'] = $e->getMessage();
        }
    }

    protected function ajaxProcessRequest($callback): void
    {
        try {
            $callback();
        } catch (Throwable $e) {
            trigger_error($e->getMessage());
            $this->tplData['pageError'] = $e->getMessage();
        }
    }

	protected function toJson($data): void
    {
		print(json_encode($data));
		exit;
	}

	protected function appendTplData(array $data): void
    {
        $this->tplData = array_merge($this->tplData, $data);
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

	public function dd($data): void
    {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}

	public function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
