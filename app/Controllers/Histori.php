<?php namespace App\Controllers;

use App\Models\SensorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Histori extends BaseController
{
	public function index()
	{
		return view('Histori');
	}
}