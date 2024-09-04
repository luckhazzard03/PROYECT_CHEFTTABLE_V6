<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Usuario extends Controller
{
    private $primaryKey;
    private $usuarioModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "idUsuario";
        $this->usuarioModel = new UsuarioModel();
        $this->data = [];
        $this->model = "usuario";
    }

    public function index()
    {
        $this->data['title'] = "USUARIOS";
        $this->data[$this->model] = $this->usuarioModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('usuario/usuario_view', $this->data);
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            // Encriptar la contraseña antes de insertar en la base de datos
            $dataModel['Password'] = password_hash($dataModel['Password'], PASSWORD_DEFAULT);

            // Query Insert CodeIgniter
            if ($this->usuarioModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creating user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    public function singleUsuario($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->usuarioModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'User not found';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $today = date("Y-m-d H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = $this->getDataModel();

            // Verificar si se debe actualizar la contraseña
            if (!empty($dataModel['Password'])) {
                // Encriptar la nueva contraseña
                $dataModel['Password'] = password_hash($dataModel['Password'], PASSWORD_DEFAULT);
            } else {
                // Si la contraseña no se proporciona, mantener la existente
                unset($dataModel['Password']);
            }

            $dataModel['update_at'] = $today;

            if ($this->usuarioModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error updating user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    public function delete($id = null)
    {
        try {
            if ($this->usuarioModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error deleting user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = 'Exception: ' . $e->getMessage();
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    private function getDataModel()
    {
        $data = [
            'idUsuario' => $this->request->getVar('idUsuario'),
            'Nombre' => $this->request->getVar('Nombre'),
            'Password' => $this->request->getVar('Password'),
            'Email' => $this->request->getVar('Email'),
            'Telefono' => $this->request->getVar('Telefono'),
            'idRoles_fk' => $this->request->getVar('idRoles_fk'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}




