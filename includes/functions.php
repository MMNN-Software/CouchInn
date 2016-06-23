<?php


function tiempo_transcurrido($fecha) {
  $intervalos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año");
  $duraciones = array("60","60","24","7","4.35","12");
   
  $ahora = time();
  $unix = $fecha;
  
  $diferencia = $ahora - $unix;
  for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
    $diferencia /= $duraciones[$j];
  }
   
  $diferencia = round($diferencia);
  
  if($diferencia != 1) {
    $intervalos[5].="e";
    $intervalos[$j].= "s";
  }
  
  return "Hace $diferencia $intervalos[$j]";
}

function doLoginOf( $usuario ){
  $_SESSION['id'] = $usuario['id'];
  $_SESSION['usuario'] = $usuario['email'];
  $_SESSION['nombre'] = $usuario['nombre'];
  $_SESSION['premium'] = $usuario['premium'];
  $_SESSION['is_admin'] = ( $usuario['tipo'] == 'admin' );
}

function hace($fecha_unix){
	//obtener la hora en formato unix
	$ahora=time();
	
	//obtener la diferencia de segundos
	$segundos=$ahora-$fecha_unix;
	
	//dias es la division de n segs entre 86400 segundos que representa un dia;
	$dias=floor($segundos/86400);

	//mod_hora es el sobrante, en horas, de la division de días;	
	$mod_hora=$segundos%86400;
	
	//hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
	$horas=floor($mod_hora/3600);
	
	//mod_minuto es el sobrante, en minutos, de la division de horas;	
	$mod_minuto=$mod_hora%3600;
	
	//minuto es la division entre el sobrante y 60 segundos que representa un minuto;
	$minutos=floor($mod_minuto/60);
	
	if($horas<=0){
		echo $minutos.' minutos';
	}elseif($dias<=0){
		echo $horas.' horas '.$minutos.' minutos';
	}else{
		echo $dias.' dias '.$horas.' horas '.$minutos.' minutos';
	}
}