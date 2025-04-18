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

    //------------------------------------------------------------

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
