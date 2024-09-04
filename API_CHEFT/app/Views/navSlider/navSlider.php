<?php
$current_url = basename($_SERVER['REQUEST_URI']); // Obtener solo la parte final de la URL
$role = session()->get('role'); // Obtener el ID del rol almacenado en la sesión
?>

<input type="checkbox" id="nav-toggle" />
<div class="sidebar">
    <div class="sidebar-brand">
        <h2>
            <span class=""></span>
            <span><img src="<?= base_url('assets/img/logos/LOGO CHEF TABLE2-02.png') ?>" alt="" width="180px" height="90px" /></span>
        </h2>
    </div>
    <!-- Secciones del menú -->
    <div class="sidebar-menu">
        <ul>
            <!-- Roles -->
            <?php if ($role == 1 ): ?>
                <li>
                    <a href="<?= base_url('role') ?>" class="<?= $current_url == 'role' ? 'active' : '' ?>">
                        <i class="fa-solid fa-unlock"></i> <span>Roles</span>
                    </a>
                </li>
            <?php endif; ?>
           
            <!-- Usuarios -->
            <?php if ($role == 1 ): ?>
                <li>
                    <a href="<?= base_url('usuario') ?>" class="<?= $current_url == 'usuario' ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i> <span>Usuarios</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Inventario -->
            <?php if ($role == 1 || $role == 2): ?>
                <li>
                    <a href="<?= base_url('inventario') ?>" class="<?= $current_url == 'inventario' ? 'active' : '' ?>">
                        <i class="fa-solid fa-warehouse"></i><span>Inventario</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Comanda -->
            <?php if ($role == 1 || $role == 2 || $role == 3): ?>
                <li>
                    <a href="<?= site_url('comanda') ?>" class="<?= $current_url == 'comanda' ? 'active' : '' ?>">
                        <i class="fa-solid fa-file"></i><span>Comanda</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Menú -->
            <?php if ($role == 1 || $role == 2 || $role == 3): ?>
                <li>
                    <a href="<?= site_url('menu') ?>" class="<?= $current_url == 'menu' ? 'active' : '' ?>">
                        <i class="fa-solid fa-file"></i>  <span>Menú</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Comanda Menu -->
            <?php if ($role == 1 || $role == 2 || $role == 3): ?>
                <li>
                    <a href="<?= site_url('comandaMenu') ?>" class="<?= $current_url == 'comandaMenu' ? 'active' : '' ?>">
                        <i class="fa-solid fa-file"></i> <span>Comanda Menu</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Menú Diario -->
            <?php if ($role == 1 || $role == 2): ?>
                <li>
                    <a href="<?= base_url('menudiario') ?>" class="<?= $current_url == 'menudiario' ? 'active' : '' ?>">
                        <i class="fa-solid fa-file"></i> <span>Menú Diario</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Mesa Disponible -->
            <?php if ($role == 1 || $role == 2 || $role == 3): ?>
                <li>
                    <a href="<?= site_url('mesa') ?>" class="<?= $current_url == 'mesa' ? 'active' : '' ?>">
                        <i class="fa-solid fa-table-list"></i><span>Mesa Disponible</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Proveedor -->
            <?php if ($role == 1): ?>
                <li>
                    <a href="<?= site_url('proveedor') ?>" class="<?= $current_url == 'proveedor' ? 'active' : '' ?>">
                        <i class="fa-solid fa-truck-field"></i><span>Proveedor</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <!-- Cierre -->
            <?php if ($role == 1): ?>
                <li>
                    <a href="<?= site_url('cierre') ?>" class="<?= $current_url == 'cierre' ? 'active' : '' ?>">
                        <i class="fa-solid fa-money-check-dollar"></i> <span>Cierre</span>
                    </a>
                </li>
            <?php endif; ?>
            
        </ul>
    </div>
</div>