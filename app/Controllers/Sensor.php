<?php

namespace App\Controllers;

use App\Models\SensorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Sensor extends BaseController
{
	public function index()
	{
		$SensorModel = new SensorModel();

		// Ambil semua data sensor dari database
		$data['sensors'] = $SensorModel->findAll();

		// Kirim data ke view
		return view('sensor', $data);
	}

	public function viewSensor($id)
	{
		$SensorModel = new SensorModel();

		$data['sensor'] = $SensorModel->find($id);

		if (!$data['sensor']) {
			throw PageNotFoundException::forPageNotFound();
		}

		return view('data_detail', $data);
	}

	public function getData()
	{
		$SensorModel = new SensorModel();
		$data = $SensorModel->findAll();

		return $this->response->setJSON($data);
	}
}
