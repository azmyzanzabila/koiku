<?php namespace App\Controllers;

use App\Models\SensorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Sensor extends BaseController
{
	public function index()
	{
		$SensorModel = new SensorModel();

		// Ambil semua data sensor dari database
		$data['sensor'] = $SensorModel->findAll();

		// Kirim data ke view
		return view('sensor', $data);
	}

	public function viewSensor($id)
	{
		$SensorModel = new SensorModel();

		// Ambil data sensor berdasarkan ID
		$data['sensor'] = $SensorModel->find($id);

		// Tampilkan 404 error jika data tidak ditemukan
		if (!$data['sensor']) {
			throw PageNotFoundException::forPageNotFound();
		}

		return view('data_detail', $data);
	}
}
