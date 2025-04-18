<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table      = 'user'; // Nama tabel
	protected $primaryKey = 'id'; // Primary key tabel

	// Kolom yang diizinkan untuk diisi
	protected $allowedFields = ['name', 'email', 'password'];

	// Menggunakan auto increment
	protected $useAutoIncrement = true;

	// Tipe data yang dikembalikan
	protected $returnType = 'array';

	// Menggunakan timestamps (created_at)
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';

	// Hash password sebelum disimpan ke database
	protected $beforeInsert = ['hashPassword'];
	protected $beforeUpdate = ['hashPassword'];

	protected function hashPassword(array $data)
	{
		if (isset($data['data']['password'])) {
			$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
		}
		return $data;
	}
}
