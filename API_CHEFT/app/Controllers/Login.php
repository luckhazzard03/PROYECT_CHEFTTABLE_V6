<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        // Muestra la vista de login
        return view('login');
    }

    public function authenticate()
    {
        // Instancia del modelo UsuarioModel para interactuar con la base de datos
        $userModel = new UsuarioModel();

        // Obtener el valor del parámetro 'email' enviado en la solicitud HTTP
        $email = $this->request->getPost('email');

        // Obtener el valor del parámetro 'password' enviado en la solicitud HTTP
        $password = $this->request->getPost('password');

        // Verificar si 'email' y 'password' están presentes en la solicitud
        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email and password are required.');
        }

        // Buscar en la base de datos un usuario cuyo correo electrónico coincida con $email
        $user = $userModel->where('Email', $email)->first();

        // Verificar si no se encontró ningún usuario con el correo electrónico proporcionado o si la contraseña es incorrecta
        if (is_null($user) || !password_verify($password, $user['Password'])) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        // Obtener el ID del rol del usuario
        $roleId = $user['idRoles_fk']; // Aquí se usa el campo idRoles_fk del modelo UsuarioModel

        // Guardar el ID del rol del usuario en la sesión
        session()->set('role', $roleId);

        // Redirigir a la vista del menú
        return redirect()->to(base_url('menu'));
    }
}