<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
	public function signup()
	{
		// Tampilkan form sign-up
		return view('signup');
	}

	public function store()
	{
		// Validasi input
		$rules = [
			'nama' => 'required|min_length[3]|max_length[255]',
			'email' => 'required|valid_email|max_length[255]|is_unique[user.email]',
			'password' => 'required|min_length[8]|max_length[255]',
		];

		if (!$this->validate($rules)) {
			// Jika validasi gagal, kembalikan ke form sign-up dengan pesan error
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		// Simpan data ke database
		$userModel = new UserModel();
		$userModel->save([
			'nama' => $this->request->getPost('nama'),
			'email' => $this->request->getPost('email'),
			'password' => $this->request->getPost('password'),
		]);

		// Redirect ke halaman login dengan pesan sukses
		return redirect()->to('/login')->with('success', 'Sign-up successful! Please log in.');
	}
}
