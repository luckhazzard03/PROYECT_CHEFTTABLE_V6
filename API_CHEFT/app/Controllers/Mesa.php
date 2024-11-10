<?php
// Is file namespace
namespace App\Controllers;
use App\Models\MesaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session; // Asegúrate de cargar la sesión

class Mesa extends Controller
{
    private $primaryKey;
    private $mesaModel;
    private $data;
    private $model;
    private $session;

    // Constructor
    public function __construct()
    {
        $this->primaryKey = "idMesa";
        $this->mesaModel = new MesaModel();
        $this->data = [];
        $this->model = "mesas";
        $this->session = \Config\Services::session();  // Inicia la sesión
    }

    // Verificar si el usuario tiene el rol adecuado
    private function checkRole($requiredRole)
    {
        $userRole = $this->session->get('role');  // Obtiene el rol del usuario desde la sesión
        if ($userRole !== $requiredRole) {
            return false;
        }
        return true;
    }

    // Index: Mostrar mesas
    public function index()
    {
        // Verificar que el usuario sea Admin, Chef o Mesero
        if (!$this->checkRole('Admin') && !$this->checkRole('Chef') && !$this->checkRole('Mesero')) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }
        $this->data['title'] = "MESAS";
        $this->data[$this->model] = $this->mesaModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('mesa/mesa_view', $this->data);
    }

    // Crear mesa
    public function create()
    {
        // Verificar si es Admin
        if (!$this->checkRole('Admin')) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }

        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            // Query Insert Codeigniter
            if ($this->mesaModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creating mesa';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($dataModel);
    }

    // Ver detalle de una mesa
    public function singleMesa($id = null)
    {
        // Verificar que el usuario sea Admin, Chef o Mesero
        if (!$this->checkRole('Admin') && !$this->checkRole('Chef') && !$this->checkRole('Mesero')) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }

        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->mesaModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error retrieving mesa';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    // Actualizar mesa
    public function update()
    {
        // Verificar que el usuario sea Admin o Chef
        if (!$this->checkRole('Admin') && !$this->checkRole('Chef')) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }

        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = [
                'No_Orden' => $this->request->getVar('No_Orden'),
                'Estado' => $this->request->getVar('Estado'),
                'Capacidad' => $this->request->getVar('Capacidad'),
                'create_at' => $this->request->getVar('create_at'),
                'update_at' => $this->request->getVar('update_at'),
            ];
            // Actualizar mesa
            if ($this->mesaModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error updating mesa';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($dataModel);
    }

    // Eliminar mesa
    public function delete($id = null)
    {
        // Verificar que el usuario sea Admin
        if (!$this->checkRole('Admin')) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }

        try {
            if ($this->mesaModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error deleting mesa';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    // Este método recibe los datos del formulario y los asigna al modelo
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
