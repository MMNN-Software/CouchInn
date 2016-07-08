<?php if ($usuarios->num_rows): ?>

<div class="row">
<div class="col-sm-4">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5>Usuarios registrados</h5>
			<hr>
			<div style="font-size:48px" class="text-right">
				<?php echo $usuarios->num_rows ?> usuario<?php if ($usuarios->num_rows!=1) echo 's'; ?>
			</div>
		</div>
	</div>
</div>
</div>

<h5>Detalles</h5>
<hr>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Fecha de registro</th>
		</tr>
	</thead>
	<tbody>
	<?php while( $usuario = $usuarios->fetch_assoc() ): ?>
		<tr>
			<td><a href="/Perfil.php?id=<?php echo $usuario['id']?>"><img class="img-circle shadow" src="/img/perfiles/<?php echo ($usuario['foto'])?$usuario['foto']:'default.png'; ?>" width="24"> <?php echo $usuario['nombre']; ?></a></td>
			<td><?php echo $usuario['registro']; ?></td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>

<?php else: ?>

	<div class="alert alert-warning">
		No se han registrado usuarios en el lapso indicado. Intenta ampliar el rango.
	</div>

<?php endif ?>