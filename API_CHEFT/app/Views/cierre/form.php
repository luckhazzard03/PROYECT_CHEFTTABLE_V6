<form id="my-form" class="">

    <input type="hidden" class="form-control" id="idCierre" name="idCierre" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>

    <div class="form-floating mb-3">
        <input type="date" class="form-control" id="Fecha" name="Fecha" placeholder="Fecha" required>
        <label for="Fecha">Fecha</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Total_Dia" name="Total_Dia" placeholder="Total Día" required>
        <label for="Total_Dia">Total Día</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Total_Semana" name="Total_Semana" placeholder="Total Semana" required>
        <label for="Total_Semana">Total Semana</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Total_Mes" name="Total_Mes" placeholder="Total Mes" required>
        <label for="Total_Mes">Total Mes</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-control" id="idUsuario_fk" name="idUsuario_fk" required>
            <option value="" disabled selected>Seleccione un usuario</option>
            <option value="1">Admin</option>
            <option value="3">Mesero</option>
            
        </select>
        <label for="idUsuario_fk">ID Usuario</label>
    </div>
    
</form>
