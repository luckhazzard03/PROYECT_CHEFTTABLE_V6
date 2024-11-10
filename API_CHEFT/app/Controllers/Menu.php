<?php

namespace App\Controllers;

use App\Models\MenuModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Menu extends Controller
{
    private $primaryKey;
    private $MenuModel;
    private $data;
    private $model;

    // Constructor
    public function __construct()
    {
        $this->primaryKey = "Menu_id";
        $this->MenuModel = new MenuModel();
        $this->data = [];
        $this->model = "menus";
    }

    // Método index para mostrar los menús
    public function index()
{
    // Verificar si la sesión está activa
    $session = session();
    if (!$session->has('user_id')) {
        log_message('error', 'Usuario no autenticado.');
        return redirect()->to('/login');
    }

    // Verificar el rol del usuario
    $userRole = $session->get('role');
    log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole));

    // Verificar si el rol del usuario es uno de los roles permitidos ('Admin', 'Chef', 'Mesero')
    if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
        log_message('error', 'Acceso denegado: el usuario no tiene un rol permitido. Rol encontrado: ' . json_encode($userRole));
        return redirect()->to('/login');
    }

    // Si el rol es adecuado, cargar la vista de menús
    $this->data['title'] = "MENUS";
    $this->data[$this->model] = $this->MenuModel->orderBy($this->primaryKey, 'ASC')->findAll();
    return view('menu/menu_view', $this->data);
}

    // Método para crear un nuevo menú
    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->MenuModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al crear el menú';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error en la solicitud AJAX';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    // Otros métodos (singleMenu, update, delete) se mantendrían igual.
    // Método para obtener los datos del modelo
    public function getDataModel()
    {
        $data = [
            'Menu_id' => $this->request->getVar('Menu_id'),
            'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
            'Precio_Menu' => $this->request->getVar('Precio_Menu'),        
            'create_at' => $this->request->getVar('create_at'),            
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}
