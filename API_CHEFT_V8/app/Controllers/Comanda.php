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
		// Mapeo de roles
		$roles = [
			3 => 'Mesero',
			4 => 'Mesero2',
			5 => 'Mesero3',
			6 => 'Mesero4',
			7 => 'Mesero5',
		];
	
		// Reemplazar idUsuario_fk con el nombre del rol
		foreach ($this->data[$this->model] as &$obj) {
			$obj['Rol'] = isset($roles[$obj['idUsuario_fk']]) ? $roles[$obj['idUsuario_fk']] : 'Desconocido';
		}
        return view('comanda/comanda_view', $this->data);
    }

    // Método de creación, solo para Admin
    public function create()
    {
        $session = session();
        $userRole = $session->get('role');
        
		if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
			return $this->response->setJSON(['message' => 'Acceso denegado', 'response' => ResponseInterface::HTTP_FORBIDDEN]);
		}

        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
			// Calcular el total
			$totalPlatos = (int)$dataModel['Total_platos'];
			$precioTotal = (float)$dataModel['Precio_Total'];
			$dataModel['Precio_Total'] = $totalPlatos * $precioTotal; //
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
    public function singleComanda($id = null)
	{
		//Validate is ajax 
		if ($this->request->isAJAX()) {
			//Select user status model	

			if ($data[$this->model] = $this->comandaModel->where($this->primaryKey, $id)->first()) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['csrf'] = csrf_hash();
			} else {
				$data['message'] = 'Error create user';
				$data['response'] = ResponseInterface::HTTP_NO_CONTENT;
				$data['data'] = '';
			}
		} else {
			$data['message'] = 'Error Ajax';
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		//Change array to Json 
		echo json_encode($data);
	}
	//This method consists of update status, obatains id the data from the POST method, return Json 
	public function update()
	{
		//validate is ajax
		if ($this->request->isAJAX()) {
			$today = date("Y-m-d  H:i:s");
			$id = $this->request->getVar($this->primaryKey);

			// Obtener los datos del modelo
            $totalPlatos = (int)$this->request->getVar('Total_platos');
            $precioPorPlato = (float)$this->request->getVar('Precio_Total'); // Este debe ser el precio por plato

            // Calcular el nuevo precio total
            $nuevoPrecioTotal = $totalPlatos * $precioPorPlato;
			// Obtener los datos del modelo
			$dataModel = [
				'Fecha' => $this->request->getVar('Fecha'),
				'Hora' => $this->request->getVar('Hora'),
				'Total_platos' => (int)$totalPlatos,
                'Precio_Total' => (float)$nuevoPrecioTotal,
				'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
				'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
				'idMesa_fk' => $this->request->getVar('idMesa_fk'),
				'create_at' => $this->request->getVar('create_at'),
				'update_at' => $today,
			];
	
			// Calcular el total
			$dataModel['Total_Precio'] = $dataModel['Total_platos'] * $dataModel['Precio_Total'];
			//Update Data Model
			if ($this->comandaModel->update($id, $dataModel)) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['data'] = $dataModel;
				$data['csrf'] = csrf_hash();
			} else {
				$data['message'] = 'Error create user';
				$data['response'] = ResponseInterface::HTTP_NO_CONTENT;
				$data['data'] = '';
			}
		} else {
			$data['message'] = 'Error Ajax';
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		// Change array to Json
		echo json_encode($dataModel);
	}
	//this method consist of delete status, obtains id the data from the GET method, return Json
	public function delete($id = null)
	{
		try {
			//delete data model
			if ($this->comandaModel->where($this->primaryKey, $id)->delete($id)) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['data'] = "OK";
				$data['csrf'] = csrf_hash();
			} else {
				$data['message'] = 'Error create user';
				$data['response'] = ResponseInterface::HTTP_NO_CONTENT;
				$data['data'] = '';
			}
		} catch (\Exception $e) {
			$data['message'] = $e;
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		// Change array to Json
		echo json_encode($data);
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

