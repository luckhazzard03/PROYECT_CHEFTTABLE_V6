<div class="cards">
	<div class="card-single">
		<div>
			<h2>ADMIN</h2>
			<span>ROL ID</span>
			<h1>1</h1>
		</div>
		<div>
			<i class="fa-solid fa-upload" style="color: #141b2f;"></i>
		</div>
	</div>

	<div class="card-single">
		<div>
			<h2>CHEF</h2>
			<span>ROL ID</span>
			<h1>2</h1>
		</div>
		<div>
			<i class="fa-solid fa-arrow-down" style="color: #141b2f;"></i>
		</div>
	</div>

	<div class="card-single">
		<div>
			<h1>MESERO</h1>
			<span>ROL ID</span>
			<h1>3</h1>

		</div>
		<div>
			<i class="fa-solid fa-bars-progress" style="color: #141b2f;"></i>
		</div>
	</div>

</div>
<div class="table-responsive mx-auto">
	<table class="table table-hover" id="table-index">
		<thead class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				<th scope="col">TotalPlatos</th>
				<th scope="col">PrecioTotal</th>
				<th scope="col">TipoMenu</th>
				<th scope="col">Rol</th>
				<th scope="col">Mesa</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php if ($comanda): ?>
				<?php foreach ($comanda as $obj): ?>
					<tr class="text-center">
						<td><?php echo $obj['Comanda_id']; ?></td>
						<td><?php echo $obj['Fecha']; ?></td>
						<td><?php echo $obj['Hora']; ?></td>
						<td><?php echo $obj['Total_platos']; ?></td>
						<td><?php echo number_format($obj['Precio_Total'], 2); ?></td>
						<td><?php echo $obj['Tipo_Menu']; ?></td>
						<td><?php echo $obj['Rol']; ?></td> <!-- Mostrar el nombre del rol -->
						<td><?php echo $obj['idMesa_fk']; ?></td>

						<td>
							<div class="btn-group" role="group" aria-label="Basic mixed styles example">
								<button type="button" title="Button show User Status"
									onclick="show(<?php echo $obj['Comanda_id']; ?>)" class="btn btn-success btn-actions"><i
										class="bi bi-eye-fill"></i></button>
								<button type="button" title="Button edit User Status"
									onclick="edit(<?php echo $obj['Comanda_id']; ?>)" class="btn btn-warning btn-actions"><i
										class="bi bi-pencil-square" style="color:white"></i></button>
								<button type="button" title="Button delete User Status"
									onclick="delete_(<?php echo $obj['Comanda_id']; ?>)" class="btn btn-danger btn-actions"><i
										class="bi bi-trash-fill"></i></button>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
		<tfoot class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				<th scope="col">TotalPlatos</th>
				<th scope="col">PrecioTotal</th>
				<th scope="col">TipoMenu</th>
				<th scope="col">Rol</th>
				<th scope="col">Mesa</th>
				<th scope="col">Actions</th>
			</tr>
		</tfoot>
	</table>
</div>