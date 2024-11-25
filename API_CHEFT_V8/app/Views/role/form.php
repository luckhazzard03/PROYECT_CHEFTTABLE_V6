<form id="my-form" class="">

	<input type="hidden" class="form-control" id="idRoles" name="idRoles" value=null>
	<input type="hidden" class="form-control" id="update_at" name="update_at" value=null>
	<div class="form-floating mb-3">
        <select class="form-control" id="idRoles_fk" name="idRoles_fk" required>
            <option value="" disabled selected>Select role</option>
            <option value="1">Admin</option>
            <option value="2">Chef</option>
            <option value="3">Mesero</option>
            <option value="4">Mesero2</option>
            <option value="5">Mesero3</option>
            <option value="6">Mesero4</option>
        </select>
        <label for="idRoles_fk">Roles</label>
    </div>

	<div class="form-floating mb-3">
		<input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="Precio" required>
		<label for="Descripcion">Descripcion</label>
	</div>
</form>