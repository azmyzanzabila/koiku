<?php namespace App\Controllers;

use App\Models\PompaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pompa extends BaseController
{
	public function index()
	{
		$PompaModel = new PompaModel();

		// Ambil semua data pompa dari database
		$data['pompa'] = $PompaModel->findAll();

		// Kirim data ke view
		return view('pompa', $data);
	}

	public function viewPompa($id)
	{
		$PompaModel = new PompaModel();

		// Ambil data pompa berdasarkan ID
		$data['pompa'] = $PompaModel->find($id);

		// Tampilkan 404 error jika data tidak ditemukan
		if (!$data['pompa']) {
			throw PageNotFoundException::forPageNotFound();
		}

		return view('data_detail', $data);
	}
}
