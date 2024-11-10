<?php

namespace App\Controllers;

use App\Models\ComandaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Comanda extends Controller
{
    private $primaryKey;
    private $comandaModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "Comanda_id";
        $this->comandaModel = new ComandaModel();
        $this->data = [];
        $this->model = "comanda";
    }

    // Proteger el acceso a Comanda para Admin, Chef, y Mesero
    public function index()
    {
        // Verificar si la sesión está activa
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        // Verificar si el usuario tiene el rol adecuado para acceder a Comanda
        $userRole = $session->get('role');
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole));

        if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
            log_message('error', 'Acceso denegado: el usuario no tiene rol adecuado. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        // Si la sesión es válida y tiene el rol adecuado, cargar la vista de Comanda
        $this->data['title'] = "COMANDA";
        $this->data[$this->model] = $this->comandaModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('comanda/comanda_view', $this->data);
    }

    // Método de creación, solo para Admin
    public function create()
    {
        $session = session();
        $userRole = $session->get('role');
        
        if (!in_array($userRole, ['Admin'])) {
            return $this->response->setJSON(['message' => 'Acceso denegado', 'response' => ResponseInterface::HTTP_FORBIDDEN]);
        }

        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->comandaModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creando la comanda';
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

    // Método para obtener los datos del modelo
    public function getDataModel()
    {
        $data = [
            'Comanda_id' => $this->request->getVar('Comanda_id'),
            'Fecha' => $this->request->getVar('Fecha'),
            'Hora' => $this->request->getVar('Hora'),
            'Total_platos' => $this->request->getVar('Total_platos'),
            'Precio_Total' => $this->request->getVar('Precio_Total'),
            'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
            'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
            'idMesa_fk' => $this->request->getVar('idMesa_fk'),
            'create_at' => date("Y-m-d H:i:s"),
            'update_at' => date("Y-m-d H:i:s"),
        ];
        return $data;
    }
}

