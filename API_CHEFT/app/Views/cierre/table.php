<div class="table-responsive mx-auto">
	<table class="table table-hover" id="table-index">
		<thead class="table-dark">
		<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Total_Dia</th>
				<th scope="col">Total_Semana</th>
				<th scope="col">Total_Mes</th>
				<th scope="col">idUsuario_fk</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php if ($cierres) : ?>
				<?php foreach ($cierres as $obj) : ?>
					<tr class="text-center">
						<td>
							<?php echo $obj['idCierre']; ?>
						</td>
						<td>
							<?php echo $obj['Fecha']; ?>
						</td>
						<td>
							<?php echo $obj['Total_Dia']; ?>
						</td>
						<td>
							<?php echo $obj['Total_Semana']; ?>
						</td>
						<td>
							<?php echo $obj['Total_Mes']; ?>
						</td>
						<td>
							<?php echo $obj['idUsuario_fk']; ?>
						</td>
						<td>
							<div class="btn-group" role="group" aria-label="Basic mixed styles example">
								<button type="button" title="Button show User Status" onclick="show(<?php echo $obj['idCierre']; ?>)" class="btn btn-success btn-actions"><i class="bi bi-eye-fill"></i></button>
								<button type="button" title="Button edit User Status" onclick="edit(<?php echo $obj['idCierre']; ?>)" class="btn btn-warning btn-actions"><i class="bi bi-pencil-square" style="color:white"></i></button>
								<button type="button" title="Button delete User Status" onclick="delete_(<?php echo $obj['idCierre']; ?>)" class="btn btn-danger btn-actions"><i class="bi bi-trash-fill"></i></button>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
		<tfoot class="table-dark">
		<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Total_Dia</th>
				<th scope="col">Total_Semana</th>
				<th scope="col">Total_Mes</th>
				<th scope="col">idUsuario_fk</th>
				<th scope="col">Actions</th>
			</tr>
		</tfoot>
	</table>
</div>