<?php

namespace App\Controllers;

use App\Models\PompaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pompa extends BaseController
{
	public function index()
	{
		$pompaModel = new PompaModel();
		$data['pompa'] = $pompaModel->findAll();
		return view('pompa', $data);
	}

	public function viewPompa($id)
	{
		$pompaModel = new PompaModel();
		$data['pompa'] = $pompaModel->find($id);

		if (!$data['pompa']) {
			throw PageNotFoundException::forPageNotFound();
		}

		return view('data_detail', $data);
	}

	public function getData()
	{
		$pompaModel = new PompaModel();
		$tigaDetikLalu = date('Y-m-d H:i:s', strtotime('-3 seconds'));

		$data = $pompaModel->where('waktu >=', $tigaDetikLalu)
			->orderBy('waktu', 'ASC')
			->findAll();

		return $this->response->setJSON($data);
	}

	public function kontrolPompa()
	{
		$pompaModel = new PompaModel();
		$status = $this->request->getPost('status') ? 1 : 0;

		$mode = $pompaModel->getMode();
		if ($mode['mode'] === 'auto') {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Tidak dapat mengontrol pompa dalam mode otomatis'
			]);
		}

		if ($pompaModel->update(1, ['statusPompa' => $status])) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Status pompa berhasil diperbarui'
			]);
		}

		return $this->response->setJSON([
			'success' => false,
			'message' => 'Gagal memperbarui status pompa'
		]);
	}

	public function kontrolValve()
	{
		$pompaModel = new PompaModel();
		$status = $this->request->getPost('status') ? 1 : 0;

		$mode = $pompaModel->getMode();
		if ($mode['mode'] === 'auto') {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Tidak dapat mengontrol valve dalam mode otomatis'
			]);
		}

		if ($pompaModel->update(1, ['statusValve' => $status])) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Status valve berhasil diperbarui'
			]);
		}

		return $this->response->setJSON([
			'success' => false,
			'message' => 'Gagal memperbarui status valve'
		]);
	}

	public function setMode()
	{
		$mode = $this->request->getPost('mode');
		$pompaModel = new PompaModel();
		$status = $this->request->getPost('status') ? 1 : 0;

		if (!in_array($mode, ['auto', 'manual'])) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Mode tidak valid'
			]);
		}

		if ($pompaModel->update(1, ['statusPompa' => $status])) {
			return $this->response->setJSON([
				'success' => true,
				'message' => "Mode diubah ke $mode"
			]);
		}

		return $this->response->setJSON([
			'success' => false,
			'message' => 'Gagal mengubah mode'
		]);
	}

	public function getMode()
	{
		$pompaModel = new PompaModel();
		$mode = $pompaModel->getMode();
		return $this->response->setJSON($mode ?? ['mode' => 'manual']);
	}
}
