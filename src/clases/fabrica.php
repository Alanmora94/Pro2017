<?php 

class Fabrica
{
	
	private $razon;
	private $empleados= array();

	function __construct($raz)
	{
		
		$this->razon = $raz;
	}



	public function Agregar($aux){


		array_push($this->empleados, $aux);

	}


	public function Eliminar($dn){

		$auxArr = array();

		foreach ($aux as $this->empleados) {
				
				if ($aux->GetDni() != $dn) {
					
					array_push($au, $aux);
				}
			}	
		$this->empleados = $auxArr;	
	}





}


 ?>