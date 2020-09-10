<?php

namespace Models;

use PDO;

class Main {

    /** @var PDO|null */
	protected $_db = null;
	/** @var string */
	protected $tableName;
    /** @var string */
	protected $idFieldName;

	public function __construct() {
		if (!$this->_db) {
			$this->_db = (new DB())->getInstance();
		}
	}

    public function get(int $id, bool $multipleRecords = false): array
    {
        $sth = $this->_db->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE ' . $this->idFieldName . ' = ?'
        );
        $sth->execute([$id]);

        return $multipleRecords
            ? $sth->fetchAll(PDO::FETCH_ASSOC)
            : $sth->fetch(PDO::FETCH_ASSOC);
    }

	/**
	 * Метод для мультиинсерта
	 * 
	 * @param string Название таблицы
	 * @param array Массив вставляемых данных, где ключ - название стоблца, значение - значение столбца
	 * @return bool
	 */
	public function insert($tableName, $data) {
		$prepareData = $this->_prepareDataForInsert($data);
		$stmt = $this->_db->prepare('INSERT INTO ' . $tableName . ' (' . $prepareData['titles'] . ') VALUES ' . $prepareData['values']);

		return $stmt->execute($prepareData['executeData']);
	}

	/**
	 * Подготовка данных к мультиинсерту
	 * 
	 * @param array $data
	 * @return array
	 */
	private function _prepareDataForInsert($data) {
	    if (!$data) {
	        return [];
        }

		$titles = implode(', ', array_keys($data[0]));
		$countValues = count($data[0]);
		$countRows = count($data);
		$tempValues = '';
		$values = '';
		$executeData = [];
		for ($i = 0; $i < $countValues; $i++) {
			$separator = $i === ($countValues - 1) ? '' : ',';
			$tempValues .= '?' . $separator;
		}
		for ($i = 0; $i < $countRows; $i++) {
			$separator = $i === ($countRows - 1) ? ';' : ',';
			$values .= '(' . $tempValues . ')' . $separator;
		}

		foreach ($data as $rows) {
			foreach ($rows as $title => $value) {
				$executeData[] = $value !== '' ? $value : null;
			}
		}

		return [
			'titles'		=> $titles,
			'values'		=> $values,
			'executeData'	=> $executeData
		];
	}
}