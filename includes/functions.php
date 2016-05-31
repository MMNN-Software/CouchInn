<?php


function tiempo_transcurrido($fecha) {
  $intervalos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año");
  $duraciones = array("60","60","24","7","4.35","12");
   
  $ahora = time();
  $unix = strtotime($fecha);
  
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