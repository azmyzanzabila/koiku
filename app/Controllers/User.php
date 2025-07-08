<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class User extends BaseController
{
    public function index()
    {
        // Buat objek model $userModel
        $UserModel = new UserModel();

        // Ambil semua data pengguna
        $data['users'] = $UserModel->findAll();

        // Kirim data ke view
        return view('user', $data);
    }
    public function create()
    {
        // Menyiapkan data untuk view
        $data = [
            'title' => 'Tambah User Baru',
            'validation' => \Config\Services::validation() // Untuk validasi form
        ];

        // Menampilkan view form create user
        return view('/signup', $data);
    }
    public function store()
    {
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|max_length[100]|is_unique[user.email]',
            'password' => 'permit_empty|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Siapkan data untuk disimpan
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Jika password diisi, hash password
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Simpan ke database
        $model = new \App\Models\UserModel();
        $model->insert($data);

        // Redirect dengan pesan sukses
        return redirect()->to('/login')->with('message', 'User berhasil ditambahkan');
    }

    // public function store()
    // {
    //     // Validasi input
    //     $rules = [
    //         'nama' => 'required|min_length[3]|max_length[255]',
    //         'email' => 'required|valid_email|max_length[255]|is_unique[user.email]',
    //         'password' => 'required|min_length[8]|max_length[255]',
    //     ];

    //     if (!$this->validate($rules)) {
    //         // Jika validasi gagal, kembalikan ke form sign-up dengan pesan error
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Simpan data ke database
    //     $userModel = new UserModel();
    //     $userModel->save([
    //         'nama' => $this->request->getPost('nama'),
    //         'email' => $this->request->getPost('email'),
    //         'password' => $this->request->getPost('password'),
    //     ]);

    //     // Redirect ke halaman login dengan pesan sukses
    //     return redirect()->to('/login')->with('success', 'Sign-up successful! Please log in.');
    // }
    
    public function viewUser($id)
    {
        $UserModel = new UserModel();
        // Ambil data pengguna berdasarkan ID
        $data['user'] = $UserModel->find($id);

        // Tampilkan 404 error jika data tidak ditemukan
        if (!$data['user']) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('user_detail', $data);
    }
}
