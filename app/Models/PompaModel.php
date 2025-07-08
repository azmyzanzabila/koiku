<?php

namespace App\Models;

use CodeIgniter\Model;

class PompaModel extends Model
{
	protected $table            = 'pompa';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $allowedFields    = ['statusPompa', 'statusValve', 'mode'];
	protected $useTimestamps    = false;

	protected $validationRules = [
		'mode'         => 'permit_empty|in_list[auto,manual]',
		'statusPompa'  => 'permit_empty|integer|in_list[0,1]',
		'statusValve'  => 'permit_empty|integer|in_list[0,1]',
	];

	protected $validationMessages = [
		'mode' => [
			'in_list'  => 'Mode harus "auto" atau "manual"',
		],
		'statusPompa' => [
			'integer'   => 'Status pompa harus berupa angka',
			'in_list'   => 'Status pompa harus 0 atau 1',
		],
		'statusValve' => [
			'integer'   => 'Status valve harus berupa angka',
			'in_list'   => 'Status valve harus 0 atau 1',
		],
	];

	protected $skipValidation = false;

	public function getStatus()
	{
		$row = $this->find(1);
		if (!$row) {
			return [
				'statusPompa' => 0,
				'statusValve' => 0,
			];
		}
		return [
			'statusPompa' => (int) $row['statusPompa'],
			'statusValve' => (int) $row['statusValve'],
		];
	}

	public function getMode()
	{
		$row = $this->select('mode')->find(1);
		return $row ?? ['mode' => 'manual'];
	}

	public function setMode($mode)
	{
		return $this->update(1, ['mode' => $mode]);
	}
}
