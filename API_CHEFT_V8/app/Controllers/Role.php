<?php

namespace App\Controllers;

use App\Models\RolesModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Role extends Controller
{
    private $primaryKey;
    private $roleModel;
    private $data;
    private $model;

    // Constructor
    public function __construct()
    {
        // Inicialización de variables
        $this->primaryKey = "idRoles";
        $this->roleModel = new RolesModel();
        $this->data = [];
        $this->model = "roles";
    }

    // Método index para mostrar los roles
    public function index()
    {
        // Verificar si la sesión está activa
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        // Verificar si el usuario tiene un rol guardado en la sesión
        $userRole = $session->get('role');
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole)); // Depurar valor de role

        // Si el rol no está en la sesión o no tiene permisos, denegar acceso
        if ($userRole !== 'Admin') {
            log_message('error', 'Acceso denegado: el usuario no tiene rol de admin. Rol encontrado: ' . json_encode($userRole)); // Depurar acceso denegado
            return redirect()->to('/login');
        }

        // Si la sesión es válida y tiene el rol adecuado, cargar la vista de roles
        $this->data['title'] = "ROLES";
        $this->data[$this->model] = $this->roleModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('role/role_view', $this->data);
    }

    // Método para crear un nuevo rol
    public function create()
    {
        if ($this->request->isAJAX()) {
            log_message('debug', 'Datos AJAX recibidos: ' . json_encode($this->request->getPost()));
            $dataModel = $this->getDataModel();

            if ($this->roleModel->insert($dataModel)) {
                log_message('debug', 'Rol creado con éxito: ' . json_encode($dataModel));
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
            } else {
                log_message('error', 'Error al crear el rol: ' . json_encode($dataModel));
                $data['message'] = 'Error creating role';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
            }
        } else {
            log_message('error', 'Error en la solicitud AJAX.');
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
        }

        return $this->response->setJSON($data);
    }

    // Método para obtener un rol específico
    public function singleRole($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->roleModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error retrieving role';
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

    // Método para actualizar un rol existente
    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = [
                'Rol' => $this->request->getVar('Rol'),
                'Descripcion' => $this->request->getVar('Descripcion'),
                'update_at' => date("Y-m-d H:i:s"),
            ];

            if ($this->roleModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error updating role';
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

    // Método para eliminar un rol
    public function delete($id = null)
    {
        try {
            if ($this->roleModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error deleting role';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return $this->response->setJSON($data);
    }

    // Método para obtener los datos del modelo
    public function getDataModel()
    {
        $data = [
            'idRoles' => $this->request->getVar('idRoles'),
            'Rol' => $this->request->getVar('Rol'),
            'Descripcion' => $this->request->getVar('Descripcion'),
            'create_at' => date("Y-m-d H:i:s"),
            'update_at' => date("Y-m-d H:i:s"),
        ];
        return $data;
    }
}
