<?php
// Is file namespace
namespace App\Controllers;
//These are the class that will be used in this controller
use App\Models\CierreModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Cierre extends Controller
{
	//Variable declarations.
	private $primaryKey;
	private $cierreModel;
	private $data;
	private $model;
	//This method is the constructor
	public function __construct()
	{
		$this->primaryKey = "idCierre";
		$this->cierreModel = new CierreModel();
		$this->data = [];
		$this->model = "cierres";
	}
	//This method is the index, Started the view, set parameters for send the data in the view of the html render
	public function index()
	{
		$this->data['title'] = "CIERRES";
		$this->data[$this->model] = $this->cierreModel->orderBy($this->primaryKey, 'ASC')->findAll();
		return view('cierre/cierre_view', $this->data);
	}
	//This method consists of creating, obtains the data from the POST method, return Json 
	public function create()
	{
		if ($this->request->isAJAX()) {
			$dataModel = $this->getDataModel();
			//Query Insert Codeigniter
			if ($this->cierreModel->insert($dataModel)) {
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
	public function singleCierre($id = null)
	{
		//Validate is ajax 
		if ($this->request->isAJAX()) {
			//Select user status model	

			if ($data[$this->model] = $this->cierreModel->where($this->primaryKey, $id)->first()) {
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
			$dataModel = [
				'Fecha' => $this->request->getVar('Fecha'),
				'Total_Dia' => $this->request->getVar('Total_Dia'),			
				'Total_Semana' => $this->request->getVar('Total_Semana'),			
				'Total_Mes' => $this->request->getVar('Total_Mes'),			
				'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),			
				'create_at' => $this->request->getVar('create_at'),			
				'update_at' => $this->request->getVar('update_at'),			
				

			];
			//Update Data Model
			if ($this->cierreModel->update($id, $dataModel)) {
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
			if ($this->cierreModel->where($this->primaryKey, $id)->delete($id)) {
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