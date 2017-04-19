<?php 

	require_once("PDO.php");	
	require_once("persona.php");	

	/**
	* 
	*/
	class Empleado extends Persona
	{
		
		private $legajo;
		private $foto;
		private $sueldo;
		private $experi;


		function __construct($nom=null,$ape=null,$fn=null,$dn=null,$sex=null,$leg=null,$fot=null,$su=null,$expe=null)
		{

				if (isset($nom)) {

					parent::__construct($nom,$ape,$fn,$dn,$sex);

					$this->legajo = $leg;
					$this->sueldo = $su;
					$this->experi = $expe;

					if (isset($fot)) {
						$this->foto = $fot;
					}else{
						$this->foto = "";
					}

				}
		}



		public function GetNombre(){

			return $this->nombre;
		}

		function GetApellido(){

			return $this->apellido;
		}

		function GetNacimiento(){

			return $this->fnacimiento;
		}

		function GetDni(){

			return $this->dni;
		}

		function GetSexo(){

			return $this->sexo;
		}
	

		function GetLegajo(){

			return $this->legajo;
		}

		function GetFoto(){

			return $this->foto;
		}

		function GetSueldo(){

			return $this->sueldo;
		}


		function GetExperiencia(){

			return $this->experi;
		}


	


		/////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////

		function SetNombre($nom){

			$this->nombre = $nom;
		}

		function SetApellido($ape){

			$this->apellido = $ape;
		}

		function SetNacimiento($fn){

			$this->fnacimiento = $fn;
		}

		function SetDni($dn){

			$this->dni = $dn;
		}

		function SetLegajo($leg){

			$this->legajo = $leg;
		}

		function SetFoto($fot){

			$this->foto = $fot;
		}

		function SetSueldo($su){

			$this->sueldo = $su;
		}

		function SetExperiencia($expe){

			$this->experi = $expe;
		}

		function SetSexo($sex){

			$this->sexo = $sex;
		}

		

		function Grabar(){

			return parent::Grabar()."-".$this->foto."-".$this->sueldo."-".$this->legajo."-".$this->experi;

		}


//$nom,$ape,$fn,$dn,$sex,$leg,$fot=null,$su,$expe



		function ToString(){

			return parent::ToString()."#".$this->legajo."#".$this->foto."#".$this->sueldo."#".$this->experi."\r\n";

		}


		public static function ValidarFoto(){

			$result["valor"] = true;

			$destino = "temp/" . date("Ymd_His");

			$foto = $_FILES["foto"];

			if (!getimagesize($foto["tmp_name"])) {
				$result["valor"] = false;
				$result["Mensaje"] = "El archivo seleccionado no es una imagen...";
				return $result;
			}

			if ($foto["size"] > 5000000) {
				$result["valor"] = false;
				$result["Mensaje"] = "La imagen seleccionada es muy grande...";
				return $result;
			}

			$extension = pathinfo($foto["name"], PATHINFO_EXTENSION);

			if ($extension != "jpg" && $extension != "map" && $extension != "gif" && $extension != "jpeg") {
				$result["valor"] = false;
				$result["Mensaje"] = "El formato de la imagen no es compatible...";
				return $result;
			}	

			$destino = $destino . "." .$extension;
			if (!move_uploaded_file($foto["tmp_name"], $destino)) {
				$result["valor"] = false;
				$result["Mensaje"] = "Error al tratar de mover el archivo...";
				return $result;
			}else{
				$result["Html"] = "<img src='".$destino."' class='fotoT'><br><button onclick='BorrarFoto()' style='width:160px; height:25px; opacity: 1;' class='transi boton'>Borrar Foto</button>
				<input type='hidden' id='bandera' name='bandera' value='".$destino."'>";
				return $result;
			}

		}



		public static function BorrarFoto($path){

			$result["valor"] = true;

			if (!unlink($path)) {
				
				$result["valor"] = false;
				$result["mensaje"] = "Error al tratar de borrar la imagen...";
			}

			return $result;

		}


		public static function MoverFoto($emple){

			$aux = explode("/", $emple->Getfoto());
			copy($emple->Getfoto(), "imagenes/" . $aux[1]);
			unlink($emple->Getfoto());
			$emple->Setfoto("imagenes/" . $aux[1]);

		}


		public static function BorrarRegistro($aux){

			$conexion = new conexion();
			$query = $conexion->Consulta("DELETE FROM empleados WHERE legajo = :leg");
			$query->bindValue(':leg',$aux, PDO::PARAM_INT);	
			$query->execute();
			return $query->rowCount();

		}


		public static function GrabarRegistro($emple){

			$resu = false;

			if ($emple->foto != "") {
				
				Empleado::MoverFoto($emple);
			}

			$arc = fopen("empleados.txt", "a");

			$cant = fwrite($arc, $emple->ToString());

			fclose($arc);

			Empleado::AltaEnBD($emple);

			if ($cant > 0) {

				$resu = true;

			}

			return $resu;

		}

		public static function AltaEnBD($obj){

			$conexion = new conexion();
			$query = $conexion->Consulta("INSERT into empleados (nombre, apellido, Fnacimiento, dni, sexo, legajo, foto, sueldo, experiencia) VALUES ('$obj->nombre','$obj->apellido','$obj->fnacimiento','$obj->dni','$obj->sexo','$obj->legajo','$obj->foto','$obj->sueldo','$obj->experi')");
				$query->execute();

		}

		public static function TraerUnEmpleado($leg) 
			{
			$conexion = new conexion();
			$query = $conexion->Consulta("SELECT nombre, apellido, Fnacimiento, dni, sexo, legajo, foto, sueldo, experiencia from empleados where legajo = $leg");
			$query->execute();
			$EmpleadoBuscado = $query->fetchObject('Empleado');
			return $EmpleadoBuscado;

			}


			public static function TraerTodos(){

			$lista = array();

			if (file_exists("empleados.txt")) {
							
				$arc = fopen("empleados.txt", "r");

				while (!feof($arc)) {
					
					$linea = fgets($arc);

					if ($linea != "") {
						
						$aux = explode("#", $linea);

						array_push($lista, new Empleado($aux[0], $aux[1], $aux[2], $aux[3], $aux[4], $aux[5], $aux[6], $aux[7], rtrim($aux[8])));
					}
				}
				fclose($arc);
			}


			return $lista;

		}



		public static function Eliminar($leg){

            $resul = false;
            $lista = Empleado::TraerTodos();
            $listaF = array();

            if (isset($lista) && count($lista) > 0 ) {

                foreach ($lista as $emple) {
                    
                    if ($leg != $emple->GetLegajo()) {
                        
                        array_push($listaF, $emple);
                    }else{
                        $resul = true;
                    }
                }
                    $arc = fopen("empleados.txt", "w");
                  foreach ($listaF as $emple) {
                        
                    fwrite($arc, $emple->ToString());
                }
                fclose($arc);
            }

           // return $resul;
        }






	}
/*

$query = $conexion->Consulta("INSERT into empleados (nombre, apellido, Fnacimiento, dni, sexo, legajo, foto, sueldo, experiencia) VALUES ($obj->GetNombre(),'$obj->GetApellido()','$obj->GetNacimiento()','$obj->GetDni()','$obj->GetSexo()','$obj->GetLegajo()','$obj->GetFoto()','$obj->GetSueldo()','$obj->GetExperiencia()')");
 */
 ?>