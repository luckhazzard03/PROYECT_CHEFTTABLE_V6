<?php
// Is file namespace
namespace App\Controllers;
//These are the class that will be used in this controller
use App\Models\MesaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Mesa extends Controller
{
	//Variable declarations.
	private $primaryKey;
	private $mesaModel;
	private $data;
	private $model;
	//This method is the constructor
	public function __construct()
	{
		$this->primaryKey = "idMesa";
		$this->mesaModel = new MesaModel();
		$this->data = [];
		$this->model = "mesas";
	}
	//This method is the index, Started the view, set parameters for send the data in the view of the html render
	public function index()
	{
		$this->data['title'] = "MESAS";
		$this->data[$this->model] = $this->mesaModel->orderBy($this->primaryKey, 'ASC')->findAll();
		return view('mesa/mesa_view', $this->data);
	}
	//This method consists of creating, obtains the data from the POST method, return Json 
	public function create()
	{
		if ($this->request->isAJAX()) {
			$dataModel = $this->getDataModel();
			//Query Insert Codeigniter
			if ($this->mesaModel->insert($dataModel)) {
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
	public function singleMesa($id = null)
	{
		//Validate is ajax 
		if ($this->request->isAJAX()) {
			//Select user status model	

			if ($data[$this->model] = $this->mesaModel->where($this->primaryKey, $id)->first()) {
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
				'No_Orden' => $this->request->getVar('No_Orden'),
				'Estado' => $this->request->getVar('Estado'),			
				'Capacidad' => $this->request->getVar('Capacidad'),			
				'create_at' => $this->request->getVar('create_at'),			
				'update_at' => $this->request->getVar('update_at'),			
				

			];
			//Update Data Model
			if ($this->mesaModel->update($id, $dataModel)) {
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
			if ($this->mesaModel->where($this->primaryKey, $id)->delete($id)) {
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
			'idMesa' => $this->request->getVar('idMesa'),
			'No_Orden' => $this->request->getVar('No_Orden'),
			'Estado' => $this->request->getVar('Estado'),		
			'Capacidad' => $this->request->getVar('Capacidad'),		
			'create_at' => $this->request->getVar('create_at'),			
			'update_at' => $this->request->getVar('update_at'),
		];
		return $data;
	}
}
