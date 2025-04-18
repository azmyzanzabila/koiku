<?php

namespace App\Models;

use CodeIgniter\Model;

class SensorModel extends Model
{
	protected $table      = 'sensor'; // Nama tabel
	protected $primaryKey = 'id'; // Primary key tabel

	// Kolom yang diizinkan untuk diisi
	protected $allowedFields = ['turbidity', 'pH', 'tds', 'created_at'];

	// Menggunakan auto increment
	protected $useAutoIncrement = true;

	// Tipe data yang dikembalikan
	protected $returnType = 'array';

	// Tidak menggunakan timestamps
	protected $useTimestamps = false;
}
