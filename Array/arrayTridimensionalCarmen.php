<?php

//Hace los arrays de manera independiente para luego unirlos

$españa=array("madrid"=>array("nombre"=>"Madrid",
								"ext"=>"400000",
								"hab"=>4000000),
				"teruel"=>array("nombre"=>"Teruel",
								"ext"=>"500000",
								"hab"=>100000),
				"barcelona"=>array("nombre"=>"Barcelona",
								"ext"=>"300000",
								"hab"=>5000000));


$francia=array("paris"=>array("nombre"=>"Paris",
								"ext"=>"600000",
								"hab"=>8000000),
				"lyon"=>array("nombre"=>"Lyon",
								"ext"=>"200000",
								"hab"=>500000));
$portugal=array("lisboa"=>array("nombre"=>"Lisboa",
								"ext"=>"300000",
								"hab"=>2000000),
				"porto"=>array("nombre"=>"Porto",
								"ext"=>"200000",
								"hab"=>100000),
				"coimbra"=>array("nombre"=>"Coimbra",
								"ext"=>"300000",
								"hab"=>600000));	
$alemania=array("Hesse"=>array("nombre"=>"Wiesbaden",
								"ext"=>"21000000",
								"hab"=>4000000),
				"Hamburgo"=>array("nombre"=>"Hamburgo",
								"ext"=>"725000",
								"hab"=>1000000));

//Une los paises en un array
$paises = array ("España"=>$españa,
				"Francia"=>$francia,
				"Portugal"=>$portugal,
				"Alemania"=>$alemania);
				
$pais=current($paises);
echo '<br>';			


$provincia=current($pais);
$titulos=array_keys($provincia);
echo '<br>';			


foreach ($paises as $key=>$pais){
	echo '<br>'.$key.'<br>';
	echo '<table>';
	foreach($titulos as $valor)
	 	echo '<th>'.$valor.'</th>';
	foreach($pais as $provincia){
		echo '<tr>';
		foreach ($provincia as $dato)
			echo '<td>'.$dato.'</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
			
?>