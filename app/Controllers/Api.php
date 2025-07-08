<?php

namespace App\Controllers;

use App\Models\SensorModel;
use App\Models\PompaModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    protected $sensorModel;
    protected $pompaModel;
    protected $validation;

    public function __construct()
    {
        $this->sensorModel = new SensorModel();
        $this->pompaModel = new PompaModel();
        $this->validation = \Config\Services::validation();
    }

    public function controlPompa()
    {
        $rules = [
            'mode' => 'required|in_list[auto,manual]',
            'statusPompa' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        $mode = $this->request->getPost('mode');
        $statusPompa = $this->request->getPost('statusPompa');

        $currentMode = $this->pompaModel->getMode();
        if ($currentMode && $currentMode['mode'] === 'auto') {
            return $this->fail("Tidak dapat mengontrol pompa dalam mode otomatis");
        }

        try {
            // (Simulasi hardware jika diperlukan)

            $success = $this->pompaModel->update(1, ['statusPompa' => $statusPompa]);

            if (!$success) {
                throw new \RuntimeException('Gagal update status pompa');
            }

            return $this->respond([
                'success' => true,
                'message' => ucfirst($mode) . ' pompa ' . ($statusPompa ? 'diaktifkan' : 'dinonaktifkan')
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengontrol pompa: ' . $e->getMessage());
        }
    }

    public function status()
    {
        $pompaStatus = $this->pompaModel->getStatus();
        $modeData = $this->pompaModel->getMode();

        return $this->respond([
            'success' => true,
            'data' => [
                'statusPompa' => $pompaStatus['statusPompa'],
                'statusValve' => $pompaStatus['statusValve'],
                'mode' => $modeData['mode'] ?? 'manual'
            ]
        ]);
    }

    public function postSensor()
    {
        $input = $this->request->getPost() ?: $this->request->getJSON(true);

        $rules = [
            'turbidity' => 'required|string',
            'pH' => 'required|string',
            'tds' => 'required|string',
            'statusPompa' => 'required|in_list[0,1]',
            'statusValve' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validation->getErrors());
        }

        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            $sensorData = [
                'turbidity' => $input['turbidity'],
                'pH' => $input['pH'],
                'tds' => $input['tds']
            ];
            $this->sensorModel->insert($sensorData);

            // Update pompa (id = 1)

            if ($input['mode'] != "manual") {
                $this->pompaModel->update(1, [
                    'statusPompa' => $input['statusPompa'],
                    'statusValve' => $input['statusValve']
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                throw new \Exception('Transaksi gagal, data tidak disimpan');
            } else {
                $db->transCommit();
            }

            $statusPompa = $this->pompaModel->getStatus();
            $statusMode = $this->pompaModel->getMode();

            return $this->respondCreated([
                'status' => true,
                'message' => 'Data sensor dan status pompa berhasil disimpan',
                'data' => [
                    'sensor' => $sensorData,
                    'pompa' => [
                        'statusPompa' => (int) $statusPompa['statusPompa'],
                        'statusValve' => (int) $statusPompa['statusValve']
                    ],
                    'mode' => $statusMode['mode']
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Sensor data error: ' . $e->getMessage());
            return $this->failServerError('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function getLatestSensorData()
    {
        $data = $this->sensorModel->orderBy('created_at', 'DESC')->first();

        return $this->respond([
            'success' => true,
            'data' => $data
        ]);
    }

    public function updateMode()
    {
        $input = $this->request->getJSON();
        if (!isset($input->mode) || !in_array($input->mode, ['auto', 'manual'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mode tidak valid'
            ]);
        }

        $pompaModel = new \App\Models\PompaModel();
        $update = $pompaModel->update(1, [
            'statusPompa' => 0,
            'statusValve' => 0,
            'mode' => $input->mode
        ]);

        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Mode berhasil diubah'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengubah mode'
        ]);
    }

    public function updatePompa()
    {
        $input = $this->request->getJSON();

        $pompaModel = new \App\Models\PompaModel();

        $update = $pompaModel->update(1, [
            $input->kolom => $input->status
        ]);

        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pompa berhasil diubah'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengubah pompa'
        ]);
    }

    public function mode()
    {
        $data = $this->request->getJSON();

        if (!isset($data->mode)) {
            return $this->fail('Mode tidak ditemukan');
        }

        $success = $this->pompaModel->setMode($data->mode);

        if ($success) {
            return $this->respond(['success' => true, 'message' => 'Mode berhasil']);
        } else {
            return $this->fail('Gagal menyimpan mode');
        }
    }

    public function pompa()
    {
        $data = $this->request->getJSON();

        if (!isset($data->statusPompa)) {
            return $this->fail('Status pompa tidak ditemukan');
        }

        $currentMode = $this->pompaModel->getMode();
        if ($currentMode['mode'] === 'auto') {
            return $this->fail('Tidak bisa mengontrol pompa saat mode auto aktif');
        }

        $success = $this->pompaModel->update(1, ['statusPompa' => (int) $data->statusPompa]);

        if ($success) {
            return $this->respond(['success' => true, 'message' => 'Status pompa berhasil diubah']);
        } else {
            return $this->fail('Gagal mengubah status pompa');
        }
    }
}
