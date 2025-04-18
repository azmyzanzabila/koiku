<?php

namespace App\Models;

use CodeIgniter\Model;

class PompaModel extends Model
{
	protected $table = 'pompa';
	protected $primaryKey = 'id';
	protected $allowedFields = ['statusPompa', 'statusValve'];
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
}
