<form id="my-form" class="">
    <input type="hidden" class="form-control" id="Comanda_id" name="Comanda_id" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>

    <div class="form-floating mb-3">
        <input type="date" class="form-control" id="Fecha" name="Fecha" placeholder="Name" required>
        <label for="Fecha">Fecha</label>
    </div>

    <div class="form-floating mb-3">
        <input type="time" class="form-control" id="Hora" name="Hora" placeholder="Name" required>
        <label for="Hora">Hora</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" id="Total_platos" name="Total_platos" aria-label="Total_platos" required
            onchange="calculateTotal()">
            <option value="">Selecciona la cantidad de platos</option>
            <option value="1" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 1 ? 'selected' : ''; ?>>1
                Plato</option>
            <option value="2" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 2 ? 'selected' : ''; ?>>2
                Platos</option>
            <option value="3" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 3 ? 'selected' : ''; ?>>3
                Platos</option>
            <option value="4" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 4 ? 'selected' : ''; ?>>4
                Platos</option>
            <option value="5" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 5 ? 'selected' : ''; ?>>5
                Platos</option>
            <option value="6" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 6 ? 'selected' : ''; ?>>6
                Platos</option>
            <option value="7" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 7 ? 'selected' : ''; ?>>7
                Platos</option>
            <option value="8" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 8 ? 'selected' : ''; ?>>8
                Platos</option>
            <option value="9" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 9 ? 'selected' : ''; ?>>9
                Platos</option>
            <option value="10" <?php echo isset($obj['Total_platos']) && $obj['Total_platos'] == 10 ? 'selected' : ''; ?>>
                10 Platos</option>
        </select>
        <label for="Total_platos">Cantidad Platos</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Precio_Total" name="Precio_Total" placeholder="Precio" step="0.01"
            required oninput="calculateTotal()">
        <label for="Precio_Total">Precio Total</label>

    </div>
    <div class="form-floating mb-3">
        <select class="form-select" id="Tipo_Menu" name="Tipo_Menu" aria-label="Tipo_Menu" required>
            <option value="">Selecciona el tipo de menú</option>
            <option value="Corriente" <?php echo isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Corriente' ? 'selected' : ''; ?>>Corriente</option>
            <option value="Ejecutivo" <?php echo isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Ejecutivo' ? 'selected' : ''; ?>>Ejecutivo</option>
            <option value="Especial" <?php echo isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Especial' ? 'selected' : ''; ?>>Especial</option>
        </select>
        <label for="Tipo_Menu">Tipo Menu</label>
    </div>
    <div class="form-floating mb-3">
        <select class="form-select" id="idUsuario_fk" name="idUsuario_fk" required>
            <option value="1">Admin</option>
            <option value="2">Chef</option>
            <option value="3">Mesero</option>
        </select>
        <label for="idUsuario_fk">Usuario Rol</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="idMesa_fk" name="idMesa_fk" placeholder="Tipo_Menu" required
            value="<?php isset($obj['Tipo_Menu']) ? $obj['Tipo_Menu'] : ''; ?>">
        <label for="idMesa_fk">Mesa Numero</label>
    </div>


</form>