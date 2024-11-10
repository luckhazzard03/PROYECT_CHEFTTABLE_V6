<?php

namespace App\Controllers;

use App\Models\CierreModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Cierre extends Controller
{
    private $primaryKey;
    private $cierreModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "idCierre";
        $this->cierreModel = new CierreModel();
        $this->data = [];
        $this->model = "cierres";
    }

    public function index()
    {
        // Verificar si la sesión está activa
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        // Verificar rol de usuario desde la sesión
        $userRole = $session->get('role');
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole));

        // Denegar acceso si el rol no es Admin
        if ($userRole !== 'Admin') {
            log_message('error', 'Acceso denegado: el usuario no tiene rol de admin. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        // Cargar la vista si la sesión y el rol son válidos
        $this->data['title'] = "CIERRES";
        $this->data[$this->model] = $this->cierreModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('cierre/cierre_view', $this->data);
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->cierreModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al crear el cierre';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return $this->response->setJSON($data);
    }

    // Métodos adicionales (singleCierre, update, delete) siguen el mismo patrón para validar sesión y rol de usuario

    public function getDataModel()
    {
        $data = [
            'idCierre' => $this->request->getVar('idCierre'),
            'Fecha' => $this->request->getVar('Fecha'),
            'Total_Dia' => $this->request->getVar('Total_Dia'),
            'Total_Semana' => $this->request->getVar('Total_Semana'),
            'Total_Mes' => $this->request->getVar('Total_Mes'),
            'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}
