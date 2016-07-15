<?php

$total = $conexion->query("SELECT SUM(p.monto) as total FROM pago p WHERE DATE(p.fecha) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."'");

$total = $total->fetch_assoc();
$total = $total['total'];



if ($pagos->num_rows): ?>

<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<h5>Se realiz<?php echo ($pagos->num_rows==1)?'ó':'aron'; ?></h5>
				<hr>
				<div style="font-size:48px" class="text-right">
					<?php echo $pagos->num_rows ?> pago<?php if ($pagos->num_rows!=1) echo 's'; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<h5>Se recaudó</h5>
				<hr>
				<div style="font-size:48px" class="text-right">
					$ <?php echo number_format($total,2,',','.'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<h5>Días</h5>
				<hr>
				<div style="font-size:48px" class="text-right">
					<?php echo $dias ?> día<?php if ($dias!=1) echo 's'; ?>
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
			<th>Fecha</th>
			<th>Monto</th>
		</tr>
	</thead>
	<tbody>
		<?php while( $pago = $pagos->fetch_assoc() ): ?>
			<tr>
				<td><a href="/Perfil.php?id=<?php echo $pago['usuario_id']?>"><img class="img-circle shadow" src="/img/perfiles/<?php echo ($pago['foto'])?$pago['foto']:'default.png'; ?>" width="24"> <?php echo $pago['nombre']; ?></a></td>
				<td><?php echo $pago['fecha']; ?></td>
				<td>$<?php echo $pago['monto']; ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2" class="text-right"><b>Total</b></th>
			<th><b>$<?php echo $total ?></b></th>
		</tr>
	</tfoot>
</table>

<?php else: ?>

	<div class="alert alert-warning">
		No se han realizado pagos en el lapso indicado. Intenta ampliar el rango.
	</div>

<?php endif ?>