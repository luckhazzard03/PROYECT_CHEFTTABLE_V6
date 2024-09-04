form.php <form id="my-form" class="">
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
        <input type="number" class="form-control" id="Total_platos" name="Total_platos" placeholder="Description" required>
        <label for="Total_platos">Cantidad Platos</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Precio_Total" name="Precio_Total" placeholder="Precio" step="0.01" required>
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
        <input type="number" class="form-control" id="idUsuario_fk" name="idUsuario_fk" placeholder="Tipo_Menu" required value="<?php isset($obj['Tipo_Menu']) ? $obj['Tipo_Menu'] : ''; ?>">
        <label for="idUsuario_fk">IDUsuario_fk</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="idMesa_fk" name="idMesa_fk" placeholder="Tipo_Menu" required value="<?php isset($obj['Tipo_Menu']) ? $obj['Tipo_Menu'] : ''; ?>">
        <label for="idMesa_fk">idMesa_fk</label>
    </div>


</form>