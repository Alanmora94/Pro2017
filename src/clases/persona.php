<?php 

/**
* 
*/
abstract class Persona
{
	
	protected $nombre;
	protected $apellido;
	protected $fnacimiento;
	protected $dni;
	protected $sexo;


	function __construct($nom, $ape, $fn, $dn, $sex)
	{
		$this->nombre = $nom;
		$this->apellido = $ape;
		$this->fnacimiento = $fn;
		$this->dni = $dn;
		$this->sexo = $sex;

	}

	abstract function GetSexo();
	abstract function GetNombre();
	abstract function GetApellido();	
	abstract function GetNacimiento();
	abstract function GetDni();

	function Grabar(){

		return $this->nombre."-".$this->apellido."-".$this->fnacimiento."-".$this->dni."-".$this->sexo;

	}

	function ToString(){

		return $this->nombre."#".$this->apellido."#".$this->fnacimiento."#".$this->dni."#".$this->sexo;

	}


}

 ?>