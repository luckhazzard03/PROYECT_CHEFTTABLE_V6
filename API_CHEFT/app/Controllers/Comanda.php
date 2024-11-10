<?php
// Is file namespace
namespace App\Controllers;
//These are the class that will be used in this controller
use App\Models\ComandaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Comanda extends Controller
{
	//Variable declarations.
	private $primaryKey;
	private $comandaModel;
	private $data;
	private $model;
	//This method is the constructor
	public function __construct()
	{
		$this->primaryKey = "Comanda_id";
		$this->comandaModel = new ComandaModel();
		$this->data = [];
		$this->model = "comanda";
	}
	//This method is the index, Started the view, set parameters for send the data in the view of the html render
	public function index()
	{
		$this->data['title'] = "COMANDA";
		$this->data[$this->model] = $this->comandaModel->orderBy($this->primaryKey, 'ASC')->findAll();
		return view('comanda/comanda_view', $this->data);
	}
	//This method consists of creating, obtains the data from the POST method, return Json 
	public function create()
	{
		if ($this->request->isAJAX()) {
			$dataModel = $this->getDataModel();

			// Calcular el total
			$totalPlatos = (int)$dataModel['Total_platos'];
			$precioTotal = (float)$dataModel['Precio_Total'];
			$dataModel['Precio_Total'] = $totalPlatos * $precioTotal; //
			//Query Insert Codeigniter
			if ($this->comandaModel->insert($dataModel)) {
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
		//Change array to Json 
		echo json_encode($dataModel);
	}
	//This method consist of single User Status, obtains id the data from the GET method, return Json
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
			$dataModel = [
				'Fecha' => $this->request->getVar('Fecha'),
				'Hora' => $this->request->getVar('Hora'),
				'Total_platos' => (int)$this->request->getVar('Total_platos'),
				'Precio_Total' => (float)$this->request->getVar('Precio_Total'),
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
	// This method consists of create is model the data in the array associative, return array
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
			'create_at' => $this->request->getVar('create_at'),
			'update_at' => $this->request->getVar('update_at'),
		];
		return $data;
	}
}
