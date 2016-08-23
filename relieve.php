<?php
// Para testear tu código en nuestros servidores debes mantener la estructura expuesta abajo.
// Eres libre de crear nuevas funciones/procedimientos.
// Recuerda que el código que escribas podrá ser visto por las empresas a las que te postules.
/*
***Un conjunto de posiciones conexas con la misma altura en la matriz se consideran estratos. 

***Se considerarán bordes, aquellos estratos que son mínimos locales, es decir, que ninguno de sus integrantes posee vecinos con altura menor. 

Diseñar un algoritmo que, dada una matriz, devuelva otra matriz con 0 en todas sus posiciones excepto en los bordes de las montañas que encuentre, donde devuelva 1.
*/

// Para validar los 'vecinos', ten presente las posiciones arriba, abajo, izquierda y derecha. Las posiciones diagonales NO deben ser tenidas en cuenta.
$relieve = [[9, 2, 2, 2, 3, 5], [9, 8, 3, 2, 4, 5], [9, 7, 2, 2, 4, 3], [9, 9, 2, 4, 4, 3], [9, 2, 3, 4, 3, 5]];
// Representación gráfica
// 9 2 2 2 3 5  
// 9 8 3 2 4 5  
// 9 7 2 2 4 3  
// 9 9 2 4 4 3  
// 9 2 3 4 3 5

// 0 1 1 1 0 0
// 0 0 0 1 0 0
// 0 0 1 1 0 1
// 0 0 1 0 0 1
// 0 1 0 0 1 0
function encontrar_bordes($relieve){
	$surface_lenght = count($relieve);
	$surface = [];
	for ($x=0; $x < $surface_lenght; $x++) { 
		$terrain_lenght = count($relieve[$x]);
		
		$relief = [];
		for ($y=0; $y < $terrain_lenght; $y++) 
			$relief[] = check_reliefs($x, $y, $relieve);
		$surface[] = $relief;
	}
	return $surface;
}

function check_reliefs($x, $y, $relieve) {
	$current = $relieve[$x][$y];
	$surface_lenght = count($relieve) - 1;	
	$terrain_lenght = count($relieve[$x]) - 1;

	$values = [];
	if ($x == 0) {
		$values[] = get_down($x, $y, $relieve);
	} elseif ($x == $surface_lenght) {
		$values[] = get_top($x, $y, $relieve);		
	} else {
		$values[] = get_down($x, $y, $relieve);
		$values[] = get_top($x, $y, $relieve);
	}	

	if ($y == 0) {
		$values[] = get_right($x, $y, $relieve);
	} elseif ($y == $terrain_lenght) {
		$values[] = get_left($x, $y, $relieve);
	} else {
		$values[] = get_right($x, $y, $relieve);
		$values[] = get_left($x, $y, $relieve);
	}
	return is_edge($current, $values);
}

function is_edge($current, $compare) {
	$newCompare = $compare;
	$newCompare[] = $current;

	if (equal($newCompare))
		return 0;
	
	$relief_test = [];
	for ($i=0; $i < count($compare); $i++) 
		$relief_test[] = possible_edge($compare[$i], $current);
	
	if ( in_array(0, $relief_test, True) )
		return 0;
	return 1;	
}

function possible_edge($terrain, $current) {
	$value = $current <= $terrain;
	return (int)$value;
}

function equal($array) {
    $first_value = current($array);
    foreach ($array as $value) 
        if ($first_value !== $value) 
            return false;
    return true;
}

function get_left($x, $y, $relieve) {
	return $relieve[$x][$y - 1];
}

function get_right($x, $y, $relieve) {
	return $relieve[$x][$y + 1];
}

function get_top($x, $y, $relieve) {
	return $relieve[$x - 1][$y];
}

function get_down($x, $y, $relieve) {
	return $relieve[$x + 1][$y];
}

function print_edges($surface) {
	print ("\n");
	foreach ($surface as $terrain) {
		foreach ($terrain as $value) {
			print $value . ' ';
		}
		print("\n");
	}
}

print_edges(encontrar_bordes($relieve));
print("\n--------------------------------");
print_edges($relieve);
?>