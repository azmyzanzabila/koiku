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

    public function __construct()
    {
        $this->sensorModel = new SensorModel();
        $this->pompaModel = new PompaModel();
    }

    // Endpoint untuk menerima data sensor dari Arduino
    public function postSensor()
    {
        // Periksa apakah data JSON diterima dengan benar
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->failValidationErrors('Data JSON tidak valid atau kosong');
        }

        // Validasi data yang diperlukan
        if (!isset($json->turbidity) || !isset($json->pH) || !isset($json->tds)) {
            return $this->failValidationErrors('Data sensor tidak lengkap');
        }

        $data = [
            'turbidity' => $json->turbidity,
            'pH' => $json->pH,
            'tds' => $json->tds
        ];

        try {
            $this->sensorModel->insert($data);
            return $this->respond([
                'status' => 'success',
                'message' => 'Data sensor berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // Endpoint untuk memberikan status kontrol ke Arduino
    public function getStatus()
    {
        $latestStatus = $this->pompaModel->orderBy('created_at', 'DESC')->first();

        return $this->respond([
            'status' => 'success',
            'mode' => 'auto', // atau bisa dari database
            'pompa' => $latestStatus['statusPompa'] ?? 0,
            'valve' => $latestStatus['statusValve'] ?? 0
        ]);
    }

    // Endpoint untuk mengupdate status pompa dari web
    public function updatePompa()
    {
        $json = $this->request->getJSON();

        $data = [
            'statusPompa' => $json->statusPompa ?? 0,
            'statusValve' => $json->statusValve ?? 0
        ];

        $this->pompaModel->insert($data);

        return $this->respond([
            'status' => 'success',
            'message' => 'Status pompa berhasil diupdate'
        ]);
    }
}
