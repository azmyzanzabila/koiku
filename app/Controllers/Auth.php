<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
	public function signup()
	{
		// Check if user is already logged in
		$session = session();
		if ($session->get('login')) {
			// If already logged in, redirect to dashboard
			return redirect()->to('/signup');
		}

		// Tampilkan form sign-up
		return view('signup');
	}

	public function showLogin()
	{
		// Tampilkan form login
		return view('login');
	}

	// public function store()
	// {
	// 	// Validasi input
	// 	$rules = [
	// 		'nama' => 'required|min_length[3]|max_length[255]',
	// 		'email' => 'required|valid_email|max_length[255]|is_unique[user.email]',
	// 		'password' => 'required|min_length[8]|max_length[255]',
	// 	];

	// 	if (!$this->validate($rules)) {
	// 		// Jika validasi gagal, kembalikan ke form sign-up dengan pesan error
	// 		return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
	// 	}

	// 	// Simpan data ke database
	// 	$userModel = new UserModel();
	// 	$userModel->save([
	// 		'nama' => $this->request->getPost('nama'),
	// 		'email' => $this->request->getPost('email'),
	// 		'password' => $this->request->getPost('password'),
	// 	]);

	// 	// Redirect ke halaman login dengan pesan sukses
	// 	return redirect()->to('/login')->with('success', 'Sign-up successful! Please log in.');
	// }

	public function login()
	{
		$session = session();
		$model = new UserModel();

		// Get form data
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		// Find user by email
		$user = $model->where('email', $email)->first();

		// Verify user exists and password matches
		if ($user) {
			$pass = $user['password'];
			$verify_pass = password_verify($password, $pass);

			if ($verify_pass) {
				$ses_data = [
					'id'       => $user['id'],
					'nama'     => $user['nama'],
					'email'    => $user['email'],
					'logged_in'     => TRUE
				];
				$session->set($ses_data);

				// Redirect to sensor dashboard after successful login
				return redirect()->to('/sensor');
			} else {
				$session->setFlashdata('error', 'Password salah, silakan masukkan password ulang!');
				return redirect()->to('/login');
			}
		} else {
			$session->setFlashdata('error', 'Email salah, silakan masukkan email ulang!');
			return redirect()->to('/login');
		}
	}

	public function logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to('/login');
	}
}
