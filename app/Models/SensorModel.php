<?php

namespace App\Models;

use CodeIgniter\Model;

class SensorModel extends Model
{
	protected $table         = 'sensor';
	protected $primaryKey    = 'id';
	protected $allowedFields = ['turbidity', 'pH', 'tds'];
	protected $useAutoIncrement = true;
	protected $returnType    = 'array';
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';

	// Validation rules
	protected $validationRules = [
		'turbidity' => 'permit_empty|numeric',
		'pH' => 'permit_empty|numeric',
		'tds' => 'permit_empty|numeric'
	];

	protected $validationMessages = [
		'turbidity' => [
			'numeric' => 'Nilai turbidity harus berupa angka'
		],
		'pH' => [
			'numeric' => 'Nilai pH harus berupa angka'
		],
		'tds' => [
			'numeric' => 'Nilai TDS harus berupa angka'
		]
	];

	protected $skipValidation = false;

	/**
	 * Get the latest sensor reading
	 * 
	 * @return array
	 */
	public function getLatestReading()
	{
		return $this->orderBy('created_at', 'DESC')
			->first();
	}

	/**
	 * Get sensor readings within date range
	 * 
	 * @param string $startDate
	 * @param string $endDate
	 * @return array
	 */
	public function getReadingsByDateRange($startDate, $endDate)
	{
		return $this->where('created_at >=', $startDate)
			->where('created_at <=', $endDate)
			->orderBy('created_at', 'ASC')
			->findAll();
	}
}
