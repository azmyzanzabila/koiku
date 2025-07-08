<?php namespace App\Controllers;

use App\Models\SensorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Histori extends BaseController
{
	public function index()
	{
		$SensorModel = new SensorModel();

		$data['sensors'] = $SensorModel->findAll();

		return view('histori', $data);
	}

	public function getData()
	{
		$sensorModel = new SensorModel();
		$data = $sensorModel->findAll();

		return $this->response->setJSON($data);
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

	public function history()
	{
		$sensorModel = new SensorModel();
		$data['sensorData'] = $sensorModel->orderBy('created_at', 'DESC')->findAll();

		return view('histori', $data);
	}
}