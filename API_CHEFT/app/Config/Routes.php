<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('inicio', 'Views::pagina');


//CRUD GET
$routes->get('profiles-list', 'Profile::index' );
$routes->get('profile-form', 'Profile::create' );
//CRUD POST
$routes->post('submit-form', 'Profile::store' );
$routes->get('edit-view/(:num)', 'Profile::singleProfile/$1' );
$routes->post('update', 'Profile::update' );
$routes->get('delete/(:num)', 'Profile::delete/$1' );


//GROUP ROUTES userStatus-comanda
$routes->group("comanda", function ($routes) {
	$routes->get("/", "Comanda::index");
	$routes->get("show", "Comanda::index");
	$routes->get("edit/(:num)", "Comanda::singleComanda/$1");	
	$routes->get("delete/(:num)", "Comanda::delete/$1");
	$routes->get("create", "Comanda::createView"); // Añade esta línea
	$routes->post("add", "Comanda::create");
	$routes->post("update", "Comanda::update");
});

//GROUP ROUTES userStatus-comanda
$routes->group("comandaMenu", function ($routes) {
	$routes->get("/", "ComandaMenu::index");
	$routes->get("show", "ComandaMenu::index");
	$routes->get("edit/(:num)", "ComandaMenu::singleComandaMenu/$1");	
	$routes->get("delete/(:num)", "ComandaMenu::delete/$1");
	$routes->post("add", "ComandaMenu::create");
	$routes->post("update", "ComandaMenu::update");
});




//GROUP ROUTES PERMISSION-menu
$routes->group("menu", function ($routes) {
	$routes->get("/", "Menu::index");
	$routes->get("show", "Menu::index");
	$routes->get("edit/(:num)", "Menu::singleMenu/$1");	
	$routes->get("delete/(:num)", "Menu::delete/$1");
	$routes->post("add", "Menu::create");
	$routes->post("update", "Menu::update");
});

//GROUP ROUTES ROLE
$routes->group("role", function ($routes) {
	$routes->get("/", "Role::index");
	$routes->get("show", "Role::index");
	$routes->get("edit/(:num)", "Role::singleRole/$1");	
	$routes->get("delete/(:num)", "Role::delete/$1");
	$routes->post("add", "Role::create");
	$routes->post("update", "Role::update");
});
//USUARIO
$routes->group("usuario", function ($routes) {
	$routes->get("/", "Usuario::index");
	$routes->get("show", "Usuario::index");
	$routes->get("edit/(:num)", "Usuario::singleUsuario/$1");	
	$routes->get("delete/(:num)", "Usuario::delete/$1");
	$routes->post("add", "Usuario::create");
	$routes->post("update", "Usuario::update");
});

//GROUP ROUTES MESA
$routes->group("mesa", function ($routes) {
	$routes->get("/", "Mesa::index");
	$routes->get("show", "Mesa::index");
	$routes->get("edit/(:num)", "Mesa::singleMesa/$1");	
	$routes->get("delete/(:num)", "Mesa::delete/$1");
	$routes->post("add", "Mesa::create");
	$routes->post("update", "Mesa::update");
});
//GROUP ROUTES CIERRE
$routes->group("cierre", function ($routes) {
	$routes->get("/", "Cierre::index");
	$routes->get("show", "Cierre::index");
	$routes->get("edit/(:num)", "Cierre::singleCierre/$1");	
	$routes->get("delete/(:num)", "Cierre::delete/$1");
	$routes->post("add", "Cierre::create");
	$routes->post("update", "Cierre::update");
});
//GROUP ROUTES INVENTARIO
$routes->group("inventario", function ($routes) {
	$routes->get("/", "Inventario::index");
	$routes->get("show", "Inventario::index");
	$routes->get("edit/(:num)", "Inventario::singleInventario/$1");	
	$routes->get("delete/(:num)", "Inventario::delete/$1");
	$routes->post("add", "Inventario::create");
	$routes->post("update", "Inventario::update");
});
//GROUP ROUTES PROVEEDOR
$routes->group("proveedor", function ($routes) {
	$routes->get("/", "Proveedor::index");
	$routes->get("show", "Proveedor::index");
	$routes->get("edit/(:num)", "Proveedor::singleProveedor/$1");	
	$routes->get("delete/(:num)", "Proveedor::delete/$1");
	$routes->post("add", "Proveedor::create");
	$routes->post("update", "Proveedor::update");
});
//GROUP ROUTES MENU DIARIO
$routes->group("menudiario", function ($routes) {
	$routes->get("/", "Menudiario::index");
	$routes->get("show", "Menudiario::index");
	$routes->get("edit/(:num)", "Menudiario::singleMenudiario/$1");	
	$routes->get("delete/(:num)", "Menudiario::delete/$1");
	$routes->post("add", "Menudiario::create");
	$routes->post("update", "Menudiario::update");
});
//GROUP ROUTES LOGIN
$routes->group("login", function ($routes) {
	$routes->get("/", "Login::index");
	$routes->get("show", "Login::index");
	$routes->post("logIn", "Login::logIn");
	$routes->post("singOff", "Login::singOff");
	$routes->post("forgerPassword", "Login::forgerPassword");
  });

  $routes->group("api", function ($routes) {
    $routes->post("register", "Register::index");
    $routes->post("login", "Login::index");
    
});
// Ruta para la página de inicio (ruta personalizada)


$routes->get('/', 'Login::index');
$routes->post('login', 'Login::authenticate');
$routes->get('menu', 'Menu::index');




 
//$routes->get('roles-list', 'Role::index' );
//$routes->get('profile-form', 'Profile::create' );
//$routes->get('edit-role/(:num)', 'role::singleRole/$1' );
//$routes->get('delete-role/(:num)', 'Role::delete/$1' );